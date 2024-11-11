<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $general->siteName($pageTitle ?? '404 | page not found') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{getImage(getFilePath('logoIcon') .'/favicon.png')}}">
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{ asset('assets/common/css/bootstrap.min.css') }}">
  <!-- dashdoard main css -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/main.css') }}">
</head>

<body>


  <!-- 404 start -->
  <div class="container">
    <div class="row error">
      <div class="col-lg-7 text-center">
        <img class="image-fluid" src="{{ asset('assets/errors/images/500.png') }}" alt="@lang('image')">
        <h2 class="title my-5">@lang('Server Error')</h2>
        <a href="{{ url()->previous() }}" class="btn--base">@lang('Go back')</a>
      </div>
    </div>
  </div>
  <!-- 404 end -->


</body>

</html>
