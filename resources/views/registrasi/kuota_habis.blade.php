@extends('layouts.app2')
@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-lg p-8 text-center">
    <h2 class="text-3xl font-bold text-red-700 mb-6">@lang('users.quota_full')</h2>
    <p class="text-lg">@lang('users.quota_full_desc')</p>
</div>
@endsection