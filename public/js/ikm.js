$(document).ready(function(){

  let swiper = new Swiper('.swiper-container', {
    pagination: {
      el: '.swiper-pagination',
      type: 'progressbar',
    },

    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    allowSlideNext : false,
  });

  let swiperLength = $('.swiper-slide').length - 1;

  swiper.on('slideChange', function () {
    let activeIndex = swiper.activeIndex;
    $('#counter').html(`
      <span style="font-size: 17pt; color:#4d4d4d"> ${activeIndex}/${swiperLength} </span>
      `);
  });

  
  if($(window).width() < 700){

    $('.cek-form').removeClass('form-check-inline');
    $('.cek-form').css({
      'text-align': 'left',
      'margin-left': '20px'

    });

  };

  let navigation = $('.swiper-button-next').addClass('swiper-button-disabled');     

  $('select').change(function(){

      let jenis_layanan = $('#jenis_layanan').val();
      let pendidikan = $('#pendidikan').val();
      let pekerjaan = $('#pekerjaan').val();
      let umur = $('#umur').val();
      let jenis_kelamin = $('#jenis_kelamin').val();

      if (jenis_layanan !== null && pendidikan !== null && pekerjaan !== null && umur !== null && jenis_kelamin !== null) {

        swiper.allowSlideNext = true;

        setTimeout(function () {

          swiper.slideNext();

         }, 1500);

      } 
  });


  $('.swiper-slide').on('click', function(){

    $(this).removeClass('uncheck');

    $(this).addClass('checked');

  });

  $('#btnSubmit').hide();

  $("#message").hide();

  $('input[type="radio"]').on('change', function(){

      $(this).toggleClass('checked');

      let value = $(this).val();

      if (value !== '') {

        setTimeout(function () {

          swiper.slideNext();

        }, 1000);

      }

      if (swiperLength === swiper.activeIndex) {

        if ($('input[type="radio"].checked').length < swiper.activeIndex) {

            unComplete();

        }else{

            complete();
            
        }

      }else if ($('input[type="radio"].checked').length === swiperLength) {

        complete();
        
      }  

  });

  function unComplete()
  {
    $("#message").fadeIn('slow').css({

        "position" : "absolute",
        "z-index" : "10",
        "border-radius" : "50%"

      }).html(`

        <div class="alert alert-danger" style="border-radius: 50%"><span style="font-size: 12pt;">Terdapat Pertanyaan Yang Belum Terisi, mohon Periksa kembali Jawaban Anda</span style="font-size: 10pt;"></div>

    `);

    setTimeout(function () {

      swiper.slideTo(1); 

     }, 1200); 

  }

  function complete()
  {

    setTimeout(function () {

      swiper.slideTo(swiperLength); 

    }, 1200); 


    setTimeout(function() {

      $('#btnSubmit').fadeIn();

    }, 1500);

    $("#message").fadeIn('slow').css({

        "position" : "absolute",
        "z-index" : "10",
        "border-radius" : "50%"

      }).html(`

        <div class="alert alert-primary" style="border-radius: 50%"><span style="font-size: 12pt;">Silahkan Tekan Tombol Kirim</span style="font-size: 10pt;"></div>

      `);
    

      window.setTimeout(function() {

        $(".alert").fadeTo(500, 0).slideUp(500, function() {

            $(this).hide();

        });

    }, 4000);


  }

  
});/*End ready*/
