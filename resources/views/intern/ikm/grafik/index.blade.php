@extends('intern.layouts.admin')

@section('title', 'E-IKM | Grafik')

@section('barside.title', 'IKM Sumbawa')

@section('custom-links')

<style>
/* === card component ====== 
 * Variation of the panel component
 * version 2018.10.30
 * https://codepen.io/jstneg/pen/EVKYZj
 */
.card{ background-color: #fff; border: 1px solid transparent; border-radius: 6px; }
.card > .card-link{ color: #333; }
.card > .card-link:hover{  text-decoration: none; }
.card > .card-link .card-img img{ border-radius: 6px 6px 0 0; }
.card .card-img{ position: relative; padding: 0; display: table; }
.card .card-img .card-caption{
  position: absolute;
  right: 0;
  bottom: 16px;
  left: 0;
}
.card .card-body{ display: table; width: 100%; padding: 12px; }
.card .card-header{ border-radius: 6px 6px 0 0; padding: 8px; }
.card .card-footer{ border-radius: 0 0 6px 6px; padding: 8px; }
.card .card-left{ position: relative; float: left; padding: 0 0 8px 0; }
.card .card-right{ position: relative; float: left; padding: 8px 0 0 0; }
.card .card-body h1:first-child,
.card .card-body h2:first-child,
.card .card-body h3:first-child, 
.card .card-body h4:first-child,
.card .card-body .h1,
.card .card-body .h2,
.card .card-body .h3, 
.card .card-body .h4{ margin-top: 0; }
.card .card-body .heading{ display: block;  }
.card .card-body .heading:last-child{ margin-bottom: 0; }

.card .card-body .lead{ text-align: center; }

@media( max-width: 768px ){

  .card .card-4-8 { width: 66.66666667%; }

  .card .card-5-7 { width: 58.33333333%; }
  
  .card .card-6-6 { width: 50%; }

  .card .card-7-5 { width: 41.66666667%; }
  
  .card .card-8-4 { width: 33.33333333%; }

}

/* -- default theme ------ */
.card-default{ 
  border-color: #ddd;
  background-color: #fff;
  margin-bottom: 24px;
}
.card-default > .card-header,
.card-default > .card-footer{ color: #333; background-color: #ddd; }
.card-default > .card-header{ border-bottom: 1px solid #ddd; padding: 8px; }
.card-default > .card-footer{ border-top: 1px solid #ddd; padding: 8px; }
.card-default > .card-body{ display: none; }
.card-default > .card-img:first-child img{ border-radius: 6px 6px 0 0; }
.card-default > .card-left{ padding-right: 4px; }
.card-default > .card-right{ padding-left: 4px; }
.card-default p:last-child{ margin-bottom: 0; }
.card-default .card-caption { color: #fff; text-align: center; text-transform: uppercase; }


/* -- price theme ------ */
.card-price{ border-color: #999; background-color: #ededed; margin-bottom: 24px; }
.card-price > .card-heading,
.card-price > .card-footer{ color: #333; background-color: #fdfdfd; }
.card-price > .card-heading{ border-bottom: 1px solid #ddd; padding: 8px; }
.card-price > .card-footer{ border-top: 1px solid #ddd; padding: 8px; }
.card-price > .card-img:first-child img{ border-radius: 6px 6px 0 0; }
.card-price > .card-left{ padding-right: 4px; }
.card-price > .card-right{ padding-left: 4px; }
.card-price .card-caption { color: #fff; text-align: center; text-transform: uppercase; }
.card-price p:last-child{ margin-bottom: 0; }

.card-price .price{ 
  text-align: center; 
  color: #337ab7; 
  font-size: 3em; 
  text-transform: uppercase;
  line-height: 0.7em; 
  margin: 24px 0 16px;
}
.card-price .price small{ font-size: 0.4em; color: #66a5da; }
.card-price .details{ list-style: none; margin-bottom: 24px; padding: 0 18px; }
.card-price .details li{ text-align: center; margin-bottom: 8px; }
.card-price .buy-now{ text-transform: uppercase; }
.card-price table .price{ font-size: 1.2em; font-weight: 700; text-align: left; }
.card-price table .note{ color: #666; font-size: 0.8em; }

</style>

@endsection

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Statistik & Grafik {{ $ikm_ket->keterangan }}</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12">
	<div class="row" style="margin-bottom: 1%">
		<div class="col-sm-4">
			<div class="row">
				<label for="select_ikm">Pilih IKM</label>
				<select name="select_ikm" id="select_ikm" class="form-control">
					<option disabled selected>-- Pilih Periode IKM --</option>
					@foreach($ikm as $i)
						<option value="{{ $i->id }}">{{ $i->keterangan }}</option>
					@endforeach
				</select>
			</div>
		 </div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="x_panel">
			  <div class="x_content">
			  	<div class="row">
			  		<div class="col-md-12 text-center" id="nilai_ikm">
						<h2></h2>
						<div class="card card-default" >
						  <div class="card-body" style="margin: 70px 0">
						  	<div class="card-6-6">
						  		<h2 style="font-size: 50pt"></h2>
						  	</div>
						  	<i class="fa fa-check-circle" style="font-size: 30pt"></i>
						  </div>
						</div>
					</div>
			  		<div class="col-md-4">
			  			
			  		</div>
			  	</div>
			  </div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="x_panel">
			  <div class="x_content">
			  	<div class="row">
			  		<div class="col-md-12 text-center" id="total_responden">
						<h2></h2>
						<div class="card card-default" >
						  <div class="card-body" style="margin: 70px 0">
						  	<div class="card-6-6">
						  		<h2 style="font-size: 50pt"></h2>
						  	</div>
						  	<i class="fa fa-line-chart" style="font-size: 30pt"></i>
						  </div>
						</div>
					</div>
			  		<div class="col-md-4">
			  			
			  		</div>
			  	</div>

			  </div>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_content">
	  	<div class="row">
	  		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	  	</div>
	  </div>
	</div>
</div>



@endsection

@section('script')

	<script src="{{ asset('js/highcharts.js') }}"></script>

    <script>

    	let url = '{{ route('api.grafik', $id) }}';

    	$('#select_ikm').on('change', function(){

			let id = $(this).val();

			if(id != ''){

				window.location = '{{ route('intern.ikm.grafik.index') }}/'+ id

			}
		});

    	$.ajax({

    		'url' : url

    	}).done(function(response){

    		let arr_nilai_ikm = [];

    		let xAxis = [];

    		let data = [];

    		$.each(response, function(key, value){

	    		arr_nilai_ikm.push(parseFloat(value.nrr_perunsur));

    			xAxis.push(value.unsur_pelayanan);

    			data.push(parseFloat(value.rata_nrr));

    		});

    		/*Sum Function*/
    		function getSum(total, num) {

		    	return total + num;

			}

			/*Nilai IKM Total*/
			let total = arr_nilai_ikm.reduce(getSum);

			let nilai_ikm = total * 25;

			if(nilai_ikm < 75){

				$('#nilai_ikm').css({
					'backgroundColor': '#b30000',
					'color': '#fff',
				});

			}else{

				$('#nilai_ikm').css({
					'backgroundColor': '#00cca3',
					'color': '#fff'
				});
			}

			$('#nilai_ikm h2').html(`
				<p>IKM Unit Pelayanan</p>
			`);

			$('#nilai_ikm .card-body h2').html(`
				${nilai_ikm.toFixed(3)}				
			`);

			/*Total responden*/

			$('#total_responden').css({
				'backgroundColor': '#b30000',
				'color': '#fff'
			});

			$('#total_responden h2').html(`
				<p>Total Responden</p>
			`);

			$('#total_responden .card-body h2').html(`
				${response[0].total_responden}
			`);

			/*Chart IKM Rata-rata per unsur*/
			Highcharts.chart('container', {
			    chart: {
			        type: 'spline'
			    },
			    title: {
			        text: 'Rata-rata Nilai Unsur Pelayanan'
			    },
			    subtitle: {
			        text: response[0].periode
			    },
			    xAxis: {
			        categories: xAxis
			    },
			    yAxis: {
			        title: {
			            text: 'Nilai'
			        }
			    },
			    tooltip: {
			        crosshairs: true,
			        shared: true
			    },
			    plotOptions: {
			        spline: {
			            marker: {
			                radius: 4,
			                lineColor: '#666666',
			                lineWidth: 1
			            }
			        }
			    },
			    series: [{
			        name: 'Nilai rata-rata',
			        marker: {
			            symbol: 'square'
			        },
			        data: data

			    }]
			});
    	});

    </script>

@endsection