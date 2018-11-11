@extends('layouts.app')

@section('link')

<link href="{{ asset('css/swiper.min.css') }}" rel="stylesheet">

<link href="{{asset('css/ikm.css')}}" rel="stylesheet">

@endsection

@section('content')

  @include('inc.ikm_navbar')
  <!--==========================
    Intro Section
  ============================-->
  <section id="survey">
    <!-- Swiper -->
    <form id="formsubmit">

      @csrf

      <div class="container-fluid text-center form">
        <div class="swiper-container">

          <div class="col-12 text-center mt-5" style="margin-bottom: 5%">
            <h5 class="judul">{{ $is_open->keterangan }}</h5>
            <p class="judul">{{ $is_open->start_date }} s/d {{ $is_open->end_date }}</p>
            <hr>
            <div id="message"></div>
          </div>
          
          <div class="swiper-wrapper">  
            
            <div class="swiper-slide">
              <div class="container">
                <h5 class="mb-5 survey-questions">Data Responden</h5>
                <p class="sub"><small>Silahkan lengkapi data dibawah ini!</small></p>
                
                <div class="survey-responden">
                    <div class="form-group">
                      <select class="form-control" name="jenis_layanan" id="jenis_layanan" required="required">
                        <option disabled selected value="">- Jenis Layanan -</option>
                        @foreach($layanan as $l)

                          <option value="{{ $l->id }}">{{ $l->jenis_layanan }}</option>

                        @endforeach
                      </select>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6"> 
                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required="required">
                          <option disabled selected value="">- Jenis Kelamin -</option>
                          <option value="1">Laki-laki</option>
                          <option value="2">Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <select class="form-control" name="umur" id="umur" required="required">
                          <option disabled selected value="">- Umur -</option>
                          @foreach($umur as $u)

                            <option value="{{ $u->id }}">{{ $u->umur }}</option>

                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <select class="form-control" name="pendidikan" id="pendidikan" required="required">
                          <option disabled selected value="">- Pendidikan Terakhir -</option>
                          @foreach($pendidikan as $p)

                            <option value="{{ $p->id }}">{{ $p->pendidikan }}</option>

                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <select class="form-control" name="pekerjaan" id="pekerjaan" required>
                          <option disabled selected value="">- Pekerjaan -</option>
                            @foreach($pekerjaan as $p)

                              <option value="{{ $p->id }}">{{ $p->pekerjaan }}</option>

                            @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                
              </div>
            </div>

            <input type="hidden" name="ikm_id" value="{{ $is_open->id }}">

            @php $no = 1 @endphp

            @foreach($questions as $question)

            <div class="swiper-slide uncheck">
              <div class="continer">
              <h5 class="mb-5 survey-questions">Pendapat responden tentang pelayanan</h5>
              <p class="sub"><small>Silahkan pilih jawaban yang paling sesuai!</small></p>
              <div class="col-12">
                <input type="hidden" name="ikm_id" value="{{ $is_open->id }}">
                    <div class="form-group mt-3 mb-3">
                      <div class="mb-3 survey-questions">
                        <h5>{{ $no++ }}. {{ $question->question }}</h5>
                        @foreach($question->answer as $answer)
                          <div class="form-check form-check-inline cek-form " style="margin-top: 20px;margin-bottom: 20px">
                            <div class="radio">
                              <label>
                                <input  type="radio" value="{{ $answer->id }}" name="{{ $question->id }}[]">
                                {{ $answer->answer }}
                              </label>
                            </div>
                          </div>
                        @endforeach
                      </div>  
                    </div>
                </div> 
                @if(count($questions) == $no - 1)
                  <div class="text-center"><button type="submit" class="mt-5 send_ikm">Kirim</button></div>
                  <br>
                @endif
              </div>
            </div>
            @endforeach
          </div>

          <div id="counter"></div>
          <!-- Add Pagination -->
          <div class="swiper-pagination"></div>
          <!-- Add Arrows -->
          <div class="swiper-button-next">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44"><path d="M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z"></svg>
          </div>
          <div class="swiper-button-prev">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44"><path d="M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z"></svg>
          </div>
        </div>
      </div>
    </form>
    <hr>
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

@section('script')

<script src="{{ asset('js/swiper.min.js') }}"></script>

<script src="{{ asset('js/ikm.js') }}"></script>

@endsection



