@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 4%">

  @include('inc.message')

  <h2>Download Domestik Keluar Karantina Tumbuhan</h2>

  <div class="col-md-12">
    <div class="row">
      <form action="{{ route('kt.download.proses.dokel', date('Y')) }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
              <label for="bulan">Pilih Bulan <i>(optional)</i></label>
              <select name="bulan" class="form-control">
                <option value="all">Pilih Bulan</option>    
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
          </div>
          <div class="form-group">
              <label for="tahun">Pilih Tahun <i>(optional)</i></label>
              <select name="tahun" class="form-control">
                <option value="">Pilih Tahun</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
              </select>
          </div>
          <input type="submit" name="Import" class="btn btn-success" value="Download">
      </form>
    </div>
  </div>

</div>

@endsection
