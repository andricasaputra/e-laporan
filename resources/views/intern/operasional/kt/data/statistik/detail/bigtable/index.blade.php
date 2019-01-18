@extends('intern.layouts.app')

@section('title', 'Data Operasional - Detail Frekuensi')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Statistik Data Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu Utama</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.data.operasional.kt') }}">Menu Data Operasional Karantina Tumbuhan</a></li>
            <li class="breadcrumb-item" aria-current="page">Statistik Data Operasional Karantina Tumbuhan</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

Detail

@endsection

