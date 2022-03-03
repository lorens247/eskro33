<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $general->sitename($pageTitle ?? '419 | Session has expired') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{getImage(fileManager()->logoIcon()->path .'/favicon.png')}}">
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/bootstrap.min.css') }}">
  <!-- dashdoard main css -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/main.css') }}">
</head>
  <body>


  <!-- error 419 start -->
  <div class="error">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <div class="error-num d-inline-block">
            @lang('419')
            <div class="error-num__clip" data-text="@lang('419')">@lang('419')</div>
          </div>
          <h2 class="text-white">@lang('Sorry your session has expired.')</h2>
          <p class="text-white mt-4">@lang('Please go back and refresh your browser and try again')</p>
          <a href="{{ route('home') }}" class="cmn-btn mt-4">@lang('Go to Home')</a>
        </div>
      </div>
    </div>
  </div>
  <!-- error 419 end -->

  
  </body>
</html>