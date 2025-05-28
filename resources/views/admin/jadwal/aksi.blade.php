<a href="{{ route('admin.jadwal.edit', $row->id_jadwal) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('admin.jadwal.destroy', $row->id_jadwal) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
</form>