@extends('admin.layouts.master')
@section('module', 'Quản trị')
@section('action', 'Hồ sơ cá nhân')

@section('contents')

    <h2 class="section-title">Xin chào, {{ Auth::user()->username }}!</h2>
    <p class="section-lead">Cập nhật thông tin cá nhân của bạn bên dưới.</p>

    <div class="row mt-4">
        {{-- Cột trái: Thông tin hồ sơ --}}
        @include('admin.profile.partials.left-profile-info')

        {{-- Cột phải: Form hồ sơ --}}
        @include('admin.profile.partials.right-profile-info')

    </div>

    @push('scripts')
        @include('admin.profile.partials.script')
    @endpush

@endsection
