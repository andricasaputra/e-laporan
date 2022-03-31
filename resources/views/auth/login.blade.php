<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="e-Office-sumbawa" name="keywords">
  <meta content="e-Office-sumbawa" name="description">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="application-name" content="e-Office">
  <meta name="apple-mobile-web-app-title" content="e-Office">
  <meta name="theme-color" content="#00A9F4">
  <meta name="msapplication-navbutton-color" content="#00A9F4">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="msapplication-starturl" content="/login">
  
  <title>@yield('title', 'E-Office Karantina Sumbawa')</title>
  
  <link rel="manifest" href="{{ asset('manifest-e-office.json') }}">
  <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32">
  <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/web-sumbawa1x.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="48x48" href="{{ asset('images/web-sumbawa1x.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/web-sumbawa2x.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="96x96" href="{{ asset('images/web-sumbawa2x.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/web-sumbawa3x.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('images/web-sumbawa3x.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/web-sumbawa4x.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="{{ asset('images/web-sumbawa4x.png') }}">
  
  <link rel="icon" href="{{asset('images/favicon-32x32.png')}}" type="image/png" sizes="32x32">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/util.css')}}">
  <link rel="stylesheet" href="{{asset('css/main.css')}}">
  <style>
    @media only screen and (max-width: 700px){
        .limiter .container-login100{
            margin-top: -20%;
        }
        
        img{
            margin-top: -5%;
        }
        
        .wrap-input100:first-of-type{
            margin-top: 5%;
        }
    }
  </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-85 p-b-20">
    
                <div id="message">
                    @if (Session::has('success'))
                       <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
                    @elseif (Session::has('warning'))
                        <div class="alert alert-danger text-center">{{ Session::get('warning') }}</div>
                    @endif

                    @if($errors->any())
                      @foreach($errors->all() as $error)
                        <div class="alert alert-danger text-center">{{$error}}</div>
                      @endforeach
                    @endif
                </div>
                
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">

                    @csrf

                    <span class="login100-form-title p-b-70">
                        Login To E-office
                    </span>

                    <span class="login100-form-avatar">
                        <img src="{{asset('images/web-sumbawa4x.png')}}" alt="logo">
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

    <script>
        const autoLogin = async (token) =>
        {
            try{
                const headers = {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                };

                const response = await fetch('{{ route('sso.login') }}', {
                    method: "POST",
                    headers: headers,
                    body: token
                });

                const data = await response.json();

                if (response.ok) {
                    window.location = data.redirect;
                }else if(response.status == 401) {
                   throw new Error('Username atau password salah'); 
                }else {
                   throw new Error(response.statusText); 
                }

            }catch(err){
                
                const token = localStorage.getItem('access_token');
                const container = document.querySelector('#message');

                if (token) {
                    localStorage.removeItem('access_token');
                    container.innerHTML = `<div class="alert alert-danger">Silahkan login kembali</div>`;
                } else {
                    container.innerHTML = `<div class="alert alert-danger">${err.message}</div>`;
                }
                
            }
        }

        const token = localStorage.getItem('access_token');

        if (token && '{{ !session()->has('logout') }}') autoLogin(token);
    </script>
    

</body>

</html>
