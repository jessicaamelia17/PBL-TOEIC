@extends('layouts2.template')

@section('content')
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Import Data Hasil Ujian TOEIC</h3>
            <div class="card-tools">
                <a href="{{ route('admin.hasil-ujian.index') }}" class="btn btn-sm btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.hasil-ujian.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih file Excel (.xls, .xlsx):</label>
                    <input type="file" name="file" id="file" accept=".xls,.xlsx" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Import Data</button>
            </form>
        </div>
    </div>
</div>
@endsection
