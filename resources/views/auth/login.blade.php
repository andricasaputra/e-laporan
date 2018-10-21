<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name'))</title>
  <link rel="icon" href="{{asset('images/favicon-32x32.png')}}" type="image/png" sizes="32x32">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/util.css')}}">
  <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-85 p-b-20">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">

                    @csrf

                    <span class="login100-form-title p-b-70">
                        Login To E-office
                    </span>

                    <span class="login100-form-avatar">
                        <img src="{{asset('images/web-sumbawa4x.png')}}" alt="AVATAR">
                    </span>

                    <div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Enter username">
                        <label for="username"></label>
                        <input type="text" class="input100{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
                        <label for="pass"></label>
                        <input type="password" name="password" class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <ul class="login-more p-t-190">
                        <li class="m-b-8">
                            <input class="txt1 form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="txt2 form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
