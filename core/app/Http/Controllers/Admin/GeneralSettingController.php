<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $general = GeneralSetting::first();
        $pageTitle = 'General Settings';
        return view('admin.setting.general_setting', compact('pageTitle', 'general'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'base_color' => 'nullable', 'regex:/^[a-f0-9]{6}$/i',
            'secondary_color' => 'nullable', 'regex:/^[a-f0-9]{6}$/i',
            'timezone' => 'required',
        ]);

        $general = GeneralSetting::first();
        $general->ev = $request->ev ? 1 : 0;
        $general->en = $request->en ? 1 : 0;
        $general->sv = $request->sv ? 1 : 0;
        $general->sn = $request->sn ? 1 : 0;
        $general->tn = $request->tn ? 1 : 0;
        $general->force_ssl = $request->force_ssl ? 1 : 0;
        $general->secure_password = $request->secure_password ? 1 : 0;
        $general->registration = $request->registration ? 1 : 0;
        $general->agree = $request->agree ? 1 : 0;
        $general->sitename = $request->sitename;
        $general->cur_text = $request->cur_text;
        $general->cur_sym = $request->cur_sym;
        $general->base_color = $request->base_color;
        $general->secondary_color = $request->secondary_color;
        $general->save();

        $timezoneFile = config_path('extra.php');
        $debug = $request->debug ? 'true' : 'false';
        $content = '<?php
                        $timezone = '.$request->timezone.';
                        $debug = '.$debug.';
                    ?>';
        file_put_contents($timezoneFile, $content);
        $notify[] = ['success', 'General settings updated successfully'];
        return back()->withNotify($notify);
    }


    public function logoIcon()
    {
        $pageTitle = 'Logo & Favicon Settings';
        return view('admin.setting.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request)
    {
        $request->validate([
            'logo' => ['image',new FileTypeValidate(['jpg','jpeg','png'])],
            'favicon' => ['image',new FileTypeValidate(['png'])],
        ]);
        if ($request->hasFile('logo')) {
            try {
                $path = fileManager()->logoIcon()->path;
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo)->save($path . '/logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Logo couldn\'t upload'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $path = fileManager()->logoIcon()->path;
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', fileManager()->favicon()->size);
                Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Favicon couldn\'t upload'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['info', 'Please clear the browser cache if you still see the old images as logo and favicon.'];
        $notify[] = ['warning', 'The change of logo and favicon may not show due to your browser cache.'];
        $notify[] = ['success', 'Logo & favicon updated successfully'];
        return back()->withNotify($notify);
    }

    public function customAssets(){
        $pageTitle = 'Custom Asset Settings';
        $general = GeneralSetting::first();
        $file = activeTemplate(true).'css/custom.css';
        $cssFile = @file_get_contents($file);
        $libFile = resource_path("views/templates/$general->active_template/partials/custom_css_lib.blade.php");
        $cssLibFile = @file_get_contents($libFile);


        $file = activeTemplate(true).'js/custom.js';
        $jsFile = @file_get_contents($file);
        $libFile = resource_path("views/templates/$general->active_template/partials/custom_js_lib.blade.php");
        $jsLibFile = @file_get_contents($libFile);
        return view('admin.setting.custom_assets',compact('pageTitle','cssFile','jsFile','cssLibFile','jsLibFile'));
    }


    public function customCssSubmit(Request $request){
        $cssfile = activeTemplate(true).'css/custom.css';
        if (!file_exists($cssfile)) {
            fopen($cssfile, "w");
        }
        file_put_contents($cssfile,$request->css);

        $general = GeneralSetting::first();

        $cssLibfile = resource_path("views/templates/$general->active_template/partials/custom_css_lib.blade.php");

        if (!@file_exists($cssLibfile)) {
            fopen($cssLibfile, "w");
        }
        file_put_contents($cssLibfile,$request->css_lib);

        $notify[] = ['success','Custom CSS updated successfully'];
        return back()->withNotify($notify);
    }


    public function customJsSubmit(Request $request){
        $file = activeTemplate(true).'js/custom.js';
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        file_put_contents($file,$request->js);

        $general = GeneralSetting::first();
        $jsLibfile = resource_path("views/templates/$general->active_template/partials/custom_js_lib.blade.php");

        if (!@file_exists($jsLibfile)) {
            fopen($jsLibfile, "w");
        }
        file_put_contents($jsLibfile,$request->js_lib);


        $notify[] = ['success','Custom JS updated successfully'];
        return back()->withNotify($notify);
    }


    public function cookie(){
        $pageTitle = 'Cookie Policy Settings';
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        return view('admin.setting.cookie',compact('pageTitle','cookie'));
    }

    public function cookieSubmit(Request $request){
        $request->validate([
            'short_desc'=>'required',
            'description'=>'required',
        ]);
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        $cookie->data_values = [
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ];
        $cookie->save();
        $notify[] = ['success','Cookie policy updated successfully'];
        return back()->withNotify($notify);
    }

    public function captcha(){
        $pageTitle = 'Captcha Settings';
        $extension = new Extension();
        $gc = $extension->where('act','google-recaptcha2')->first();
        $cc = $extension->where('act','custom-captcha')->first();
        return view('admin.setting.captcha',compact('pageTitle','gc','cc'));
    }

    public function captchaUpdate(Request $request){
        $request->validate([
            'recaptcha_site_key'=>'required',
            'recaptcha_secret_key'=>'required',
            'custom_captcha'=>'required',
        ]);
        $extension = new Extension();
        $gc = $extension->where('act','google-recaptcha2')->first();
        $gc->shortcode = [
            'sitekey'=>[
                'title'=>'Site Key',
                'value'=>$request->recaptcha_site_key
            ],
            'secretkey'=>[
                'title'=>'Secret Key',
                'value'=>$request->recaptcha_secret_key
            ]
        ];
        $gc->status = $request->g_captcha_status ? 1 : 0;
        $gc->save();
        $cc = $extension->where('act','custom-captcha')->first();
        $cc->shortcode = [
            'random_key'=>[
                'title'=>'Random String',
                'value'=>'SecureString'
            ]
        ];
        $cc->status = $request->c_captcha_status ? 1 : 0;
        $cc->save();
        $notify[] = ['success','Captcha settings updated successfully'];
        return back()->withNotify($notify);
    }
}
