@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 4%">

  @if (Session::has('success'))
     <div class="alert alert-success">{{ Session::get('success') }}</div>
  @elseif (Session::has('warning'))
      <div class="alert alert-danger">{{ Session::get('warning') }}</div>
  @endif

  <h2>Upload Domestik Keluar Karantina Tumbuhan</h2>

  <div class="col-md-12">
    <div class="row">
      <form action="{{ route('kt.upload.proses.dokel') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
              <input type="file" name="impor">
          </div>
          <input type="submit" name="Import" class="btn btn-success" value="Upload">
      </form>
    </div>
  </div>

  <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card">
        <section class="mdc-card__primary">
          <h1 class="mdc-card__title mdc-card__title--large">Text Field</h1>
        </section>
        <section class="mdc-card__supporting-text">
          <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4-desktop">
              <div class="template-demo">
                <div id="demo-tf-box-wrapper">
                  <div id="tf-box-example" class="mdc-text-field mdc-text-field--box w-100">
                    <input required pattern=".{8,}" type="text" id="tf-box" class="mdc-text-field__input" aria-controls="name-validation-message">
                    <label for="tf-box" class="mdc-text-field__label">Your Name</label>
                    <div class="mdc-text-field__bottom-line"></div>
                  </div>
                  <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="name-validation-msg">
                    Must be at least 8 characters
                  </p>
                </div>
              </div>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4-desktop">
              <div class="template-demo">
                <div id="demo-tf-box-leading-wrapper">
                  <div id="tf-box-leading-example" class="mdc-text-field mdc-text-field--box mdc-text-field--with-leading-icon w-100">
                    <i class="material-icons mdc-text-field__icon" tabindex="0">event</i>
                    <input type="text" id="tf-box-leading" class="mdc-text-field__input">
                    <label for="tf-box-leading" class="mdc-text-field__label">Your name</label>
                    <div class="mdc-text-field__bottom-line"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>

</div>
@endsection
