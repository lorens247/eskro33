<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Escrow;
use App\Models\GeneralSetting;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EscrowController extends Controller
{
    public function index(){
        $pageTitle = 'All Escrows';
        $escrows = Escrow::orderBy('id','desc')->with('seller','buyer')->paginate(getPaginate());
        $emptyMessage = 'Escrow not found';
        return view('admin.escrow.list',compact('pageTitle','escrows','emptyMessage'));
    }

    public function accepted()
    {
        $pageTitle = 'Accepted Escrows';
        $escrows = Escrow::orderBy('id','desc')->where('status',2)->with('seller','buyer')->paginate(getPaginate());
        $emptyMessage = 'Accepted escrow not found';
        return view('admin.escrow.list',compact('pageTitle','escrows','emptyMessage'));
    }

    public function notAccepted()
    {
        $pageTitle = 'Not Accepted Escrows';
        $escrows = Escrow::orderBy('id','desc')->where('status',0)->with('seller','buyer')->paginate(getPaginate());
        $emptyMessage = 'Not accepted escrow not found';
        return view('admin.escrow.list',compact('pageTitle','escrows','emptyMessage'));
    }

    public function completed()
    {
        $pageTitle = 'Completed Escrows';
        $escrows = Escrow::orderBy('id','desc')->where('status',1)->with('seller','buyer')->paginate(getPaginate());
        $emptyMessage = 'Completed escrow not found';
        return view('admin.escrow.list',compact('pageTitle','escrows','emptyMessage'));
    }

    public function disputed()
    {
        $pageTitle = 'Disputed Escrows';
        $escrows = Escrow::orderBy('id','desc')->where('status',8)->with('seller','buyer')->paginate(getPaginate());
        $emptyMessage = 'Disputed escrow not found';
        return view('admin.escrow.list',compact('pageTitle','escrows','emptyMessage'));
    }

    public function cancelled()
    {
        $pageTitle = 'Cancelled Escrows';
        $escrows = Escrow::orderBy('id','desc')->where('status',9)->with('seller','buyer')->paginate(getPaginate());
        $emptyMessage = 'Cancelled escrow not found';
        return view('admin.escrow.list',compact('pageTitle','escrows','emptyMessage'));
    }

    public function details($id)
    {
        $pageTitle = 'Escrow Details';
        $escrow = Escrow::with('conversation','conversation.messages','conversation.messages.sender','conversation.messages.admin')->findOrFail($id);
        $restAmo = ($escrow->amount + $escrow->buyer_charge) - $escrow->paid_amount;
        $conversation = $escrow->conversation;
        $messages = $conversation->messages;
        return view('admin.escrow.details',compact('pageTitle','escrow','restAmo','conversation','messages'));
    }

    public function milestone($id){
        $pageTitle = 'Escrow Milestone';
        $escrow = Escrow::findOrFail($id);
        $milestones = Milestone::where('escrow_id',$escrow->id)->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No milestone found';
        return view('admin.escrow.milestones',compact('pageTitle','escrow','milestones','emptyMessage'));
    }

    public function messageReply(Request $request){
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
            'message' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        $conversation = Conversation::where('status',1)->findOrFail($request->conversation_id);
        if (!$conversation) {
            return response()->json(['error'=>['Conversation not found']]);
        }
        $escrow = $conversation->escrow;
        if ($escrow->status != 8) {
            return response()->json(['error'=>['You couldn\'t attend to this conversation']]);
        }
        $message = new Message();
        $message->admin_id = auth()->guard('admin')->id();
        $message->conversation_id = $conversation->id;
        $message->message = $request->message;
        $message->save();

        return [
            'created_diff'=> $message->created_at->diffForHumans(),
            'created_time'=> $message->created_at->format('h:i A'),
            'message'=> $message->message,
        ];
    }

    public function messageGet(Request $request){
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        $conversation = Conversation::findOrFail($request->conversation_id);
        $messages = Message::where('conversation_id',$conversation->id)->with('sender','admin')->get();
        $escrow = $conversation->escrow;
        return view('admin.escrow.message',compact('messages','escrow'));
    }

    public function action(Request $request)
    {
        $request->validate([
            'escrow_id'=>'required|integer|exists:escrows,id',
            'buyer_amount'=>'required|numeric|gte:0',
            'seller_amount'=>'required|numeric|gte:0',
            'status'=>'required|integer|in:1,9',
        ]);
        $escrow = Escrow::where('status',8)->findOrFail($request->escrow_id);
        $escrow->status = $request->status;
        $escrow->save();

        $buyer = $escrow->buyer;
        $seller = $escrow->seller;
        $trx = getTrx();
        $charge = $escrow->paid_amount - ($request->buyer_amount+$request->seller_amount);
        if ($charge < 0) {
            $notify[] = ['error','You couldn\'t transact greater than funded amount'];
            return back()->withNotify($notify);
        }
        if ($request->buyer_amount > 0) {
            $buyer->balance += $request->buyer_amount;
            $buyer->save();
            $transaction = new Transaction();
            $transaction->user_id = $buyer->id;
            $transaction->amount = $request->buyer_amount;
            $transaction->post_balance = $buyer->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Admin has taken action to the escrow and send this amount to you';
            $transaction->trx = $trx;
            $transaction->save();
        }

        if ($request->seller_amount > 0) {
            $seller->balance += $request->seller_amount;
            $seller->save();
            $transaction = new Transaction();
            $transaction->user_id = $seller->id;
            $transaction->amount = $request->seller_amount;
            $transaction->post_balance = $seller->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Admin has taken action to the escrow and send this amount to you';
            $transaction->trx = $trx;
            $transaction->save();
        }
        $general = GeneralSetting::first();
        notify($buyer,'ESCROW_ADMIN_ACTION',[
            'title'=>$escrow->title,
            'amount'=>showAmount($escrow->amount),
            'total_fund'=>showAmount($escrow->paid_amount),
            'seller_amount'=>showAmount($request->seller_amount),
            'buyer_amount'=>showAmount($request->buyer_amount),
            'charge'=>showAmount($charge),
            'trx'=>$trx,
            'post_balance'=>showAmount($buyer->balance),
            'currency'=>$general->cur_text,
        ]);
        notify($seller,'ESCROW_ADMIN_ACTION',[
            'title'=>$escrow->title,
            'amount'=>showAmount($escrow->amount),
            'total_fund'=>showAmount($escrow->paid_amount),
            'seller_amount'=>showAmount($request->seller_amount),
            'buyer_amount'=>showAmount($request->buyer_amount),
            'charge'=>showAmount($charge),
            'trx'=>$trx,
            'post_balance'=>showAmount($seller->balance),
            'currency'=>$general->cur_text,
        ]);

        $conversation = $escrow->conversation;
        $conversation->status = 0;
        $conversation->save();

        $notify[] = ['success','Escrow action taken successfully'];
        return back()->withNotify($notify);
    }
}
