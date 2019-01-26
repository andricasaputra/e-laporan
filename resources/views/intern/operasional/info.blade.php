@extends('intern.layouts.welcome_app')

@section('content')

<style type="text/css">
  .card_body_welcome{
    color: #fff
  }

  .btn{
    border-radius: 30px !important;
    outline: none;
  }

  .btn-default{
    background-color: #3E50B4;
    color: #fff;
    outline: none;
  }

  .btn-default:hover {
    background-color: #2e3b85;
    color: #fff;
    outline: none;
  }

  .card{
    margin-bottom: 0.5%;
  }

  .card, .card-body{
    font-size: 11pt;
    outline: none;
  }

  a.pengumuman-message{
    color: #000
  }

  .card-body:hover a.pengumuman-message{
    text-decoration: underline;
    color: #7460EE
  }

  .readed{
    background-color: #d7e2f4;
  }

  .readed a:hover{
    color: #000;
  }

  .delete-pengumuman a{
    color: #000
  }

  .delete-pengumuman a:hover{
    text-decoration: underline;
    color: #7460EE
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
      background: #7460EE !important;
      color: white;
      border :none;
      border-radius: 12px
  }

  h6{
    font-weight: normal;
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


<div class="col-sm-12">
  <div class="card">
    <div class="card-body">
      <h4><strong><i class="fa fa-bullhorn fa-fw"></i> Informasi Update Aplikasi E-Operasional</strong></h4>
    </div>
  </div>
</div>

@include('intern.inc.message')

<div class="col-sm-12 mb-4">

    @forelse($pengumumans as $pengumuman)    

      <div class="card mt-4">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12">
               <h5>
                  <div style="float: left;">
                    * {{ $pengumuman->konten }}
                  </div>
                  <div style="float: right; margin-right: 3%"> 
                    <div style="position: relative;margin: auto;"><i class="fa fa-clock-o"></i></div>
                  </div>
               </h5>
               <div style="clear: both;"></div>
               <h6 class="mt-2">
                  <div style="float: left;">
                    <i>Oleh : {{ ucfirst($pengumuman->user->username) }}</i>
                  </div> 
                  <div style="float: right;"> 
                    {{ $pengumuman->created_at->diffForHumans() }} 
                  </div>
                </h6>
            </div>
          </div>
        </div>
      </div>

  @empty

    <div class="card">
        <div class="card-body">
          <div class="row text-center">
            <div class="col-sm-12">
               <a href="#">Tidak Ada Info Update Terbaru</a>
            </div>
          </div>
        </div>
    </div>

  @endforelse
       
</div>

<div class="mb-3 mt-2">
  <div class="col-md-12 align-items-center d-flex justify-content-center">
       {{ $pengumumans->links() }}
  </div>
</div>

<div class="row">
  <div class="col-sm-12 text-center">
    <a href="{{ route('show.operasional') }}" class="btn btn-primary">kembali ke dashboard</a>
  </div>
</div>

@endsection
