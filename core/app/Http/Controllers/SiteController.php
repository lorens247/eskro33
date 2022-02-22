<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\EscrowType;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        $types = EscrowType::where('status',1)->get();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections','types'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','contact')->first();
        return view($this->activeTemplate . 'contact',compact('pageTitle','sections'));
    }


    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket created';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Support ticket created successfully'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogs(){
        $pageTitle = 'Blogs';
        $blogs = Frontend::orderBy('id','desc')->where('data_keys','blog.element')->paginate(16);
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->first();
        return view($this->activeTemplate.'blogs',compact('pageTitle','blogs','sections'));
    }

    public function blogDetails($slug,$id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $blogs = Frontend::where('id','!=',$id)->orderBy('id','desc')->where('data_keys','blog.element')->limit(5)->get();
        $pageTitle = 'Blog Details';
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle','blogs'));
    }


    public function cookieAccept(){
        $general = GeneralSetting::first();
        $cookie = Cookie::queue('gdpr_cookie',$general->sitename , 43200);
        return back();
    }

    public function cookiePolicy(){
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view($this->activeTemplate.'cookie',compact('pageTitle','cookie'));
    }

    public function policyPages($slug,$id){
        $data = Frontend::where('id',$id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $data->data_values->title;
        return view($this->activeTemplate.'policy',compact('data','pageTitle'));
    }


    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

}
