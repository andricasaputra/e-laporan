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
            Edit Users
          </div>
          <div class="card-body">

            @include('intern.inc.message')

            <form method="POST" action="{{ route('users.update', $user->id) }}">

                @csrf
                @method('PUT')
            
                <div class="form-group row">
                    <label for="wilker" class="col-md-4 col-form-label text-md-right">Wilker</label>

                    <div class="col-md-6"> 

                        <select class="form-control{{ $errors->has('wilker') ? ' is-invalid' : '' }}" name="wilker" required>
                                <option value="{{ $wilker_user->id }}">{{ $wilker_user->nama_wilker }}</option>
                                @if(count($wilkers) > 0)

                                    @foreach($wilkers as $wil)

                                        <option value="{{ $wil->id }}">{{ $wil->nama_wilker }}</option>

                                    @endforeach

                                @endif
                        </select>

                        @if ($errors->has('wilker'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('wilker') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                    <div class="col-md-6">
                        <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ $user->pegawai->nama }}" required autofocus>

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
                        <input id="nip" type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" value="{{ $user->pegawai->nip }}" required autofocus>

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
                                @if($golongan_user !== NULL)
                                    <option value="{{ $golongan_user->id }}">{{ $golongan_user->golongan }}</option>
                                @else
                                    <option value="" disabled selected>-- Pilih Pangkat/Golongan --</option>
                                @endif
                                
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
                                @if($jabatan_user !== NULL)
                                    <option value="{{ $jabatan_user->id }}">{{ $jabatan_user->jabatan }}</option>
                                @else
                                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                                @endif
                                
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
                    <label for="jenis_karantina" class="col-md-4 col-form-label text-md-right">{{ __('Jenis Karantina') }}</label>

                    <div class="col-md-6">
                        <select class="form-control{{ $errors->has('jenis_karantina') ? ' is-invalid' : '' }}" name="jenis_karantina">
                            <option value="{{ $user->pegawai->jenis_karantina }}"> {{ $user->pegawai->jenis_karantina }} </option>
                            <option value="kh">Karantina Hewan</option>
                            <option value="kt">Karantina Tumbuhan</option>
                            <option value="fu">Fungsional Umum</option>
                            <option value="-"></option>
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
                        <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role">
                            <option value="{{ $user->role->id }}">{{ $user->role->role }}</option>
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
                        <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $user->username }}" required>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password Baru') }}</label>

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
                            {{ __('Edit') }}
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
