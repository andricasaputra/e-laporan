@extends('intern.layouts.app')

@section('title', 'Edit Dokumen Operasional')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Edit Dokumen Operasional</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home') }}">Menu Admin </a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.setting.dokumen.index') }}">Dokumen</a></li>
            <li class="breadcrumb-item" aria-current="page">Edit Dokumen</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

  i.fa-2x {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-expand{
    background-color: #008000;
    color: #fff;
  }

  .fa-upload{
    background-color: #2962FF;
    color: #fff
  }

  .fa-download{
    background-color: #F24656;
    color: #fff
  }

</style>

<div class="row">
  <div class="col">

    <form action="{{ route('admin.setting.dokumen.update', $dokumen->id) }}" method="POSt">

        @csrf
        @method('PUT')
          
        <div class="form-group">
          <label for="dokumen">Nama Dokumen</label>
          <input type="text" name="dokumen" class="form-control" required placeholder="ex KT 12" value="{{ $dokumen->dokumen }}">
        </div>

        <div class="form-group">
          <label for="deskripsi">Deskripsi / Judul dokumen</label>
          <input type="text" name="deskripsi" class="form-control" required placeholder="nama panjang dari dokumen" value="{{ $dokumen->deskripsi }}">
        </div>

        <div class="form-group">
          <label for="deskripsi">Karantina</label>
          <select name="karantina" class="form-control" required>
            @switch($dokumen->karantina)
              @case ('HEWAN') <option value="kh">Karantina Hewan</option> @break
              @case ('TUMBUHAN') <option value="kt">Karantina Tumbuhan</option> @break
              @default  <option value="both">Karantina Hewan & Tumbuhan</option> @break
            @endswitch
            <option value="kh">Karantina Hewan</option>
            <option value="kt">Karantina Tumbuhan</option>
            <option value="both">Karantina Hewan & Tumbuhan</option>
          </select>
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>

    </form>

  </div>
</div>

<!-- Modal -->


@endsection