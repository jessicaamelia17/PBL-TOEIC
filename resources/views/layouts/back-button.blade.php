<div class="mb-2 mx-4">
    <form method="POST" action="{{ route('go.back') }}">
        @csrf
        <button type="submit" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded shadow transition">
            <i class="fas fa-arrow-left mr-2"></i> @lang('users.back')
        </button>
    </form>
</div>
