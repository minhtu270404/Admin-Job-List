@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Thêm Tỉnh/Thành phố</h1>
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
                    <form action="{{ route('admin.states.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Quốc gia</label>
                            <select name="country_id" class="form-control select-country">
                                <option value="">-- Chọn quốc gia --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label>Tỉnh/Thành phố</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập tên tỉnh / bang">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <a href="{{ route('admin.states.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.select-country').change(function() {
        var country_id = $(this).val();
        var stateSelect = $('select[name="state_id"]');

        if(!stateSelect.length) return; // Nếu edit form không có select state thì skip

        stateSelect.empty();
        stateSelect.append('<option value="">-- Chọn tỉnh/thành --</option>');

        if(country_id) {
            $.ajax({
                url: '/admin/get-states/' + country_id,
                type: 'GET',
                success: function(data) {
                    data.forEach(function(state) {
                        stateSelect.append('<option value="'+state.id+'">'+state.name+'</option>');
                    });
                },
                error: function(err) {
                    console.error('Lỗi load state:', err);
                }
            });
        }
    });
});
</script>
@endsection
