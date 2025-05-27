@extends('layouts2.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Hasil Ujian TOEIC</h3>
        <div class="card-tools">
                <button id="toggleImportForm" class="btn btn-success">                <i class="fas fa-file-import"></i> Import CSV
            </button>
        </div>
    </div>

    {{-- Form Import CSV (hidden default) --}}
    <div id="importFormContainer" class="card-body d-none border-bottom">
        <form action="{{ route('admin.hasil-ujian.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center flex-wrap" style="max-width: 480px; margin-left: auto;">
            @csrf
            <input type="file" name="file" accept=".csv" required class="form-control form-control-sm" style="max-width: 300px;">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-upload"></i> Upload CSV
            </button>
            <button type="button" id="cancelImportForm" class="btn btn-secondary btn-sm">Batal</button>
        </form>
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
                        <td class="text-center">{{ $item->NIM }}</td>
                        <td class="text-center">{{ $item->Listening_1 }}</td>
                        <td class="text-center">{{ $item->Reading_1 }}</td>
                        <td class="text-center">{{ $item->Skor_1 }}</td>
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
@endsection

@push('js')
<script>
    // Toggle form Import CSV tampil/sembunyi
    document.getElementById('toggleImportForm').addEventListener('click', function () {
        document.getElementById('importFormContainer').classList.toggle('d-none');
    });

    // Tombol batal sembunyikan form
    document.getElementById('cancelImportForm').addEventListener('click', function () {
        document.getElementById('importFormContainer').classList.add('d-none');
    });

    // DataTable init
    $(document).ready(function () {
        $('#table_hasil_ujian').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: true,
            order: [[9, 'desc']] // Urutkan berdasarkan tanggal ujian
        });
    });
</script>
@endpush
