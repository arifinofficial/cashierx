<div class="card">
    <div class="card-header text-primary">{{ $mainProduct->name }}</div>

    <div class="card-body">
        <form action="{{ route('product.main-product.product.store', [$mainProduct->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="main_product_id" value="{{ $mainProduct->id }}">
            <input type="hidden" name="name" value="{{ $mainProduct->name }}">
            <input type="hidden" name="is_variant" value="{{ $mainProduct->is_variant }}">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="">Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp.</div>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="{{ $errors->has('price') ? 'form-control is-invalid' : 'form-control' }}">
                        @if ($errors->has('price'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">Harga Grab</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp.</div>
                          </div>
                        <input type="number" name="grab_price" id="grab_price" value="{{ old('grab_price') }}" class="{{ $errors->has('grab_price') ? 'form-control is-invalid' : 'form-control' }}">
                        @if ($errors->has('grab_price'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('grab_price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 mt-md-3">
                <label for="exampleFormControlFile1">Foto Produk</label>
                <input type="file" class="form-control-file" name="picture" id="exampleFormControlFile1">
            </div>
            <div class="form-group mt-3 mt-md-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" value="0" id="exampleCheck1">
                    <label class="form-check-label" for="">Inactive</label>
                </div>
            </div>
            <div class="form-row mt-3 mt-md-3" id="item-wrapper">
                <div class="col-md-7 pt-3">
                    <label for="">Item</label>
                    <input type="text" name="items[0][name]" id="item" class="form-control">
                </div>
                <div class="col-md-2 pt-3">
                    <label for="">Recipe</label>
                    <input type="number" name="items[0][recipe]" id="recipe" class="form-control">
                </div>
                <div class="col-md-2 pt-3">
                    <label for="">Unit</label>
                    <select name="items[0][unit]" id="unit_id" class="form-control unit count-0">
                        @foreach ($units as $id => $item)
                            <option value="{{ $id }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 pt-3 d-flex align-items-end">
                    <button class="btn btn-danger w-100"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <div class="form-group mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button class="btn btn-info" id="add-list"><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </div>
</div>