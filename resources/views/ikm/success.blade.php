
@extends('layouts.app')

@section('link')

<link href="{{asset('css/ikm.css')}}" rel="stylesheet">

@endsection

@section('content')

  @include('inc.ikm_navbar')
  
  <!--==========================
    Intro Section
  ============================-->
  <section id="about">
  <!-- Set up your HTML -->
	<div class="container mb-5">
    	<div class="alert alert-primary text-center"> 

          	<h5 style="color: #0C2E8A">
	            Terimakasih atas penilaian yang anda berikan, masukan anda sangat bermanfaat
	            untuk kemajuan unit kami agar terus memperbaiki dan meningkatkan kualitas 
	            pelayanan bagi masyarakat
          	</h5>
            <br/>
	        <a href="{{ route('ikm.cetak', $responden->id) }}" class="send_ikm" target="_blank"> 
	          <button type="submit" class="send_ikm">Cetak hasil survey </button>
	      	</a>
	      	<br/>
	      	<br/>
	      	<a href="{{ route('ikm.home') }}" style="color: #0C2E8A; font-weight: bold; text-decoration: underline;"> 
	          << Kembali 
	      	</a>

         </div>
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