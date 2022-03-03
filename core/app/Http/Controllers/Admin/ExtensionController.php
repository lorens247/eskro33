<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\FileManager;
use App\Models\GeneralSetting;
use App\Models\UploaderLog;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExtensionController extends Controller
{
    public function templates(){
        $pageTitle = 'Templates';
        $templates = getData('templates');
        $defTemps = array_filter(glob('core/resources/views/templates/*'), 'is_dir');
        foreach ($defTemps as $key => $temp) {
            $arr = explode('/', $temp);
            $tempname = end($arr);
            $temps[$key]['name'] = $tempname;
            $temps[$key]['image'] = asset($temp) . '/preview.jpg';
        }
        $myTemplates = UploaderLog::where('file_type','template')->orderBy('id','desc')->get();
        return view('admin.extension.templates',compact('pageTitle','templates','myTemplates','temps'));
    }

    public function activeTemplate($template){
        $general = GeneralSetting::first();
        $general->active_template = $template;
        $general->save();

        $notify[] = ['success', 'Template activated successfully'];
        return back()->withNotify($notify);
    }

    public function plugins(){
        $pageTitle = 'Plugins';
        $plugins = getData('plugins');
        $myPlugins = UploaderLog::where('file_type','plugin')->orderBy('id','desc')->get();
        return view('admin.extension.plugins',compact('pageTitle','plugins','myPlugins'));
    }

    public function upload(){
        $pageTitle = 'Files Upload';
        return view('admin.extension.upload',compact('pageTitle'));
    }

    public function uploadSubmit(Request $request){

        //Validation
        $request->validate([
            'purchase_code'=>'required',
            'file'=>['required',new FileTypeValidate(['zip'])]
        ]);

        //Check purchase code
        $purchaseCode = env('PURCHASE_CODE');
        if ($purchaseCode != $request->purchase_code) {
            $notify[] = ['error','Purchase code doesn\'t match'];
            return back()->withNotify($notify);
        }


        $location = 'core/temp';

        //Upload the zip file
        try{
            $fileName = fileUploader($request->file, $location);
        }catch(\Exception $e){
            $notify[] = ['error',$e->getMessage()];
            return back()->withNotify($notify);
        }

        //Extract the zip file
        $rand = Str::random(10);
        $dir = base_path('temp/' . $rand);
        $extract = $this->extractZip(base_path('temp/'.$fileName),$dir);

        //Remove Zip file
        $this->removeFile($location.'/'.$fileName);

        if ($extract == false) {
            $notify[] = ['error','Something went wrong to extract'];
            return back()->withNotify($notify);
        }


        //get config file
        if (!file_exists($dir.'/config.json')){
            $this->removeDir($dir);
            $notify[] = ['error','Config file not found'];
            return back()->withNotify($notify);
        }
        $getConfig = file_get_contents($dir.'/config.json');
        $config = json_decode($getConfig);


        //Check exist
        if($config->upload_type != 'update'){
            $exist = UploaderLog::where('file_key',@$config->file_key)->first();
            if ($exist) {
                $this->removeDir($dir);
                $notify[] = ['error','This file already has been uploaded'];
                return back()->withNotify($notify);
            }
        }

        //Check file type
        $fileType = @$config->file_type;
        $extraPurchaseCode = null;
        if ($fileType != 'project') {
            if (!$request->extra_purchase_code) {
                $notify[] = ['error','Template / plugin purchase code is required'];
                return back()->withNotify($notify);
            }
            $extraPurchaseCode = $request->extra_purchase_code;
        }

        $response = getData('upload',[
            'extra_purchase_code'=>$extraPurchaseCode,
            'file_key'=>$config->file_key,
            'file_type'=>$config->file_type,
        ]);
        if($response->type == 'error'){
            return back()->withNotify($response->message);
        }


        //Find main file
        $mainFile = $dir.'/move/Files.zip';
        if (!file_exists($mainFile)) {
            $this->removeDir($dir);
            $notify[] = ['error','Main file not found'];
            return back()->withNotify($notify);
        }

        $location = base_path('temp/'.$rand);

        //move file
        $extract = $this->extractZip(base_path('temp/'.$rand.'/move/Files.zip'),base_path('../'));
        if ($extract == false) {
            $notify[] = ['error','Something went wrong to extract'];
            return back()->withNotify($notify);
        }

        //push code
        if ($config->file_type == 'plugin') {
            $push = $this->codePush($location);
            if ($push == false) {
                $notify[] = ['error','Something went wrong'];
                return back()->withNotify($notify);
            }
        }

        //reboot plugins
        if ($config->upload_type == 'update') {
            $plugins = UploaderLog::where('file_type','plugin')->get();
            foreach ($plugins as $plugin) {
                $push = $this->codePush(base_path($plugin->directory));
                if ($push == false) {
                    $notify[] = ['error','Something went wrong'];
                    return back()->withNotify($notify);
                }
            }
        }

        //Execute database
        if (file_exists($dir.'/database/database.sql')) {
            $sql = file_get_contents($dir.'/database/database.sql');
            DB::unprepared($sql);
        }


        //Create Uploader log
        $uploaderLog = new UploaderLog;
        $uploaderLog->name = $config->name;
        $uploaderLog->image = @$config->image;
        $uploaderLog->version = $config->version;
        $uploaderLog->file_type = $config->file_type;
        $uploaderLog->upload_type = $config->upload_type;
        $uploaderLog->file_key = $config->file_key;
        $uploaderLog->directory = 'temp/'.$rand;
        $uploaderLog->save();

        $notify[] = ['success','File uploaded successfully'];
        return back()->withNotify($notify);
    }

    protected function extractZip($file,$extractTo){
        $zip = new \ZipArchive;
        $res = $zip->open($file);
        if ($res != true) {
            return false;
        }
        $res = $zip->extractTo($extractTo);
        $zip->close();
        return true;
    }

    protected function removeFile($path){
        $fileManager = new FileManager();
        $fileManager->removeFile($path);
    }

    protected function removeDir($location){
        $fileManager = new FileManager();
        $fileManager->removeDirectory($location);
    }

    protected function codePush($location){
        if (!file_exists($location.'/push/push.json')) {
            return false;
        }
        $getPush = file_get_contents($location.'/push/push.json');
        $pushs = json_decode($getPush);
        foreach ($pushs as $push) {
            $filename = getcwd() . $push->file_path;
            $line_i_am_looking_for = $push->line;
            $lines = file( $filename , FILE_IGNORE_NEW_LINES );

            $new = file_get_contents($location.'/push/codes/'.$push->code);

            array_splice( $lines, $line_i_am_looking_for, 0, $new );
            file_put_contents( $filename , implode( "\n", $lines ) );
        }
        return true;

    }
}
