@extends('layouts.app')

@section('title', 'Home Operasional - KT')

@section('content')

<main class="content-wrapper">
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
          <div class="mdc-card">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-7">
                <section class="purchase__card_section">
                  <p>Selamat Datang {{ Auth::user()->name }}</p>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>
@endsection