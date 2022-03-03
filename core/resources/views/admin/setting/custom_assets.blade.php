@extends('admin.layouts.app')
@tsknav('setting')
@section('panel')
    <div class="row gy-4">
      <div class="col-md-12">
            <div class="alert-primary p-3 mb-4 text-center">
                <h6 class="mb-3">@lang('While you are adding or editing anything below, you should know and make sure the below things'):</h6>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('You may need programming knowledge') </span>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('You should have proper knowledge on what you are doing') </span>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('Any wrong input may your system lead to error') </span>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('The custom assets only have impacts on the user/front end') </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6>@lang('Write Custom CSS')</h6>
                </div>
                <form action="{{ route('admin.setting.custom.css') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group custom-css">
                            <textarea class="form-control" rows="10" name="css" id="customCss">{{ $cssFile }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('CSS CDN')</label>
                            <textarea class="form-control" rows="5" name="css_lib" id="cssCdn">{{ $cssLibFile }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6>@lang('Write Custom JavaScript')</h6>
                </div>
                <form action="{{ route('admin.setting.custom.js') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group custom-css">
                            <textarea class="form-control" rows="10" name="js" id="customJs">{{ $jsFile }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('JavaScript CDN')</label>
                            <textarea class="form-control" rows="5" name="js_lib" id="jsCdn">{{ $jsLibFile }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
    .CodeMirror{
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        line-height: 1.3;
        height: 500px;
    }
    .CodeMirror-linenumbers{
      padding: 0 8px;
    }
    .custom-css p, .custom-css li, .custom-css span{
      color: white;
    }
    .cm-s-monokai span.cm-tag{
        margin-left: 15px;
    }
  </style>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/admin/css/codemirror.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/monokai.min.css')}}">
@endpush
@push('script-lib')
    <script src="{{asset('assets/admin/js/codemirror.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/css.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/javascript.js')}}"></script>
    <script src="{{asset('assets/admin/js/xml.js')}}"></script>
    <script src="{{asset('assets/admin/js/sublime.min.js')}}"></script>
@endpush
@push('script')
<script>
    "use strict";
    var editor = CodeMirror.fromTextArea(document.getElementById("customCss"), {
      lineNumbers: true,
      mode: "text/css",
      theme: "monokai",
      keyMap: "sublime",
      autoCloseBrackets: true,
      matchBrackets: true,
      showCursorWhenSelecting: true,
      matchBrackets: true
    });

    var editorJs = CodeMirror.fromTextArea(document.getElementById("customJs"), {
      lineNumbers: true,
      mode: "javascript",
      theme: "monokai",
      keyMap: "sublime",
      autoCloseBrackets: true,
      matchBrackets: true,
      showCursorWhenSelecting: true,
      matchBrackets: true
    });

    var editorHtml = CodeMirror.fromTextArea(document.getElementById("cssCdn"), {
        lineNumbers: true,
        mode: "text/html",
        theme: "monokai",
        keyMap: "sublime",
        autoCloseBrackets: true,
        matchBrackets: true,
        showCursorWhenSelecting: true,
        matchBrackets: true
    });

    var editorHtml = CodeMirror.fromTextArea(document.getElementById("jsCdn"), {
        lineNumbers: true,
        mode: "text/html",
        theme: "monokai",
        keyMap: "sublime",
        autoCloseBrackets: true,
        matchBrackets: true,
        showCursorWhenSelecting: true,
        matchBrackets: true
    });
</script>
@endpush