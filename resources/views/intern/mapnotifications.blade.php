<style type="text/css">
	
	table{
		width: 500px;
		table-layout:fixed;
		text-align:left;
		vertical-align:top;
		background-color: #fff;
	}

	table tr{
		vertical-align:top;
		text-align:left;
		background-color: #fff;
	}

	table td{
		width: 100px;
		padding: 5px 20px;
		overflow: hidden;
		background-color: #fff;
	}

	table td.message{
		width: 100%;
		font-size: 10pt;
		background-color: #fff;
	}

	table td.type, table td.time{
		font-size: 9pt;
		background-color: #fff;
	}

	table td.time{
		text-align: right;
		background-color: #fff;
	}

	a{
		word-break: break-all;
		white-space: normal;
		color: #000;

	}

	a:hover, li.text-center > a:hover{
		background-color: #fff;
		text-decoration: none;
		color: #000;
	}

</style>

<li class="text-center" role="menuitem" tabindex="0">
  <i class="fa fa-eye"></i> <a href="{{ route('show.all.notifications') }}">Lihat semua pemberitahuan</a>
</li>

<hr>

@forelse($notifications as $notification)

	<form action="{{ route('mark.as.read') }}" id="notif_submit-{{ $notification->id }}" method="POST">

	@csrf

		<table>

			<tr>
				<td colspan="2" class="message">
					<a href="#" id="btn-submit-{{ $notification->id }}" onclick='event.preventDefault();document.getElementById("notif_submit-{{ $notification->id }}").submit()'>{{ $notification->data['message'] }}</a>
				</td>				
			</tr>
			
			<tr>
				<td class="type">
					<i class="fa fa-bolt" aria-hidden="true"></i>
					{{ $notification->data['type'] }}
				</td>
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

@empty

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

@endforelse

	<li class="text-center" role="menuitem" tabindex="0">
	  <i class="fa fa-eye"></i> <a href="{{ route('show.all.notifications') }}">Lihat semua pemberitahuan</a>
	</li>

