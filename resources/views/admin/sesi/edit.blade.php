{{-- filepath: resources/views/admin/sesi/edit.blade.php --}}
@extends('layouts2.template')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 font-weight-bold">Edit Sesi Ujian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sesi.update', $sesi->id_sesi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Sesi</label>
                            <input type="text" name="nama_sesi" value="{{ $sesi->nama_sesi }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jam Mulai</label>
                            <input type="time" name="waktu_mulai" value="{{ substr($sesi->waktu_mulai, 0, 5) }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jam Selesai</label>
                            <input type="time" name="waktu_selesai" value="{{ substr($sesi->waktu_selesai, 0, 5) }}" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i> Update
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection