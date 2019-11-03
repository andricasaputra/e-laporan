@extends('intern.layouts.app')

@section('barside')

  @include('intern.inc.barside_manajemen')

@endsection

@section('content')

<main class="content-wrapper">
  <div class="container-fluid">
   <div class="row">
      <div class="col-md-10 offset-md-1 card">
          <div class="card-header">
            Edit Admin
          </div>
          <div class="card-body">
           

            @include('intern.inc.message')

            <form method="POST" action="{{ route('admin.update', $user->id) }}">

                @csrf
                @method('PUT')
            

                <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                    <div class="col-md-6">

                        <input id="username" type="username" class="form-control" name="username" value="{{ $user->username }}" required>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password Baru</label>

                    <div class="col-md-6">

                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">

                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Edit
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
