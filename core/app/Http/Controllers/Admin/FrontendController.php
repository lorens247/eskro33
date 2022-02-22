<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function seoEdit()
    {
        $pageTitle = 'SEO Settings';
        $seo = Frontend::where('data_keys', 'seo.data')->first();
        if(!$seo){
            $data_values = '{"keywords":[],"description":"","social_title":"WEBSITENAME","social_description":"","image":null}';
            $data_values = json_decode($data_values, true);
            $frontend = new Frontend();
            $frontend->data_keys = 'seo.data';
            $frontend->data_values = $data_values;
            $frontend->save();
        }
        return view('admin.frontend.seo', compact('pageTitle', 'seo'));
    }



    public function frontendSections($key)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }
        $content = Frontend::where('template',activeTemplateName())->where('data_keys', $key . '.content')->orderBy('id','desc')->first();
        $elements = Frontend::where('template',activeTemplateName())->where('data_keys', $key . '.element')->orderBy('id')->orderBy('id','desc')->get();
        $pageTitle = $section->name ;
        $emptyMessage = 'No element found';
        return view('admin.frontend.index', compact('section', 'content', 'elements', 'key', 'pageTitle', 'emptyMessage'));
    }




    public function frontendContent(Request $request, $key)
    {
        $purifier = new \HTMLPurifier();
        $valInputs = $request->except('_token', 'image_input', 'key', 'status', 'type', 'id');
        foreach ($valInputs as $keyName => $input) {
            if (gettype($input) == 'array') {
                $inputContentValue[$keyName] = $input;
                continue;
            }
            $inputContentValue[$keyName] = $purifier->purify($input);
        }
        $type = $request->type;
        if (!$type) {
            abort(404);
        }
        $imgJson = @getPageSections()->$key->$type->images;
        $validation_rule = [];
        $validation_message = [];
        foreach ($request->except('_token', 'video') as $input_field => $val) {
            if ($input_field == 'has_image' && $imgJson) {
                foreach ($imgJson as $imgValKey => $imgJsonVal) {
                    $validation_rule['image_input.'.$imgValKey] = ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])];
                    $validation_message['image_input.'.$imgValKey.'.image'] = inputTitle($imgValKey).' must be an image';
                    $validation_message['image_input.'.$imgValKey.'.mimes'] = inputTitle($imgValKey).' file type not supported';
                }
                continue;
            }elseif($input_field == 'seo_image'){
                $validation_rule['image_input'] = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
                continue;
            }
            $validation_rule[$input_field] = 'required';
        }
        $request->validate($validation_rule, $validation_message, ['image_input' => 'image']);
        if ($request->id) {
            $content = Frontend::where('template',activeTemplateName())->findOrFail($request->id);
        } else {
            $content = Frontend::where('template',activeTemplateName())->where('data_keys', $key . '.' . $request->type)->first();
            if (!$content || $request->type == 'element') {
                $content = new Frontend();
                $content->data_keys = $key . '.' . $request->type;
                $content->template = activeTemplateName();
                $content->save();
            }
        }
        if ($type == 'data') {
            $inputContentValue['image'] = @$content->data_values->image;
            if ($request->hasFile('image_input')) {
                try {
                    $inputContentValue['image'] = fileUploader($request->image_input,fileManager()->seo()->path, fileManager()->seo()->size, @$content->data_values->image);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Image Couldn\'t upload'];
                    return back()->withNotify($notify);
                }
            }
        }else{
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    $imgData = @$request->image_input[$imgKey];
                    if (is_file($imgData)) {
                        try {
                            $inputContentValue[$imgKey] = $this->storeImage($imgJson,$type,$key,$imgData,$imgKey,@$content->data_values->$imgKey);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Could not upload the image.'];
                            return back()->withNotify($notify);
                        }
                    } else if (isset($content->data_values->$imgKey)) {
                        $inputContentValue[$imgKey] = $content->data_values->$imgKey;
                    }
                }
            }
        }
        $content->data_values = $inputContentValue;
        $content->save();
        $notify[] = ['success', 'Content updated successfully'];
        return back()->withNotify($notify);
    }



    public function frontendElement($key, $id = null)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }

        unset($section->element->modal);
        $pageTitle = $section->name . ' Items';
        if ($id) {
            $data = Frontend::where('template',activeTemplateName())->findOrFail($id);
            return view('admin.frontend.element', compact('section', 'key', 'pageTitle', 'data'));
        }
        return view('admin.frontend.element', compact('section', 'key', 'pageTitle'));
    }




    protected function storeImage($imgJson,$type,$key,$image,$imgKey,$old_image = null)
    {
        $path = 'assets/images/frontend/' . $key;
        if ($type == 'element' || $type == 'content') {
            $size = @$imgJson
            ->$imgKey->size;
            $thumb = @$imgJson
            ->$imgKey->thumb;
        }else{
            $path = fileManager()->$key()->path;
            $size = fileManager()->$key()->size;
            $thumb = @fileManager()->$key()->thumb;
        }
        return fileUploader($image, $path, $size, $old_image, $thumb);
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required']);
        $frontend = Frontend::where('template',activeTemplateName())->findOrFail($request->id);
        $key = explode('.', @$frontend->data_keys)[0];
        $type = explode('.', @$frontend->data_keys)[1];
        if (@$type == 'element' || @$type == 'content') {
            $path = 'assets/images/frontend/' . $key;
            $imgJson = @getPageSections()->$key->$type->images;
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    fileManager()->removeFile($path . '/' . @$frontend->data_values->$imgKey);
                    fileManager()->removeFile($path . '/thumb_' . @$frontend->data_values->$imgKey);
                }
            }
        }
        $frontend->delete();
        $notify[] = ['success', 'Content deleted successfully'];
        return back()->withNotify($notify);
    }


}
