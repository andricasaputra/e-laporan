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

                        <select class="form-control" name="wilker[]" multiple required>

                            @foreach($user->wilker as $wil)

                                <option value="{{ $wil->id }}" selected>{{ $wil->nama_wilker }}</option>

                            @endforeach

                            @php  $w = $user->wilker  @endphp

                            @foreach(
                                $wilkers->filter(function ($item) use ($w) {

                                       if(!in_array($item->id,(array) $w)):

                                        return $item->id !== $w->first()->id;

                                       endif;
                                }) 
                                
                            as $wilker)

                                <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>

                            @endforeach
                                
                        </select>

                        @if ($errors->has('wilker'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('wilker') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-md-4 col-form-label text-md-right">Nama</label>

                    <div class="col-md-6">

                        <input id="nama" type="text" class="form-control" name="nama" value="{{ $user->pegawai->nama }}" required>

                        @if ($errors->has('nama'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nama') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nip" class="col-md-4 col-form-label text-md-right">NIP</label>

                    <div class="col-md-6">

                        <input id="nip" type="text" class="form-control" name="nip" value="{{ $user->pegawai->nip }}">

                        @if ($errors->has('nip'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nip') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pangkat" class="col-md-4 col-form-label text-md-right">Pangkat</label>

                    <div class="col-md-6">

                            <select class="form-control" name="golongan_id">

                                <option value="{{ $user->golongan->id }}">{{ $user->golongan->pangkat }} - {{ $user->golongan->golongan }}</option>

                                <option value=""></option>

                            </select>

                        @if ($errors->has('pangkat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pangkat') }}</strong>
                            </span>
                        @endif

                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan" class="col-md-4 col-form-label text-md-right">Jabatan</label>

                    <div class="col-md-6">

                        <select class="form-control" name="jabatan_id">

                            <option value="{{ $user->jabatan->id }}">{{ $user->jabatan->jabatan }}</option>

                            <option value=""></option>      

                        </select>

                        @if ($errors->has('jabatan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jabatan') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_karantina" class="col-md-4 col-form-label text-md-right">Jenis Karantina</label>

                    <div class="col-md-6">
                        <select class="form-control" name="jenis_karantina">
                            
                            <option value="{{ $user->pegawai->jenis_karantina }}"> 

                                @switch ($user->pegawai->jenis_karantina) 
                                    @case ('kt')
                                        {{ 'Karantina Tumbuhan' }}
                                        @break
                                    @case ('kh')
                                        {{ 'Karantina Hewan' }}
                                        @break
                                    @case ('fu')
                                        {{ 'Fungsional Umum' }}
                                        @break
                                    @default:
                                        {{ '' }}
                                        @break
                                @endswitch

                            </option>

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
                    <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>

                    <div class="col-md-6">
                        
                        @if(count($roles) > 0)

                            @foreach($user->role as $user_role)

                                <div class="form-check form-check-inline">
                                    <label><input type="checkbox" name="role[]" value="{{$user_role->id}}" checked>
                                        {{$user_role->name}}
                                    </label>
                                </div>
 
                            @endforeach

                            @foreach(

                                $roles->filter(function ($item) use ($user_role) {

                                       return $item->id !== $user_role->id && $item->name !== $user_role->name;

                                    }) 

                            as $role)

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
