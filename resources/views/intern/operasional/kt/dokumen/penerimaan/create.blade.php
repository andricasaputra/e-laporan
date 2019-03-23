@extends('intern.layouts.app')

@section('title', 'Tambah Data Penerimaan Dokumen')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Penerimaan Dokumen Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kt.dokumen.index') }}">Dokumen</a></li>
            <li class="breadcrumb-item" aria-current="page">Penerimaan Dokumen</li>
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
  <div class="col-md-6 offset-md-2 col-sm-12">

    @include('intern.inc.message')

    <div class="card text-center">
      <div class="card-body">
        <h4>Tambah Data Penerimaan Dokumen Karantina Tumbuhan</h4>
        <form action="{{ route('kt.dokumen.penerimaan.store') }}" method="post" class="form-loader">

            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="form-group">
              <label for="wilker_id">Nama Wilker</label>
              <select name="wilker_id" class="form-control">
               
                @if(count($wilkers) > 0)

                    <option disabled selected>Pilih Wilker</option>

                    @foreach($wilkers as $w)

                      <option value="{{ $w->id }}">{{ $w->getOriginal('nama_wilker') }}</option>

                    @endforeach
                  
                @endif
                
              </select>
            </div>

            <div class="form-group">
              <label for="tanggal">Tanggal Penerimaan</label>
              <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="dokumen_id">Nama Dokumen</label>
              <select name="dokumen_id" class="form-control">
                @foreach($dokumens as $dokumen)
                  <option value="{{ $dokumen->id }}">{{ $dokumen->dokumen }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="jumlah">Jumlah <i>(dalam satuan set)</i></label>
              <input type="number" min="0" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = Math.abs(this.value)" name="jumlah" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="no_seri">No Seri</i></label>
              <br>
              <div class="float-left" style="width: 95%;">
                <input type="text" name="no_seri[]" class="form-control" placeholder="pisahkan dengan tanda (-) apabila no seri dokumen berjumlah lebih dari 1">
              </div>
              <div class="float-right">
                  <button type="button" id="addNoseriButton"><i class="fa fa-plus"></i></button>
              </div>
               
              <div id="addNoseri" class="mt-3"></div>
            </div>
            <br>
            <button type="submit" class="btn btn-success mt-3">Simpan</button>
        </form>
      </div>
    </div>
    <div class="col">
      <div class="text-center">
        <a href="{{ route('kt.dokumen.index') }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Kembali</a>
      </div>
    </div>
  </div>  

  @include('intern.operasional.rules.rule_dokumen')

</div>

@endsection

@section('script')
  
<script>
  $('#addNoseriButton').click(function(){

    $('#addNoseri').append(`

      <div class="float-left mt-2" style="width: 95%;">
        <input type="text" name="no_seri[]" class="form-control" required placeholder="nomor seri dokumen">
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
