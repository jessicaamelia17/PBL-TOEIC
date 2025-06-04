@extends('layouts2.template')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 font-weight-bold">Edit Jadwal Ujian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Hidden field id_kuota --}}
                        <input type="hidden" name="id_kuota" value="{{ $jadwal->id_kuota }}">

                        {{-- Info kuota --}}
                        <div class="alert alert-info">
                            Kuota ini termasuk dalam ID Kuota: <strong>{{ $jadwal->id_kuota }}</strong>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Tanggal Ujian</label>
                            <input type="date" name="Tanggal_Ujian" class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($jadwal->Tanggal_Ujian)->format('Y-m-d') }}" required>
                        </div>
                        

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Kuota Maksimum</label>
                            <input type="number" name="kuota_max" class="form-control" 
                                   value="{{ $jadwal->kuota_max }}" required min="1">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i> Update
                            </button>
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
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
