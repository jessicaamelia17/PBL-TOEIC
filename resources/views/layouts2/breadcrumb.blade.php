<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- Kosong atau isi sesuai kebutuhan --}}
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (isset($breadcrumb) && is_array($breadcrumb))
                        @foreach ($breadcrumb as $i => $item)
                            @if ($i == count($breadcrumb) - 1)
                                <li class="breadcrumb-item active">{{ $item['label'] }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    @if (isset($item['url']) && $item['url'])
                                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                                    @else
                                        {{ $item['label'] }}
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>
</section>
