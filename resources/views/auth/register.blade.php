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
            Register User
          </div>
          <div class="card-body">
            
            @include('intern.inc.message')

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="wilker" class="col-md-4 col-form-label text-md-right">Wilker (Tekan Ctrl untuk memilih lebih dari 1 wilker)</label>

                    <div class="col-md-6"> 
                        @if(count($wilkers) > 0)

                            <select class="form-control{{ $errors->has('wilkers') ? ' is-invalid' : '' }}" name="wilker[]" multiple required>
                                <option disabled selected>-- Pilih Wilker --</option>
                                @foreach($wilkers as $w)

                                    <option value="{{$w->id}}">{{$w->nama_wilker}}</option>

                                @endforeach
                            </select>

                        @endif

                        @if ($errors->has('wilkers'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('wilkers') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                    <div class="col-md-6">
                        <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" required>

                        @if ($errors->has('nama'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nama') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nip" class="col-md-4 col-form-label text-md-right">{{ __('NIP') }}</label>

                    <div class="col-md-6">
                        <input id="nip" type="number" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" value="{{ old('nip') }}">

                        @if ($errors->has('nip'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nip') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pangkat" class="col-md-4 col-form-label text-md-right">{{ __('Pangkat') }}</label>

                    <div class="col-md-6">
                        @if(count($golongan) > 0)

                            <select class="form-control{{ $errors->has('wilker') ? ' is-invalid' : '' }}" name="golongan" required>
                                <option value="" disabled selected>-- Pilih Pangkat/Golongan --</option>
                                @foreach($golongan as $g)

                                    <option value="{{$g->id}}">{{$g->pangkat}} - {{$g->golongan}}</option>

                                @endforeach

                                    <option value=""></option>
                            </select>

                        @endif

                        @if ($errors->has('pangkat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pangkat') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan" class="col-md-4 col-form-label text-md-right">{{ __('Jabatan') }}</label>

                    <div class="col-md-6">
                        @if(count($jabatan) > 0)

                            <select class="form-control{{ $errors->has('wilker') ? ' is-invalid' : '' }}" name="jabatan" required>
                                <option value="" disabled selected>-- Pilih Jabatan --</option>
                                @foreach($jabatan as $j)

                                    <option value="{{$j->id}}">{{$j->jabatan}}</option>

                                @endforeach
                                    <option value=""></option>
                            </select>

                        @endif

                        @if ($errors->has('jabatan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jabatan') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_karantina" class="col-md-4 col-form-label text-md-right">{{ __('Bagian') }}</label>

                    <div class="col-md-6">
                        <select class="form-control{{ $errors->has('bagian') ? ' is-invalid' : '' }}" name="jenis_karantina">
                            <option value="kh">Karantina Hewan</option>
                            <option value="kt">Karantina Tumbuhan</option>
                            <option value="fu">Fungsional Umum</option>
                            <option value="str">Struktural</option>
                            <option value=""></option>
                        </select>

                        @if ($errors->has('jenis_karantina'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jenis_karantina') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">

                    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                    <div class="col-md-6">
                        @if(count($roles) > 0)

                                @foreach($roles as $role)

                                    <div class="form-check form-check-inline">
                                      <label><input type="checkbox" name="role[]" value="{{$role->id}}">{{$role->name}}</label>
                                    </div>

                                @endforeach

                        @endif
                        
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
