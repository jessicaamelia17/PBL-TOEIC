<div class="bg-white py-4 px-4 rounded shadow mx-4 mb-4 mt-8">
    <nav aria-label="breadcrumb" class="text-sm text-gray-600">
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            @if(isset($breadcrumb) && is_array($breadcrumb))
                @foreach($breadcrumb as $i => $item)
                    @if($item['url'] && $i < count($breadcrumb) - 1)
                        <li class="breadcrumb-item">
                            <a href="{{ $item['url'] }}" class="text-blue-600 hover:underline">{{ $item['label'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active text-gray-800" aria-current="page">{{ $item['label'] }}</li>
                    @endif
                @endforeach
            @else
                <li class="breadcrumb-item"><a href="#" class="text-blue-600 hover:underline">Home</a></li>
                <li class="breadcrumb-item active text-gray-800" aria-current="page">Dashboard</li>
            @endif
        </ol>
    </nav>
</div>