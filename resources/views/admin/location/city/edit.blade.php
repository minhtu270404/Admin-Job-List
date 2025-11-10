@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Thành phố</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cập nhật thành phố</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Quốc gia</label>
                                    <select name="country" class="form-control select2 country {{ hasError($errors, 'country') }}">
                                        <option value="">-- Chọn quốc gia --</option>
                                        @foreach ($countries as $country)
                                            <option @selected($country->id === $city->country_id) value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tỉnh / Bang</label>
                                    <select name="state" class="form-control select2 state {{ hasError($errors, 'state') }}">
                                        <option value="">-- Chọn tỉnh / bang --</option>
                                        @foreach ($states as $state)
                                            <option @selected($state->id === $city->state_id) value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tên thành phố</label>
                                    <input type="text" class="form-control {{ hasError($errors, 'city') }}" name="city" value="{{ old('city', $city->name) }}" placeholder="Nhập tên thành phố...">
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
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
        $('.country').on('change', function() {
            let country_id = $(this).val();

            $.ajax({
                method: 'GET',
                url: '{{ route("admin.get-states", ":id") }}'.replace(":id", country_id),
                success: function(response) {
                    let html = '<option value="">-- Chọn tỉnh / bang --</option>';
                    $.each(response, function(index, value) {
                        html += `<option value="${value.id}">${value.name}</option>`;
                    });
                    $('.state').html(html);
                }
            })
        })
    })
</script>
@endpush
