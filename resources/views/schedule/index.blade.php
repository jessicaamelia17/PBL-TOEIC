@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas fa-calendar-alt fs-4"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0 fw-semibold">@lang('users.shcedule_title')</h3>
                    <p class="text-muted mb-0">@lang('users.shcedule_desc')</p>
                </div>
            </div>

            @if($jadwal->isEmpty())
                <div class="alert alert-secondary text-center rounded-3 p-4">
                    <i class="fas fa-info-circle fs-4 text-muted mb-2 d-block"></i>
                    <strong>@lang('users.no_schedule')</strong><br>
                    @lang('users.no_schedule_dest')
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead class="bg-light">
                            <tr class="text-muted text-uppercase small">
                                <th style="width: 60%">@lang('users.exam_date')</th>
                                <th class="text-center" style="width: 40%">@lang('users.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $jadwalItem)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <div>
                                                <div class="fw-semibold fs-6">{{ \Carbon\Carbon::parse($jadwalItem->Tanggal_Ujian)->translatedFormat('l, d F Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.schedule.pendaftar', ['id' => $jadwalItem->id_jadwal]) }}"
                                           class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                            <i class="fas fa-users me-1"></i> @lang('users.view_participants')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
