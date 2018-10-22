@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 4%">

  @include('inc.message')

  <h2>Upload Domestik Masuk Karantina Tumbuhan</h2>

  <div class="col-md-12">
    <div class="row">
      <form action="{{ route('kt.download.proses.domas') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
              <input type="file" name="impor">
          </div>
          <input type="submit" name="import" class="btn btn-success" value="Upload">
      </form>
    </div>
  </div>

</div>
@endsection
