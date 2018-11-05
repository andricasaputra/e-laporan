@extends('layouts.app')

@section('link')

<link href="{{asset('css/ikm.css')}}" rel="stylesheet">

@endsection

@section('content')

  @include('inc.ikm_navbar')
  
  <!--==========================
    Intro Section
  ============================-->
  <section id="about" class="wow fadeInUp">
  <!-- Set up your HTML -->
	<div class="container mb-5">
    <div id="result" class="text-center"></div>
    <div class="col-12 text-center" style="margin-bottom: 3%">
      <h5 class="judul">{{ $is_open->keterangan }}</h5>
      <p class="judul">{{ $is_open->start_date }} s/d {{ $is_open->end_date }}</p>
      <hr>
    </div>
		<form action="{{ route('ikm.store') }}" method="POST">
      @csrf
			<div class="form">
				<p class="mb-3">A. Data responden</p>
        <hr>
            <div class="form-group">
              <select class="form-control" name="jenis_layanan" required="required">
                <option disabled selected value="">- Jenis Layanan -</option>
                @foreach($layanan as $l)

                  <option value="{{ $l->id }}">{{ $l->jenis_layanan }}</option>

                @endforeach
              </select>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <select class="form-control" name="jenis_kelamin" required="required">
                  <option disabled selected value="">- Jenis Kelamin -</option>
                  <option value="1">Laki-laki</option>
                  <option value="2">Perempuan</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="umur" required="required">
                  <option disabled selected value="">- Umur -</option>
                  @foreach($umur as $u)

                    <option value="{{ $u->id }}">{{ $u->umur }}</option>

                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <select class="form-control" name="pendidikan" required="required">
                  <option disabled selected value="">- Pendidikan Terakhir -</option>
                  @foreach($pendidikan as $p)

                    <option value="{{ $p->id }}">{{ $p->pendidikan }}</option>

                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="pekerjaan" required>
	                <option disabled selected value="">- Pekerjaan -</option>
                    @foreach($pekerjaan as $p)

                      <option value="{{ $p->id }}">{{ $p->pekerjaan }}</option>

                    @endforeach
                </select>
              </div>
            </div>
       		</div>
          
       	<p class="mt-3 mb-3">B. Pendapat responden tentang pelayanan</p>
        <hr>
       	<div class="col-12">
          <input type="hidden" name="ikm_id" value="{{ $is_open->id }}">
	         <ol>
				  		@foreach($questions as $question)
				  		<div class="form-group mt-3 mb-3">
					  		<div class="mb-3" style="text-align: left; margin-top: 20px">
					  			<h5><li>{{ $question->question }}</li></h5>
					  			@foreach($question->answer as $answer)
					  				<div class="form-check" style="margin-top: 20px;margin-bottom: 20px">
									    <div class="radio">
  										  <label>
                          <input type="radio" value="{{ $answer->id }}" name="{{ $question->id }}[]" required>
                          {{ $answer->answer }}
                        </label>

										  </div>
									</div>
					  			@endforeach
					  		</div>	
					  	</div>
              <hr>
					  	@endforeach
				  	</ol>
			  	</div> 
          <div class="text-center"><button type="submit" class="send_ikm">Kirim</button></div>
        </form>
        <hr>
	</div>

  </section><!-- #intro -->

  <main>
  <!--==========================
      Contact Section
    ============================-->
    <section id="contact">
      <div class="container">
        <div class="section-header">
          <h2>Kontak kami</h2>
          <p>Jika anda memiliki keluhan, saran atau masukan atas pelayanan yang kami berikan,
            silahkan hubungi kami melalui call center dibawah ini. Kami informasikan bahwa petugas kami
            <b>tidak</b> menerima <b>suap</b> dan <b>gratifikasi</b> dalam bentuk apapun!
          </p>
        </div>

        <div class="row contact-info">

          <div class="col-md-4">
            <div class="contact-address">
              <i class="ion-ios-location-outline"></i>
              <h3>Alamat</h3>
              <address>Jln. Pelabuhan Badas No. 01 Sumbawa Besar</address>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-phone">
              <i class="ion-ios-telephone-outline"></i>
              <h3>Telepon</h3>
              <p><a href="tel:+155895548855">(0371) 2629152</a></p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-email">
              <i class="ion-ios-email-outline"></i>
              <h3>Email</h3>
              <p><a href="#">humasskpsumbawa@gmail.com</a></p>
            </div>
          </div>

        </div>
      </div>

    </section><!-- #contact -->

  </main>

@endsection	



