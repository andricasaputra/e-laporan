<script>
	$('#btnNotifications').click(function(){

		$("#main_notifications").html(`
		  <div class="text-center">
		    <img src="{{ asset('images/loader.gif') }}">
		    <br>
		    sedang memuat pemberitahuan...
		  </div>
		  `);

		$('#main_notifications').delay(500).queue(function( nxt ) {
		    $(this).load('{{route('map.notifications')}}');
		    nxt();
		});

	});

	$.ajax({

		url : '{{ route('api.notifications', Auth::user()->id) }}',
		type : 'POST',
		dataType : 'JSON'

		}).done(function(response){

		  $('.dropdown-count').html(response.length);

		  let pusher = new Pusher('59c93649c71d44e27a0a', {
		    cluster: 'ap1',
		    encrypted: true
		  });

		  let channel = pusher.subscribe('all-notifiactions');

		  channel.bind('all-notifications-report', function(data) {

		    $('.dropdown-count').html(response.length + 1);
		  
		  });

	});

</script>