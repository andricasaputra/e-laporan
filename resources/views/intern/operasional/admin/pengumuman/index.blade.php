@extends('intern.layouts.app')

@section('title', 'Pengumuman Operasional')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Pengumuman</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home') }}"> Home Admin </a></li>
            <li class="breadcrumb-item" aria-current="page">Pengumuman</li>
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

    <a href="{{ route('admin.pengumuman.menu') }}" class="btn btn-primary mb-2">
      <i class="fa fa-plus-circle"></i> Tambah Pengumuman
    </a>

    <hr>

    <table class="table table-bordered mt-2 text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>Dibuat oleh</th>
          <th>Konten</th>
          <th>Keterangan</th>
          <th>Waktu pengumuman</th>
          <th>Action</th>
        </tr> 
      </thead>
      <tbody>
      	@foreach($pengumuman as $p)

      	<tr>
      		<td>{{ $loop->index + 1 }}</td>
      		<td>{{ ucfirst($p->user->username) }}</td>
      		<td>{{ $p->konten }}</td>
      		<td>{{ $p->show }}</td>
      		<td>{{ $p->created_at->diffForHumans() }}</td>
      		<td>
      			<a href="{{ route('admin.pengumuman.show', $p->id) }}" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> Status</a>
	      			<a href="{{ route('admin.pengumuman.edit', $p->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a>
	      			<a href="#" onclick="event.preventDefault();
	                if(!confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')){return false}
	                document.getElementById('delete' + {{ $p->id }}).submit();" 
	                class="btn btn-danger btn-xs">
	                <i class="fa fa-trash"></i> Delete
              	</a>

                <form id="delete{{ $p->id }}" action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST">
	                @csrf
	                @method('DELETE')
                </form>
      		</td>
      	</tr>

      	@endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col text-center">
    <a href="{{ route('admin.home') }}" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Kembali</a>
  </div>
</div>


@endsection