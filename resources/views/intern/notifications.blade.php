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

  a.notification-message{
    color: #000
  }

  .card-body:hover a.notification-message{
    text-decoration: none;
    color: #7460EE
  }

  .readed{
    background-color: #d7e2f4;
  }

  .readed a:hover{
    color: #000;
  }

  .delete-notification a{
    color: #000
  }

  .delete-notification a:hover{
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
      <strong><i class="fa fa-bell fa-fw"></i> Semua Pemberitahuan</strong>
    </div>
  </div>
</div>

@include('intern.inc.message')

<div class="col-sm-12 mb-4">

  @if(count($notifications) > 0)

    @foreach($notifications as $notification)            
      <div class="card mt-4">
        <div class="card-body {{ $notification->read_at === null ? 'readed' : '' }}">
          <div class="row">
            <div class="col-sm-9">
               <a class="notification-message" href="{{ $notification->data['link'] }}">{{ $notification->data['message'] }}</a>
            </div>
            <div class="col-sm-3">
              <div class="pull-right">
                <i class="fa fa-bolt" aria-hidden="true"></i> {{ $notification->data['type'] }} |
                <i class="fa fa-clock-o" aria-hidden="true"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach 

    <div class="row mb-3 mt-2 pull-right">
      <div class="col-md-12 delete-notification">
          <i class="fa fa-check"></i> <a href="{{ route('mark.all.as.read') }}" onclick="event.preventDefault();document.getElementById('mark-as-read-all-notification').submit()">Tandai Semua Sudah Dibaca</a> &nbsp;&nbsp;
          <form id="mark-as-read-all-notification" action="{{ route('mark.all.as.read') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <i class="fa fa-trash"></i> <a href="{{ route('delete.all.notifications') }}" onclick="event.preventDefault();document.getElementById('delete-notification').submit()">Hapus Semua Notifikasi</a>
          <form id="delete-notification" action="{{ route('delete.all.notifications') }}" method="POST" style="display: none;">
            @csrf
          </form>

      </div>
    </div>

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


<div class="mb-3 mt-2">
  <div class="col-md-12 align-items-center d-flex justify-content-center">
       {{ $notifications->links() }}
  </div>
</div>

<div class="row">
  <div class="col-sm-12 text-center">
    <a href="{{ route('welcome') }}" class="btn btn-primary">kembali ke halaman utama</a>
  </div>
</div>


@endsection
