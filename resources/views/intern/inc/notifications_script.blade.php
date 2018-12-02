<script>
	$('#btnNotifications').click(function(){

		$("#main_notifications").html(`
		  <div class="text-center">
		    <img src="{{ asset('images/ajax-loader.gif') }}">
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

		url : '{{ route('api.notifications', Auth::user()->id) }}'

		}).done(function(response){

		  $('.dropdown-count').html(response.length);

		  let pusher = new Pusher('59c93649c71d44e27a0a', {
		    cluster: 'ap1',
		    encrypted: true
		  });

		  // Subscribe to the channel we specified in our Laravel Event
		  let channel = pusher.subscribe('all-notifiactions');

		  // Bind a function to a Event (the full Laravel class)
		  channel.bind('all-notifications-report', function(data) {

		    $('.dropdown-count').html(response.length + 1);
		  
		  });

	});

</script>