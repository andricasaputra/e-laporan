@extends('intern.layouts.app')

@section('title', 'Setting Dokumen Operasional')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Setting Dokumen Karantina</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home') }}"> Home Admin </a></li>
            <li class="breadcrumb-item" aria-current="page">Dokumen</li>
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

    @include('intern.inc.message')

    <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahDokumen">
      <i class="fa fa-plus-circle"></i> Tambah Dokumen
    </a>

    <hr>

    <table class="table table-bordered mt-2 text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Dokumen</th>
          <th>Deskripsi</th>
          <th>Karantina</th>
          <th>Action</th>
        </tr> 
      </thead>
      <tbody>

        @forelse($dokumens as $dokumen)

          <tr>
            <td>{{ $loop->index  + 1 }}</td>
            <td>{{ $dokumen->dokumen }}</td>
            <td>{{ $dokumen->deskripsi }}</td>
            <td>{{ strtoupper($dokumen->karantina) }}</td>
            <td>

              <a href="{{ route('admin.setting.dokumen.edit', $dokumen->id) }}" class="btn btn-success">
                <i class="fa fa-edit"></i> Edit
              </a>

              <a href="#" onclick="event.preventDefault();
                if(!confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')){return false}
                document.getElementById('delete' + {{ $dokumen->id }}).submit();" 
                class="btn btn-danger">
                <i class="fa fa-trash"></i> Delete
              </a>

              <form id="delete{{ $dokumen->id }}" action="{{ route('admin.setting.dokumen.destroy', $dokumen->id) }}" method="POST">
                @csrf
                @method('DELETE')
              </form>

            </td>
          </tr>

        @empty

          <tr>
            <td colspan="6">Tidak Ada Data Ditemukan</td>
          </tr>

        @endforelse

      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col text-center">
    <a href="{{ route('admin.home') }}" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Kembali</a>
  </div>
</div>

<!-- Modal -->

<div class="modal fade" id="tambahDokumen" tabindex="-1" role="dialog" aria-labelledby="laporanOperasionalDownloadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('admin.setting.dokumen.store') }}" method="POST">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="laporanOperasionalDownloadModalLabel">Tambah Data Dokumen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
          
          @csrf
          
          <div class="form-group">
            <label for="dokumen">Nama Dokumen</label>
            <input type="text" name="dokumen" class="form-control" required placeholder="contoh : KT 12">
          </div>

          <div class="form-group">
            <label for="deskripsi">Deskripsi / Judul dokumen</label>
            <input type="text" name="deskripsi" class="form-control" required placeholder="nama panjang dari dokumen">
          </div>

          <div class="form-group">
            <label for="deskripsi">Karantina</label>
            <select name="karantina" class="form-control" required>
              <option value="kh">Karantina Hewan</option>
              <option value="kt">Karantina Tumbuhan</option>
              <option value="both">Karantina Hewan & Tumbuhan</option>
            </select>
          </div>

        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </div>
      
    </form>
    
  </div>
</div>

@endsection