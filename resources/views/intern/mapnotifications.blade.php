<style type="text/css">
	
	table{
		width: 500px;
		table-layout:fixed;
		text-align:left;
		vertical-align:top;
	}

	table tr{
		vertical-align:top;
		text-align:left;
	}

	table td{
		width: 100px;
		padding: 5px 20px;
		overflow: hidden;
	}

	table td.message{
		width: 400px;
		font-size: 10pt;
	}

	table td.time{
		width: 400px;
		font-size: 9pt;
	}

	a{
		word-break: break-all;
		white-space: normal;
		color: #000
	}

	a:hover{
		text-decoration: none;
	}

</style>

@if(count($notifications) > 0)

	@foreach($notifications as $notification)
			
			<form action="{{ route('mark.as.read', $notification->id, $notification->notifiable_id) }}" id="notif_submit" method="POST">
				@csrf
				
				<table>
					<tr>
						<td class="message">
							<a href="#" id="button_submit">{{ $notification->data['message'] }}</a>
						</td>				
					</tr>
					<tr>
						<td class="time">
							<i class="fa fa-clock-o" aria-hidden="true"></i> 
							{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}
						</td>
					</tr>
				</table>
				
				<input type="hidden" name="id" value="{{ $notification->id }}">
				<input type="hidden" name="notifiable_id" value="{{ $notification->notifiable_id }}">
				<input type="hidden" name="redirect" value="{{ $notification->data['link'] }}">
			</form>
			<hr>

	@endforeach

	

@else

	<table>
		<tr>
			<td class="text-center">
				Tidak ada pemberitahuan terbaru
			</td>				
		</tr>
		<tr>
			<td class="time"></td>
		</tr>
	</table>

@endif

<script type="text/javascript">
	$('#button_submit').click(function(){
		$("#notif_submit").submit();
	});
</script>

