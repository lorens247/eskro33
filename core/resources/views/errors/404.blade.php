<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $general->sitename($pageTitle ?? '404 | page not found') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{getImage(fileManager()->logoIcon()->path .'/favicon.png')}}">
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/bootstrap.min.css') }}">
  <!-- dashdoard main css -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/main.css') }}">
</head>
  <body>


  <!-- error 404 start -->
  <div class="error">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <div class="error-num d-inline-block">
            @lang('404')
            <div class="error-num__clip" data-text="@lang('404')">@lang('404')</div>
          </div>
          <h2 class="text-white">@lang('Page not found')</h2>
          <p class="text-white mt-4">@lang('page you are looking for doesn\'t exit or an other error occured') <br> @lang('or temporarily unavailable.')</p>
          <a href="{{ route('home') }}" class="cmn-btn mt-4">@lang('Go to Home')</a>
        </div>
      </div>
    </div>
  </div>
  <!-- error 404 end -->

  
  </body>
</html>