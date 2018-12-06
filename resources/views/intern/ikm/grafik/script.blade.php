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
			let umur = {

				title : '',
				data : []

			};

			let pendidikan = {

				title : '',
				data : []

			};

			let pekerjaan = {

				title : '',
				data : []

			};

			let rata_rata = {

				title : 'Rata-rata Nilai Per Unsur Pelayanan',
				subtitle : response.data[0].periode,
				series_name : 'Nilai rata-rata',
				data : [],
				xAxis : []

			};

			let jenis_kelamin = {

				title : 'Jumlah Responden Berdasarkan Jenis Kelamin',
				subtitle : response.data[0].periode,
				series_name : 'Responden',
				data : [
					response.jenis_kelamin.Laki_laki,
					response.jenis_kelamin.Perempuan
				],
				xAxis : Object.keys(response.jenis_kelamin)

			}
			
			let arr_nilai_ikm = [];

			/*Set Chart Datas Rata - rata Perunsur*/
    		$.each(response.data, function(key, value){

				arr_nilai_ikm.push(parseFloat(value.nrr_perunsur));

    			rata_rata.xAxis.push(value.unsur_pelayanan);

    			rata_rata.data.push(parseFloat(value.rata_nrr));

    		});

			/*Set Chart Datas Umur*/
			$.each(response.umur, function(key, value){

				/*Perbedaan pie dan bar chart - push object baru ke dalam array data*/
		        umur.data.push({

	     	  		name : key,
	    			y : value

		        });

		        umur.title = `Data Responden ${response.data[0].periode} Berdasarkan Umur`;

			});

			/*Set Chart Datas Pendidikan*/
			$.each(response.pendidikan, function(key, value){

		        pendidikan.data.push({

	     	  		name : key,
	    			y : value

		        });

		        pendidikan.title = `Data Responden ${response.data[0].periode} Berdasarkan Pendidikan`;

			});

			/*Set Chart Datas Pekerjaan*/
			$.each(response.pekerjaan, function(key, value){

		        pekerjaan.data.push({

	     	  		name : key,
	    			y : value

		        });

		        pekerjaan.title = `Data Responden ${response.data[0].periode} Berdasarkan Pekerjaan`;

			});

			/*Hightchart colors option*/
			Highcharts.setOptions({
		        colors: [
		         '#ffcc00', '#24CBE5', '#bf80ff',  '#64E572', '#FFF263', '#FF9655', '#6AF9C4' 
		       ]
	     	});

	     	/*Jumlah Rata-rata Nilai IKM*/
			let total = arr_nilai_ikm.reduce(getSum);

			/*Total Nilai IKM*/
			let nilai_ikm = total * 25;

			/*Init Charts*/
			barColumnChart('#rata-rata', rata_rata, 'spline');
			barColumnChart('#jenis_kelamin', jenis_kelamin, 'column');
			pieChart('#umur', umur);
			pieChart('#pendidikan', pendidikan);
			pieChart('#pekerjaan', pekerjaan);

			/*Data Responden, IKM, etc to HTML*/

			/*Nilai total IKM*/
			if(nilai_ikm < 75){

				$('#nilai_ikm').css({
					'backgroundColor': '#b30000',
					'color': '#fff'
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

			$('#nilai_ikm .card-body h1').html(`
				${nilai_ikm.toFixed(3)}				
			`);

			/*Total responden*/

			$('#total_responden').css({
				'backgroundColor': '#e69900',
				'color': '#fff'
			});

			$('#total_responden h2').html(`
				<p>Total Responden</p>
			`);

			$('#total_responden .card-body h1').html(`
				${response.data[0].total_responden}
			`);

			/*Layanan Kh*/

			$('#layanan_kh').css({
				'backgroundColor': '#8c1aff',
				'color': '#fff',
			});

    		$('#layanan_kh h2').html(`

    			Responden Karantina Hewan

    		`);

    		$('#layanan_kh h1').html(`

    			${typeof(Object.values(response.layanan)[0]) == "undefined" ? 0 : Object.values(response.layanan)[0]}

    		`);

    		/*Layanan Kt*/

    		$('#layanan_kt').css({
				'backgroundColor': '#669900',
				'color': '#fff',
			});

    		$('#layanan_kt h2').html(`

    			Responden Karantina Tumbuhan

    		`);

    		$('#layanan_kt h1').html(`

    			${typeof(Object.values(response.layanan)[1]) == "undefined" ? 0 : Object.values(response.layanan)[1]}
    			
    		`);

    		/*Pie Charts Function*/
			function pieChart(container, data){

		      	let chart = {
	             	plotBackgroundColor: null,
	             	plotBorderWidth: null,
	             	plotShadow: false
		      	};

		      	let title = {
		         	text: data.title    
		      	};  

		      	let tooltip = {
		         	pointFormat: '{series.name}: <b>{point.y}</b>'
		      	};

		      	let plotOptions = {
		        	pie: {
			            allowPointSelect: true,
			            cursor: 'pointer',
			            
			            dataLabels: {
			               enabled: true           
			            },
			            
			            showInLegend: true
			         }
		      	};

		      	let credits =  false;

		      	let series = [{
			        type: 'pie',
			        name: 'Jumlah Responden',
			        data: data.data
			    }];

		      	let json = {};   
			        json.chart = chart; 
			        json.title = title;     
			        json.tooltip = tooltip;  
			        json.series = series;
			        json.credits = credits;
			        json.plotOptions = plotOptions;
			        $(container).highcharts(json);

		    }

		     /*Bar Charts Function*/
			function barColumnChart(container, data, type){

		      	let credits = false;

			    let chart = {
			        type: type
			    };

			    let title = {
			        text: data.title
			    };

			    let subtitle = {
			        text: data.subtitle
			    };

			    let xAxis = {
			        categories: data.xAxis
			    };

			    let yAxis = {
			        title: {
			            text: 'Nilai'
			        }
			    };

			    let tooltip = {
			        crosshairs: true,
			        shared: true
			    };

			    let plotOptions = {
			        spline: {
			            marker: {
			                radius: 4,
			                lineColor: '#666666',
			                lineWidth: 1
			            }
			        }
			    };

			    let series = [{
			        name: data.series_name,
			        marker: {
			            symbol: 'square'
			        },
			        data: data.data

			    }];

		      	let json = {};   
			        json.chart = chart; 
			        json.title = title; 
			        json.subtitle = subtitle; 
			        json.xAxis = xAxis;
			        json.yAxis = yAxis;   
			        json.tooltip = tooltip;  
			        json.series = series;
			        json.credits = credits;
			        json.plotOptions = plotOptions;
			        $(container).highcharts(json);

		    }

		    /*Sum Function*/
    		function getSum(total, num) {
		    	return total + num;
			}

    	});/*End ready*/

    </script>

@endsection