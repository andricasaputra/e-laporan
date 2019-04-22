<!-- Modal -->

<div class="modal fade" id="laporanOperasionalDownloadModal" tabindex="-1" role="dialog" aria-labelledby="laporanOperasionalDownloadModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="{{ route('kh.download.operasional') }}" method="POST">
			<div class="modal-content">
				
				<div class="modal-header">
					<h5 class="modal-title" id="laporanOperasionalDownloadModalLabel">Download Laporan Operasional</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					
					@csrf
					@method('POST')

					<input type="hidden" name="jenisLaporan" value="laporan_operasional">
					
					<div class="form-group">
						<label for="year">Pilih Tahun</label>
						<select class="form-control" name="year" id="year">
							@for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)
							
							@if($i == date('Y'))
							
							<option value="{{ $i }}" selected>{{ $i }}</option>
							
							@else
							
							<option value="{{ $i }}">{{ $i }}</option>
							
							@endif
							
							@endfor
						</select>
					</div>
					<div class="form-group">
						<label for="month">Pilih Bulan</label>
						<select class="form-control" name="month" id="month">
							
							<option value="all">Semua bulan</option>
							
							@for($i = 1; $i < 13 ; $i++)
							
							<option value="{{ $i }}">{{ bulan($i) }}</option>
							
							@endfor
							
						</select>
					</div>
					<div class="form-group">
						<label for="wilker">Pilih Wilker</label>
						<select name="wilker_id" id="wilker" class="form-control">
						
							@foreach($wilkers as $wilker)
							
							@if($wilker->id === 1)
							
							<option value="">Semua Wilker</option>
							
							@else
							
							<option value="{{ $wilker->id }}">{{ $wilker->getOriginal('nama_wilker') }}</option>
							
							@endif
							
							@endforeach
							
						</select>
					</div>
					<div class="form-group">
						<label for="type">Pilih Permohonan</label>
						<select class="form-control" name="type" id="type">
							<option value="all">Semua permohonan</option>
							<option value="Domas">Domestik Masuk</option>
							<option value="Dokel">Domestik Keluar</option>
							<option value="Ekspor">Ekspor</option>
							<option value="Impor">Impor</option>
							<option value="Reekspor">Re Ekspor</option>
							<option value="SerahTerima">Serah Terima</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="signatory">Pilih Penandatangan Laporan</label>
						<select class="form-control" name="signatory" id="signatory">
							@foreach($pegawai as $p)
							<option value="{{ $p->id }}">{{ $p->nama }}</option>
							@endforeach
							<option value=""></option>
						</select>
					</div>
					
					<input type="hidden" name="karantina" value="Kh">
					
					<div class="pageSetup">
						
						<hr>
						
						<h5>Page Setup <i class="fa fa-file-o"></i></h5>
						
						<hr>
						
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="paperSize">Ukuran Kertas</label>
									<select name="paperSize" class="form-control">
										<option value="8">A3</option>
										<option value="1">Letter</option>
										<option value="5">Legal</option>
										<option value="9">A4</option>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="paperSize">Scale (angka dalam %)</label>
									<input type="number" name="scale" class="form-control" value="21">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="orientation">Orientation</label>
									<select name="orientation" class="form-control">
										<option value="landscape">Landscape</option>
										<option value="potrait">Potrait</option>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="font">Font</label>
									<select name="font" class="form-control">
										<option value="Arial">Arial</option>
										<option value="Calibri">Calibri</option>
										<option value="Times New Roman">Times New Roman</option>
										<option value="Verdana">Verdana</option>
									</select>
								</div>
							</div>
						</div>
						
					</div>
					
					<a href="#" class="pageSetupButton"><i class="fa fa-print"></i> page setup</a>
					
				</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Download</button>
				</div>
			</div>
			
		</form>
		
	</div>
</div>