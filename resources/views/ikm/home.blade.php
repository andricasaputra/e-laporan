@extends('layouts.app')

@section('content')

  @include('inc.ikm_navbar')

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">

    <div class="intro-content">
      <h2>Survey <span>Indeks Kepuasan</span><br>Masyarakat!</h2>
      <div>
        <a href="{{ route('ikm.survey') }}" class="btn-get-started scrollto">Mulai survey</a>
      </div>
    </div>

    <div id="intro-carousel" class="owl-carousel">
      <div class="item" style="background-image: url('images/intro-carousel/1.jpg');"></div>
    </div>

  </section><!-- #intro -->

  <main>
    <section id="call-to-action" class="wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-9 text-center text-lg-left">
            <h3 class="cta-title">Arti Penting Survey Ini</h3>
            <p class="cta-text">
              <span class="intro">"K</span>ami mengharapkan hubungan dan komunikasi dalam pemberian pelayanan kami untuk
              terus dapat ditingkatkan. Komentar, saran dan masukan mitra usaha sangat berharga bagi kami, karena sudah menjadi harapan dan tujuan kami dalam pemberian pelayanan prima sejalan dengan tingkat kualitas sarana dan prasarana yang kami miliki. Oleh karena itu kami sangat menghargai bila mitra usaha dapat meluangkan waktu beberapa menit untuk mengisi kuisioner ini, sebagai bahan evalusi dan prioritas kami dalam meningkatkan kualitas pelayanan kami. Terima kasih atas kesediaan mitra usaha dalam menjalin kerjasama dengan kami.<span class="intro">"</span>
            </p>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="{{ route('ikm.survey') }}">Mulai Survey</a>
          </div>
        </div>

      </div>
    </section><!-- #call-to-action -->
  <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>Kontak kami</h2>
          <p>
            Jika anda memiliki keluhan, saran atau masukan atas pelayanan yang kami berikan,
            silahkan hubungi kami melalui call center dibawah ini. Kami informasikan bahwa petugas kami
            <b>tidak</b> menerima <b>suap</b> dan <b>gratifikasi</b> dalam bentuk apapun!
          </p>
        </div>

        <div class="row contact-info">

          <div class="col-md-4">
            <div class="contact-address">
              <i class="ion-ios-location-outline"></i>
              <h3>Alamat</h3>
              <address>Jln. Pelabuhan Badas No. 01 Sumbawa Besar - NTB</address>
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

@section('script')
{{-- <script src="{{ asset('js/main.js') }}"></script> --}}
@endsection