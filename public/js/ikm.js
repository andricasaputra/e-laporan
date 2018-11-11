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
    /*console.log(activeIndex)*/
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

  $('input[type="radio"]').change(function(){

      $(this).addClass('checked');

      let value = $(this).val();

      if (value !== '') {

        setTimeout(function () {

          swiper.slideNext();

        }, 1000);

      }

      if ($('input[type="radio"].checked').length == swiperLength) {

        setTimeout(function () {

          $('#message').html(`

            <div class="alert alert-primary"><span style="font-size: 12pt;">Silahkan Tekan Tombol Kirim</span style="font-size: 10pt;"></div>

          `)

         }, 1500);


        window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function() {
              $(this).hide();
          });
        }, 4000);

      }

  });


  $('#formsubmit').on('submit', function(e){

    e.preventDefault();

    if ($('input[type="radio"].checked').length == swiperLength){

      $.ajax({

         url : 'survey',

         type :'POST',

         data : new FormData (this),

         contentType : false,

         cache : false,

         processData : false,

         success : function(response){

          window.location = response;
          
         } 

      });

    }else{

      swiper.slideTo(0);  

      /*let blank = $('.swiper-slide').parent().find('.uncheck').length;

      let nonBlank = $('input[type="radio"].checked').length;*/

      /*$('.swiper-slide').length - blank - 1 */

      /*if(blank > nonBlank){

          swiper.slideTo($('.swiper-slide').length - blank - 1);

      }else{

          swiper.slideTo($('.swiper-slide').length - blank + nonBlank - 1);
      }*/ 

      $('#message').empty();

      $('#message').append(`

        <div class='alert alert-danger'><b>Data yang anda isi belum lengkap, mohon periksa kembali pertanyaan yang belum terisi</b></div>

      `);
    }

  });
  
  
});/*End ready*/
