@extends('layouts2.template')

@section('content')
<div class="container">
    <h1>Edit Room</h1>
    <form action="{{ route('admin.room.update', $room->id_room) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Room</label>
            <input type="text" name="nama_room" value="{{ $room->nama_room }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Zoom ID</label>
            <input type="text" name="zoom_id" value="{{ $room->zoom_id }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Zoom Password</label>
            <input type="text" name="zoom_password" value="{{ $room->zoom_password }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Kapasitas</label>
            <input type="number" name="kapasitas" value="{{ $room->kapasitas }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
