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
		<form action="" method="post" role="form" class="contactForm">
			<div class="form">
				<p class="mb-3">A. Data responden</p>
        <hr>
            <div class="form-group">
              <select class="form-control" name="jenis_layanan" required>
                <option disabled selected>- Jenis Layanan -</option>
                @foreach($layanan as $l)

                  <option value="{{ $l->id }}">{{ $l->jenis_layanan }}</option>

                @endforeach
              </select>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <select class="form-control" name="jenis_kelamin" required>
                  <option disabled selected>- Jenis Kelamin -</option>
                  <option value="1">Laki-laki</option>
                  <option value="2">Perempuan</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="umur" required>
                  <option disabled selected>- Umur -</option>
                  @foreach($umur as $u)

                    <option value="{{ $u->id }}">{{ $u->umur }}</option>

                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <select class="form-control" name="pendidikan" required>
                  <option disabled selected>- Pendidikan Terakhir -</option>
                  @foreach($pendidikan as $p)

                    <option value="{{ $p->id }}">{{ $p->pendidikan }}</option>

                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="pekerjaan" required>
	                <option disabled selected>- Pekerjaan -</option>
                    @foreach($pekerjaan as $p)

                      <option value="{{ $p->id }}">{{ $p->pekerjaan }}</option>

                    @endforeach
                </select>
              </div>
            </div>
       		</div>
       	<p class="mb-3">B. Pendapat Responden Tentang Pelayanan</p>
        <hr>
       	<div class="col-12">
	         <ol>
				  		@foreach($questions as $question)
				  		<div class="form-group mt-3 mb-3">
					  		<div class="mb-3" style="text-align: left; margin-top: 20px">
					  			<h5><li>{{ $question->question }}</li></h5>
					  			@foreach($question->answer as $answer)
					  				<div class="form-check" style="margin-top: 20px;margin-bottom: 20px">
									    <div class="radio">
  										  <label>
                          <input type="radio" value="radio1" name="{{ $question->id }}" required>
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
          <div class="text-center form"><button type="submit"><b>Kirim</b></button></div>
        </form>
	</div>

  </section><!-- #intro -->

  <main>
  <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>Kontak kami</h2>
          <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum velit export irure minim illum fore</p>
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

