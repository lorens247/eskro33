<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Escrow;
use App\Models\EscrowCharge;
use App\Models\EscrowType;
use App\Models\GeneralSetting;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EscrowController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index($type = null)
    {
        $pageTitle = 'My Escrow';
        $escrows = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->with('seller','buyer');

        if ($type == 'accepted') {
            $escrows = $escrows->where('status',2);
        }

        if ($type == 'not-accepted') {
            $escrows = $escrows->where('status',0);
        }

        if ($type == 'completed') {
            $escrows = $escrows->where('status',1);
        }

        if ($type == 'cancelled') {
            $escrows = $escrows->where('status',9);
        }

        if ($type == 'disputed') {
            $escrows = $escrows->where('status',8);
        }

        $escrows = $escrows->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'Escrow not found';
        return view($this->activeTemplate.'user.escrow.index',compact('pageTitle','escrows','emptyMessage'));
    }

    public function create(){
        $pageTitle = 'Create Escrow';
        $types = EscrowType::where('status',1)->get();
        return view($this->activeTemplate.'user.escrow.create',compact('pageTitle','types'));
    }

    public function nextToStore(Request $request){
        $request->validate([
            'me_type'=>'required|in:1,2',
            'amount'=>'required|numeric|gt:0',
            'escrow_type'=>'required|exists:escrow_types,id'
        ]);

        $charge = $this->getCharge($request->amount);

        $data = $request->except('_token');
        $data['charge'] = $charge;
        session()->put('escrow_info',$data);
        return redirect()->route('user.escrow.submit');
    }

    public function escrowSubmit(){
        $escrowInfo = session('escrow_info');
        if (!$escrowInfo) {
            $notify[] = ['info','Please fill up this form first'];
            $notify[] = ['error','The session is invalid'];
            return redirect()->route('user.escrow.create')->withNotify($notify);
        }
        $pageTitle = 'Submit Escrow';
        return view($this->activeTemplate.'user.escrow.submit',compact('pageTitle','escrowInfo'));
    }

    public function escrowStore(Request $request){
        $request->validate([
            'email'=>'required',
            'title'=>'required',
            'details'=>'required',
            'charge_payer'=>'required|in:1,2,3',
        ]);

        //check session
        $escrowInfo = session('escrow_info');
        if (!$escrowInfo) {
            $notify[] = ['info','Please fill up this form first'];
            $notify[] = ['error','The session is invalid'];
            return redirect()->route('user.escrow.create')->withNotify($notify);
        }

        $user = auth()->user();
        //check user
        $toUser = User::where('email',$request->email)->first();

        $type = EscrowType::where('status',1)->where('id',$escrowInfo['escrow_type'])->first();
        if (!$type) {
            $notify[] = ['error','Invalid escrow type'];
            return redirect()->route('user.escrow.create')->withNotify($notify);
        }

        $amount = $escrowInfo['amount'];
        $charge = $charge = $this->getCharge($amount);

        $sellerCharge = 0;
        $buyerCharge = 0;
        if ($request->charge_payer == 1) {
            $sellerCharge = $charge;
        }elseif($request->charge_payer == 2){
            $buyerCharge = $charge;
        }else{
            $sellerCharge = $charge / 2;
            $buyerCharge = $charge / 2;
        }

        $escrow = new Escrow();
        if ($escrowInfo['me_type'] == 1) {
            $escrow->seller_id = $user->id;
            $escrow->buyer_id = @$toUser->id ?? 0;
        }else{
            $escrow->buyer_id = $user->id;
            $escrow->seller_id = @$toUser->id ?? 0;
        }

        $escrow->creator_id = $user->id;
        $escrow->amount = $amount;
        $escrow->charge_payer = $request->charge_payer;
        $escrow->charge = $charge;
        $escrow->buyer_charge = $buyerCharge;
        $escrow->seller_charge = $sellerCharge;
        $escrow->type = $type->name;
        $escrow->title = $request->title;
        $escrow->details = $request->details;
        if (!$toUser) {
            $escrow->invitation_mail = $request->email;
        }
        $escrow->save();

        $conversation = new Conversation;
        $conversation->escrow_id = $escrow->id;
        $conversation->buyer_id = $escrow->buyer_id;
        $conversation->seller_id = $escrow->seller_id;
        $conversation->save();

        $message = 'Escrow created successfully';
        if (!$toUser) {
            $mailReceiver = (object)['fullname'=>$request->email,'username'=>$request->email,'email'=>$request->email];
            notify($mailReceiver,'INVITATION_LINK',[
                'link'=>route('user.register'),
            ],['email'],false);
            $message = 'Escrow created and invitation link sent successfully';
        }
        session()->forget('escrow_info');
        $notify[] = ['success',$message];
        return redirect()->route('user.escrow')->withNotify($notify);

    }

    private function getCharge($amount){
        $general = GeneralSetting::first();
        $percentCharge = $general->percent_charge;
        $fixedCharge = $general->fixed_charge;
        $escrowCharge = EscrowCharge::where('minimum','<=',$amount)->where('maximum','>=',$amount)->first();
        if ($escrowCharge) {
            $percentCharge = $escrowCharge->percent_charge;
            $fixedCharge = $escrowCharge->fixed_charge;
        }

        $charge = ($amount * $percentCharge) / 100 + $fixedCharge;

        if ($charge > $general->charge_cap) {
            $charge = $general->charge_cap;
        }
        return $charge;
    }

    public function escrowDetails($hash)
    {
        $pageTitle = 'Escrow Details';
        $id = decrypt($hash);
        $escrow = Escrow::where('id',$id)->where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->with('conversation','conversation.messages','conversation.messages.sender','conversation.messages.admin')->firstOrFail();
        $restAmo = ($escrow->amount + $escrow->buyer_charge) - $escrow->paid_amount;
        $conversation = $escrow->conversation;
        $messages = $conversation->messages;
        return view($this->activeTemplate.'user.escrow.details',compact('pageTitle','escrow','restAmo','conversation','messages'));
    }

    public function escrowCancel($hash)
    {
        $id = decrypt($hash);
        $escrow = Escrow::where(function($query){
                        $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
                  })->where('status',0)->findOrFail($id);
        $escrow->status = 9;
        $escrow->save();
        $amount = $escrow->paid_amount;
        $general = GeneralSetting::first();
        if ($escrow->buyer_id = auth()->id()) {
            $mailReceiver = $escrow->seller;
            $canceller = 'buyer';
        }else{
            $mailReceiver = $escrow->buyer;
            $canceller = 'seller';
        }

        if ($amount > 0) {
            $user = $escrow->buyer;
            $user->balance += $amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Milestone amount refunded for cancelling the escrow';
            $transaction->trx = getTrx();
            $transaction->save();
        }
        $conversation = $escrow->conversation;
        $conversation->status = 0;
        $conversation->save();

        notify($mailReceiver,'ESCROW_CANCELLED',[
            'title'=>$escrow->title,
            'amount'=>showAmount($escrow->amount),
            'canceller'=>$canceller,
            'total_fund'=>showAmount($amount),
            'currency'=>$general->cur_text,
        ]);

        $notify[] = ['success','Escrow cancelled successfully'];
        return back()->withNotify($notify);
    }

    public function escrowAccept($hash)
    {
        $id = decrypt($hash);
        $escrow = Escrow::where(function($query){
                    $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
                })->where('creator_id','!=',auth()->id())->where('status',0)->findOrFail($id);

        $escrow->status = 2;
        $escrow->save();

        $general = GeneralSetting::first();
        if ($escrow->buyer_id = auth()->id()) {
            $mailReceiver = $escrow->seller;
            $accepter = 'buyer';
        }else{
            $mailReceiver = $escrow->buyer;
            $accepter = 'seller';
        }

        notify($mailReceiver,'ESCROW_ACCEPTED',[
            'title'=>$escrow->title,
            'amount'=>showAmount($escrow->amount),
            'accepter'=>$accepter,
            'total_fund'=>showAmount($escrow->paid_amount),
            'currency'=>$general->cur_text,
        ]);

        $notify[] = ['success','Escrow accepted successfully'];
        return back()->withNotify($notify);
    }

    public function escrowDispatch(Request $request){
        $request->validate([
            'escrow_id'=>'required|exists:escrows,id',
        ]);
        $escrow = Escrow::where('buyer_id',auth()->user()->id)->where('status',2)->findOrFail($request->escrow_id);
        $escrow->status = 1;
        $escrow->save();

        $amount = $escrow->amount;
        $seller = $escrow->seller;
        $seller->balance += $amount;
        $seller->save();

        $trx = getTrx();
        $transaction = new Transaction();
        $transaction->user_id = $seller->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $seller->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Escrow payment withdrawals';
        $transaction->trx = $trx;
        $transaction->save();

        if ($escrow->seller_charge > 0) {
            $seller->balance -= $escrow->seller_charge;
            $seller->save();

            $transaction = new Transaction();
            $transaction->user_id = $seller->id;
            $transaction->amount = $escrow->seller_charge;
            $transaction->post_balance = $seller->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Escrow charge pay';
            $transaction->trx = $trx;
            $transaction->save();
        }
        $general = GeneralSetting::first();
        notify($seller,'ESCROW_PAYMENT_DISPATCHED',[
            'title'=>$escrow->title,
            'amount'=>showAmount($escrow->amount),
            'charge'=>showAmount($escrow->charge),
            'seller_charge'=>showAmount($escrow->seller_charge),
            'trx'=>$trx,
            'post_balance'=>showAmount($seller->balance),
            'currency'=>$general->cur_text,
        ]);

        $notify[] = ['success','Escrow payment dispatched successfully'];
        return back()->withNotify($notify);
    }

    public function escrowDispute(Request $request){
        $request->validate([
            'escrow_id'=>'required|exists:escrows,id',
            'details'=>'required',
        ]);
        $escrow = Escrow::where(function($query){
                    $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
                  })->where('status','!=',8)->where('status','!=',9)->findOrFail($request->escrow_id);

        $escrow->status = 8;
        $escrow->disputer_id = auth()->id();
        $escrow->dispute_note = $request->details;
        $escrow->save();

        $conversation = $escrow->conversation;
        $conversation->is_group = 1;

        $conversation->save();

        $general = GeneralSetting::first();
        if ($escrow->buyer_id = auth()->id()) {
            $mailReceiver = $escrow->seller;
            $disputer = 'buyer';
        }else{
            $mailReceiver = $escrow->buyer;
            $disputer = 'seller';
        }

        notify($mailReceiver,'ESCROW_DISPUTED',[
            'title'=>$escrow->title,
            'amount'=>showAmount($escrow->amount),
            'disputer'=>$disputer,
            'total_fund'=>showAmount($escrow->paid_amount),
            'dispute_note'=>$request->details,
            'currency'=>$general->cur_text,
        ]);

        $notify[] = ['success','Escrow disputed successfully'];
        return back()->withNotify($notify);
    }

    public function milestones($hash){
        $pageTitle = 'Escrow Milestones';
        $id = decrypt($hash);
        $escrow = Escrow::where('id',$id)->where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->firstOrFail();
        $milestones = Milestone::where('escrow_id',$escrow->id)->orderBy('id','desc')->paginate(getPaginate());
        $restAmo = ($escrow->amount + $escrow->buyer_charge) - $escrow->paid_amount;
        $emptyMessage = 'No milestone found';
        return view($this->activeTemplate.'user.escrow.milestones',compact('pageTitle','emptyMessage','escrow','milestones','restAmo'));
    }

    public function milestoneCreate(Request $request){
        $request->validate([
            'escrow_id'=>'required|exists:escrows,id',
            'amount'=>'required|numeric|gt:0',
        ]);
        $escrow = Escrow::where('buyer_id',auth()->user()->id)->where('status','!=',8)->where('status','!=',9)->findOrFail($request->escrow_id);
        $restAmo = ($escrow->amount + $escrow->buyer_charge) - $escrow->paid_amount;
        if ($request->amount > $restAmo) {
            $notify[] = ['error','Your milestone couldn\'t be greater than rest amount'];
            return back()->withNotify($notify);
        }
        $milestone = new Milestone;
        $milestone->escrow_id = $escrow->id;
        $milestone->user_id = auth()->id();
        $milestone->amount = $request->amount;
        $milestone->note = $request->note;
        $milestone->save();

        $notify[] = ['success','Milestone created successfully'];
        return back()->withNotify($notify);
    }

    public function milestonePay(Request $request){
        $request->validate([
            'pay_via'=>'required|in:1,2',
            'milestone_id'=>'required|exists:milestones,id'
        ]);

        $milestone = Milestone::where('payment_status',0)->whereHas('escrow',function($query){
            $query->where('buyer_id',auth()->user()->id)->where('status','!=',8)->where('status','!=',9);
        })->findOrFail($request->milestone_id);

        $user = auth()->user();

        if ($request->pay_via == 2) {
            session()->put('checkout',encrypt([
                'amount'=>$milestone->amount,
                'milestone_id'=>$milestone->id,
            ]));
            return redirect()->route('user.deposit','checkout');
        }

        if ($user->balance < $milestone->amount) {
            $notify[] = ['error','You have no sufficient balance'];
            return back()->withNotify($notify);
        }

        $user->balance -= $milestone->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $milestone->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Milestone paid for '.$milestone->escrow->title;
        $transaction->trx = getTrx();
        $transaction->save();

        $milestone->payment_status = 1;
        $milestone->save();

        $escrow = $milestone->escrow;
        $escrow->paid_amount += $milestone->amount;
        $escrow->save();

        $notify[] = ['success','Milestone paid successfully'];
        return back()->withNotify($notify);
    }

    public function messageReply(Request $request){
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
            'message' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        $conversation = Conversation::where('id',$request->conversation_id)->where(function($query){
            $query->orWhere('buyer_id',auth()->id())->orWhere('seller_id',auth()->id());
        })->where('status',1)->first();
        if (!$conversation) {
            return response()->json(['error'=>['Conversation not found']]);
        }
        $message = new Message();
        $message->sender_id = auth()->id();
        $message->conversation_id = $conversation->id;
        $message->message = $request->message;
        $message->save();

        return [
            'created_diff'=> $message->created_at->diffForHumans(),
            'created_time'=> $message->created_at->format('h:i A'),
            'message'=> $message->message,
        ];
    }

    public function getMessages(Request $request){
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $conversation = Conversation::where('id',$request->conversation_id)->where(function($query){
            $query->orWhere('buyer_id',auth()->id())->orWhere('seller_id',auth()->id());
        })->first();
        if (!$conversation) {
            return response()->json(['error'=>['Conversation not found']]);
        }
        $escrow = $conversation->escrow;
        $messages = Message::where('conversation_id',$conversation->id)->with('sender','admin')->get();
        return view($this->activeTemplate.'user.escrow.message',compact('messages','escrow'));
    }

}
