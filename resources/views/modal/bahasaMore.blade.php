<div id="modalBahasa" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Daftar Bahasa</h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="tipe">
        <table class="table datatable" id="tabelKata">
            <thead>
                <th>No.</th>
                <th>Bahasa</th>
                <th>Action</th>
            </thead>
            <tbody>
                @php
                    $bahasa = \DB::table('bahasas')->get();
                @endphp
                @foreach($bahasa as $key => $value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->nama }}</td>
                    <td><button class="btn btn-primary" onclick="pilihBahasa({{$value->id}},'{{$value->nama}}')">Pilih</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
