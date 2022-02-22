<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function tickets()
    {
        $pageTitle = 'All Support Tickets';
        $emptyMessage = 'No support ticket found';
        $items = SupportTicket::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function pendingTicket()
    {
        $pageTitle = 'Pending Support Tickets';
        $emptyMessage = 'No pending support ticket found';
        $items = SupportTicket::whereIn('status', [0,2])->orderBy('priority', 'DESC')->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function closedTicket()
    {
        $emptyMessage = 'No closed support ticket found';
        $pageTitle = 'Closed Support Tickets';
        $items = SupportTicket::where('status',3)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle','emptyMessage'));
    }

    public function answeredTicket()
    {
        $pageTitle = 'Answered Support Tickets';
        $emptyMessage = 'No answered support ticket found';
        $items = SupportTicket::orderBy('id','desc')->with('user')->where('status',1)->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle','emptyMessage'));
    }


    public function ticketReply($id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $pageTitle = 'Reply Ticket';
        $messages = SupportMessage::with('ticket','attachments','admin')->where('support_ticket_id', $ticket->id)->orderBy('id','desc')->get();
        return view('admin.support.reply', compact('ticket', 'messages', 'pageTitle'));
    }
    public function ticketReplySend(Request $request, $id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $message = new SupportMessage();
        if ($request->replayTicket == 1) {

            $attachments = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');

            $request->validate([
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($attachments, $allowedExts) {
                        foreach ($attachments as $attachment) {
                            $ext = strtolower($attachment->getClientOriginalExtension());
                            if (($attachment->getSize() / 1000000) > 2) {
                                return $fail("Maximum allowed file size is 2MB");
                            }

                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Allowed file types are png, jpg, jpeg, pdf, doc, docx");
                            }
                        }
                        if (count($attachments) > 5) {
                            return $fail("Maximum 5 files can be uploaded");
                        }
                    }
                ],
                'message' => 'required',
            ]);
            $ticket->status = 1;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->support_ticket_id = $ticket->id;
            $message->admin_id = Auth::guard('admin')->id();
            $message->message = $request->message;
            $message->save();

            $path = fileManager()->ticket()->path;
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = fileUploader($file, $path);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        $notify[] = ['error', $file.' file couldn\'t upload'];
                        return back()->withNotify($notify)->withInput();
                    }
                }
            }

            $createLog = false;
            $user = $ticket;
            if ($ticket->user_id != 0) {
                $createLog = true;
                $user = $ticket->user;
            }

            notify($user, 'ADMIN_SUPPORT_REPLY', [
                'ticket_id' => $ticket->ticket,
                'ticket_subject' => $ticket->subject,
                'reply' => $request->message,
                'link' => route('ticket.view',$ticket->ticket),
            ],null,$createLog);

            $notify[] = ['success', "Your reply sent successfully"];

        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->save();
            $notify[] = ['success', "Support ticket closed successfully"];
        }
        return back()->withNotify($notify);
    }


    public function ticketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->attachment;


        $path = fileManager()->ticket()->path;

        $full_path = $path.'/' . $file;
        $title = slug($attachment->supportMessage->ticket->subject).'-'.$file;
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }
    public function ticketDelete(Request $request)
    {
        $message = SupportMessage::findOrFail($request->message_id);
        $path = fileManager()->ticket()->path;
        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $attachment) {
                fileManager()->removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Message deleted successfully"];
        return back()->withNotify($notify);

    }

}
