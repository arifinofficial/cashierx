@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Main Produk</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary">Tambah Produk</div>

                <div class="card-body">
                    <form action="{{route('product.main-product.store')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="">Nama Produk</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="{{ $errors->has('name') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">SKU</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="{{ $errors->has('sku') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('sku'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sku') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 pt-3 pt-md-3">
                                <label for="">Kategori</label>
                                <select name="category_id" id="category_id" class="{{ $errors->has('category_id') ? 'form-control is-invalid' : 'form-control' }}">
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $key }}">{{ $category }}</option> 
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 pt-3 pt-md-3">
                                <label for="">Variant</label>
                                <select type="text" name="variant_id[]" id="variant_id" class="form-control variant" multiple>
                                    @foreach ($variants as $key => $variant)
                                        <option value="{{ $key }}">{{ $variant }}</option> 
                                    @endforeach
                                </select>
                                <small id="emailHelp" class="form-text text-muted pl-1">Kosongkan jika produk tidak memiliki variant.</small>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('bottom')
<script>
    $('.variant').select2({
        theme: 'bootstrap4',
    });
</script>
@endpush