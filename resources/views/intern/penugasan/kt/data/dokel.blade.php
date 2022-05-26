<div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Penugasan Domestik Keluar</h4>
          <table class="table table-bordered" id="PenugasanDokelKt" style="width: 100%">
            <thead>
              <tr>
                @foreach($headerstable as $header)
                  <th>{{ ucwords(str_replace("_", " ",$header)) }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
</div>
