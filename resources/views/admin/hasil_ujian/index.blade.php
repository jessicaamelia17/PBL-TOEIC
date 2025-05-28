@extends('layouts2.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Hasil Ujian TOEIC</h3>
        <div class="card-tools">
            <button class="btn btn-success" data-toggle="modal" data-target="#importCSVModal">
                <i class="fas fa-file-import"></i> Import CSV
            </button>
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
                    @foreach ($results as $index => $item)
                    <tr>
                        <td class="text-center">{{ $results->firstItem() + $index }}</td>
                        <td>{{ $item->Nama }}</td>
                        <td class="text-center">{{ $item->NIM}}</td>
                        <td class="text-center">{{ $item->Listening}}</td>
                        <td class="text-center">{{ $item->Reading}}</td>
                        <td class="text-center">{{ $item->Skor}}</td>
                        <td class="text-center">{{ $item->Listening_2 }}</td>
                        <td class="text-center">{{ $item->Reading_2 }}</td>
                        <td class="text-center">{{ $item->Skor_2 }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->Tanggal_Ujian)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $item->Status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $results->links() }}
        </div>
    </div>
</div>

<!-- Modal Import CSV -->
<div class="modal fade" id="importCSVModal" tabindex="-1" aria-labelledby="importCSVModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.hasil-ujian.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importCSVModalLabel">Import Hasil Ujian TOEIC</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="form-group mb-3">
            <label for="file">Pilih File</label>
            <input type="file" name="file" accept=".csv" required class="form-control" id="file">
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#table_hasil_ujian').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: true,
            order: [[9, 'desc']]
        });
    });
</script>
@endpush
