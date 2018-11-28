@extends('intern.layouts.welcome_app')

@section('content')

<style type="text/css">
  .card_body_welcome{
    color: #fff
  }

  .btn{
    border-radius: 30px !important;
  }

  .btn-default{
    background-color: #3E50B4;
    color: #fff;
  }

  .btn-default:hover {
    background-color: #2e3b85;
    color: #fff;
  }

  .card{
    margin-bottom: 0.5%;
  }

  .card, .card-body{
    font-size: 10pt;
    border-radius: 10px !important;
    outline: none;
  }

  .card-body{
    -webkit-box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.10);
    -moz-box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.10);
    box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.10);
  }

  a{
    color: #000
  }

  a:hover{
    text-decoration: none;
  }

  .readed{
    background-color: #cceeff
  }

  ul.pagination{
    text-align: center;
    font-family: 'Open Sans', sans-serif;
    font-weight: 600;
  }

  ul.pagination li.disabled span.page-link{
      border-radius: 12px
  }

  ul.pagination a, li.disabled span.page-link,
  ul.pagination li.active span.page-link
  {
      margin: 0 5px; /* 0 is for top and bottom. Feel free to change it */
  }

  ul.pagination li.page-item a.page-link {
      color: black;
      transition: background-color .3s;
      border-radius: 12px
  }

  ul.pagination li.active span.page-link {
      background: #00A9F4 !important;
      color: white;
      border :none;
      border-radius: 12px
  }

  @media only screen and (max-width: 700px){
    .card{
      display: block;
      text-align: center;
    }
    
    i.fa{
        margin-top: 0;
        margin-bottom: 10px;
    }

    .pull-right {
        float: none;
        margin-top: 10px
    }
  }
</style>

<main class="content-wrapper">
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
          <div class="mdc-card">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-7">
                <section class="purchase__card_section">
                  <i class="fa fa-bell fa-fw"></i> Semua pemberitahuan
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('intern.inc.message')

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 mb-4">
          @if(count($notifications) > 0)

            @foreach($notifications as $notification)            
              <div class="card">
                <div class="card-body {{ $notification->read_at === null ? 'readed' : '' }}">
                  <div class="row">
                    <div class="col-sm-9">
                       <a href="{{ $notification->data['link'] }}">{{ $notification->data['message'] }}</a>
                    </div>
                    <div class="col-sm-3">
                      <div class="pull-right">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach 

          @else

            <div class="card">
                <div class="card-body">
                  <div class="row text-center">
                    <div class="col-sm-12">
                       <a href="#">Tidak Ada Pemberitahuan Terbaru</a>
                    </div>
                  </div>
                </div>
              </div>

          @endif
               
        </div>
      </div>     
      <div class="row mb-3 mt-2">
        <div class="col-md-12 align-items-center d-flex justify-content-center">
             {{ $notifications->links() }}
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <a href="{{ route('welcome') }}" class="btn btn-primary">kembali ke halaman utama</a>
        </div>
      </div>
    </div>
    
</main>
@endsection
