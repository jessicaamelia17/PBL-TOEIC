
@extends('layouts2.template')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 font-weight-bold">Edit Room</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.room.update', $room->id_room) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Room</label>
                            <input type="text" name="nama_room" value="{{ $room->nama_room }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Zoom ID</label>
                            <input type="text" name="zoom_id" value="{{ $room->zoom_id }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Zoom Password</label>
                            <input type="text" name="zoom_password" value="{{ $room->zoom_password }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Kapasitas</label>
                            <input type="number" name="kapasitas" value="{{ $room->kapasitas }}" class="form-control" required min="1">
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