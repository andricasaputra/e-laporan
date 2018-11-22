@extends('intern.layouts.app')

@section('barside')

  @include('intern.inc.barside')

@endsection

@section('content')

<main class="content-wrapper">
  <div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner">
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
          <div class="mdc-card">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-7">
                <section class="purchase__card_section">
                    
                    @include('intern.inc.message')

                    <h4>Upload Domestik Masuk Karantina Hewan</h4>
                    <div class="col-md-12">
                      <div class="row">
                        <form action="{{ route('kh.upload.proses.domas') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="form-group">
                              <label for="wilker_id">Nama Wilker</label>
                              <select name="wilker_id" class="form-control">
                               
                                @if(count($wilker) > 0)

                                    <option disabled selected>Pilih Wilker</option>

                                    @foreach($wilker as $w)

                                      <option value="{{ $w->id }}">{{ $w->nama_wilker }}</option>

                                    @endforeach
                                  
                                @endif
                                
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="filenya">Pilih File Laporan</label>
                              <input type="file" name="filenya" class="form-control">
                            </div>
                            <input type="submit" name="Import" class="btn btn-success" value="Upload">
                        </form>
                      </div>
                    </div>
                </section>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</main>

@endsection
