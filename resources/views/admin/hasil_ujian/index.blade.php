@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Hasil Ujian TOEIC</h3>
            <div class="card-tools">
                <a href="{{ route('admin.hasil-ujian.import.form') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-import"></i> Import Data Hasil Ujian
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
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#table_hasil_ujian').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: true,
            order: [[9, 'desc']] // Urutkan berdasarkan Tanggal Ujian (index ke-9)
        });
    });
</script>
@endpush
