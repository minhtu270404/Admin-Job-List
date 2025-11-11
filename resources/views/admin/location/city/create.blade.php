@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Thêm thành phố mới</h1>
    </div>

    <div class="section-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cities.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Quốc gia -->
                            <div class="col-md-4">
                                <label>Quốc gia</label>
                                <select name="country_id" class="form-control select2 country">
                                    <option value="">-- Chọn quốc gia --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                            </div>

                            <!-- Tỉnh / Bang -->
                            <div class="col-md-4">
                                <label>Tỉnh / Bang</label>
                                <select name="state_id" class="form-control select2 state">
                                    <option value="">-- Chọn tỉnh / bang --</option>
                                </select>
                                <x-input-error :messages="$errors->get('state_id')" class="mt-2" />
                            </div>

                            <!-- Tên thành phố -->
                            <div class="col-md-4">
                                <label>Tên thành phố</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập tên thành phố...">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
                        <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function loadStates(countryId, selectedStateId = null) {
        if(!countryId) {
            $('.state').html('<option value="">-- Chọn tỉnh / bang --</option>');
            return;
        }

        $.ajax({
            url: `/admin/get-states/${countryId}`,
            type: 'GET',
            success: function(states) {
                let html = '<option value="">-- Chọn tỉnh / bang --</option>';
                $.each(states, function(index, state) {
                    html += `<option value="${state.id}" ${selectedStateId == state.id ? 'selected' : ''}>${state.name}</option>`;
                });
                $('.state').html(html);
            },
            error: function(err) {
                console.error('Lỗi load state:', err);
            }
        });
    }

    // Khi đổi quốc gia
    $('.country').on('change', function() {
        let countryId = $(this).val();
        loadStates(countryId);
    });

    // Nếu đang edit, load state mặc định
    @if(isset($city))
        let countryId = $('.country').val();
        let selectedState = "{{ old('state_id', $city->state_id ?? '') }}";
        loadStates(countryId, selectedState);
    @endif
});
</script>
@endpush
