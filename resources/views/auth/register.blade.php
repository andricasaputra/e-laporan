@extends('intern.layouts.app')

@section('content')

<main class="content-wrapper">
  <div class="container-fluid">
   <div class="row">
      <div class="col-md-10 offset-md-1 card">
          <div class="card-header">
            Register Users
          </div>
          <div class="card-body">
            
            @include('intern.inc.message')

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="wilker" class="col-md-4 col-form-label text-md-right">Wilker</label>

                    <div class="col-md-6"> 
                        @if(count($wilker) > 0)

                            <select class="form-control{{ $errors->has('wilker') ? ' is-invalid' : '' }}" name="wilker" required>
                                @foreach($wilker as $w)

                                    <option value="{{$w->id}}">{{$w->nama_wilker}}</option>

                                @endforeach
                            </select>

                        @endif

                        @if ($errors->has('wilker'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('wilker') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bagian" class="col-md-4 col-form-label text-md-right">{{ __('Bagian') }}</label>

                    <div class="col-md-6">
                        <select class="form-control{{ $errors->has('bagian') ? ' is-invalid' : '' }}" name="bagian">
                            <option value="kh">Karantina Hewan</option>
                            <option value="kt">Karantina Tumbuhan</option>
                            <option value="fu">Fungsional Umum</option>
                            <option value="-"></option>
                        </select>

                        @if ($errors->has('bagian'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bagian') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                    <div class="col-md-6">
                        <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role">
                            <option value="2">User</option>
                            <option value="1">Admin</option>
                        </select>

                        @if ($errors->has('role'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                    <div class="col-md-6">
                        <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</main>


@endsection
