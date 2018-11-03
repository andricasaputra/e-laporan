@extends('layouts.app')

@section('link')

<link href="{{asset('css/ikm.css')}}" rel="stylesheet">

@endsection

@section('content')

  @include('inc.ikm_navbar')
  
  <main>
  	<!--==========================
      FAQ Section
    ============================-->
  	<section class="accordion-section clearfix mt-5" aria-label="Question Accordions" >
	  <div class="container">
	  
		  <div class="card">
		  	<div class="card-body">
		  		<h3 class="faq_intro">Frequently Asked Questions </h3>
				  <div class="panel-group mt-3" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
					  <div class="panel-heading p-3 mb-3" role="tab" id="heading0">
						<h5 class="panel-title">
						  <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0">
							Apa tujuan dilakukannya survey ini?
						  </a>
						</h5>
					  </div>
					  <div id="collapse0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
						<div class="panel-body px-3 mb-4">
						  <p>
						  	Tujuan survey ini adalah untuk memperoleh gambaran secara obyektif tentang kepuasan
						  	masyarakat terhadap pelayanan karantina. 
						  </p>
						  <p>
						  	Nilai yang diberikan oleh masyarakat diharapkan sabagai nilai yang dapat dipertanggungjawabkan

						  </p>
						  <p>
						  	Hasil survey ini akan digunakan untuk bahan penyusunan indeks kepuasan masyarakat terhadap pelayanan karantina.
						  </p>
						</div>
					  </div>
					</div>
					
					
					<div class="panel panel-default">
					  <div class="panel-heading p-3 mb-3" role="tab" id="heading2">
						<h5 class="panel-title">
						  <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
							Apakah identitas responden dapat dijamin kerahasiaannya?
						  </a>
						</h5>
					  </div>
					  <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
						<div class="panel-body px-3 mb-4">
						  <p><b>Ya</b>. Identitas responden akan kami rahasiakan</p>
						</div>
					  </div>
					</div>
					
					<div class="panel panel-default">
					  <div class="panel-heading p-3 mb-3" role="tab" id="heading3">
						<h5 class="panel-title">
						  <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3">
							Apakah semua orang dapat melihat hasil akhir dari survey ini?
						  </a>
						</h5>
					  </div>
					  <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
						<div class="panel-body px-3 mb-4">
						  <p><b>Ya</b>. Keterangan nilai yang diberikan bersifat terbukan dan tidak dirahasiakan</p>
						</div>
					  </div>
					</div>

					
					<p><i><b>Keterangan tambahan:</b> Survey tidak ada hubungannya dengan pajak dan politik</i></p>
						
				  </div>
		  	</div>
		  	
		  </div>
	  
	  </div>
	</section>
  <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="wow fadeInUp">
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




