@extends('intern.layouts.app')

@section('title', 'Tambah Pengumuman')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Tambah Pengumuman</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home') }}"> Home Admin </a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pengumuman.menu') }}">Menu Pengumuman</a></li>
            <li class="breadcrumb-item" aria-current="page">Tambah Pengumuman</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">
  div.form-group{
    text-align: left !important;
  }
</style>

<div class="row">
  <div class="col-md-12 col-sm-12">

    @include('intern.inc.message')

    <div class="card text-center">
      <div class="card-body">
        <h4>Buat Pengumuman Update Aplikasi <i class="fa fa-bullhorn"></i></h4>
        <form action="{{ route('admin.pengumuman.store') }}" method="post" class="form-loader">

            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="form-group">
              <label for="no_seri">Konten</i></label>
              <br>
              <div class="float-left" style="width: 95%;">
                <textarea name="konten[]" class="form-control" required rows="5"></textarea>
              </div>
              <div class="float-right">
                  <button type="button" id="addNoseriButton"><i class="fa fa-plus"></i></button>
              </div>
               
              <div id="addNoseri" class="mt-3"></div>
            </div>
            <br>

            <div style="clear: both;"></div>

            <div class="form-check mt-4" style="text-align: left;">
              <input type="checkbox" class="form-check-input" name="notify" value="1">
              <label class="form-check-label" for="exampleCheck1">notifikasi semua user</label>
            </div>

            <button type="submit" class="btn btn-success mt-3">Simpan</button>
        </form>
      </div>
    </div>
    <div class="col">
      <div class="text-center">
        <a href="{{ route('admin.pengumuman.menu') }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Kembali</a>
      </div>
    </div>
  </div>  

</div>

@endsection

@section('script')
  
<script>
  $('#addNoseriButton').click(function(){

    $('#addNoseri').append(`

      <div class="float-left mt-2" style="width: 95%;">
        <textarea name="konten[]" class="form-control" required rows="5"></textarea>
      </div>
      <div class="float-right mt-2">
          <button type="button" class="removeNoseriButton"><i class="fa fa-minus"></i></button>
      </div

    `);

    $('.removeNoseriButton').click(function(){

      $('#addNoseri').find('div.float-left').first().remove();
      $('#addNoseri').find('div.float-right').first().remove();

    });

  });
</script>

@endsection
