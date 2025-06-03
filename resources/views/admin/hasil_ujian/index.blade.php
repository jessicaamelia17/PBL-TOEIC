@extends('layouts2.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Data Hasil Ujian TOEIC</h3>
        <div class="ml-auto">
            <button class="btn btn-success mr-2" data-toggle="modal" data-target="#importCSVModal">
                <i class="fas fa-file-import"></i> Import CSV
            </button>
            <button class="btn btn-success" data-toggle="modal" data-target="#exportCSVModal">
                <i class="fas fa-file-export"></i> Export CSV
            </button>
            <a href="{{ route('admin.hasil-ujian.exportPdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table id="table_hasil_ujian" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Listening 1</th>
                        <th>Reading 1</th>
                        <th>Skor 1</th>
                        <th>Listening 2</th>
                        <th>Reading 2</th>
                        <th>Skor 2</th>
                        <th>Tanggal Ujian</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $item)
                    <tr class="{{ $item->Status == 'Lulus' ? 'table-success' : 'table-danger' }}">
                        <td></td> <!-- Nomor urut akan diisi otomatis oleh DataTables -->
                        <td>{{ optional($item->pendaftaran->mahasiswa)->nama ?? '-' }}</td>
                        <td class="text-center">{{ $item->pendaftaran->NIM }}</td>
                        <td class="text-center">{{ $item->listening_1 }}</td>
                        <td class="text-center">{{ $item->reading_1 }}</td>
                        <td class="text-center">{{ $item->total_skor_1 }}</td>
                        <td class="text-center">{{ $item->Listening_2 }}</td>
                        <td class="text-center">{{ $item->Reading_2 }}</td>
                        <td class="text-center">{{ $item->total_skor_2 }}</td>
                        <td class="text-center">
                            {{ optional($item->pendaftaran->jadwal_ujian)->Tanggal_Ujian
                                ? \Carbon\Carbon::parse($item->pendaftaran->jadwal_ujian->Tanggal_Ujian)->format('d-m-Y') 
                                : '-' }}
                        </td>
                        <td class="text-center">{{ $item->Status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal Import CSV -->
            <div class="modal fade" id="importCSVModal" tabindex="-1" role="dialog" aria-labelledby="importCSVModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form action="{{ route('admin.hasil-ujian.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="importCSVModalLabel">Import CSV Hasil Ujian</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Import</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Modal Export CSV -->
            <div class="modal fade" id="exportCSVModal" tabindex="-1" role="dialog" aria-labelledby="exportCSVModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form action="{{ route('admin.hasil-ujian.export') }}" method="GET">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exportCSVModalLabel">Export CSV Hasil Ujian</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Export</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        var t = $('#table_hasil_ujian').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: true,
            order: [[1, 'asc']], // urutkan berdasarkan kolom Nama (kolom ke-2)
            columnDefs: [
                { orderable: false, searchable: false, targets: 0 } // kolom No tidak bisa di-sort/search
            ]
        });

        // Auto-numbering kolom No
        t.on('order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
@endpush