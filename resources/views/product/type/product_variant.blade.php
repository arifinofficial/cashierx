<form action="{{ route('product.main-product.product.store', [$mainProduct->id]) }}" method="POST" enctype="multipart/form-data">
    @foreach (core()->getRelatedMainProductVariant() as $key => $variant)
        <div class="card mb-4">
        <div class="card-header text-primary">{{ $mainProduct->name }} - {{ $variant->name }}</div>
            <div class="card-body">
                @csrf
                <input type="hidden" name="main_product_id" value="{{ $mainProduct->id }}">
                <input type="hidden" name="name" value="{{ $mainProduct->name }}">
                <input type="hidden" name="is_variant" value="{{ $mainProduct->is_variant }}">
                <input type="hidden" name="sku" value="{{ $mainProduct->sku }}">
                <input type="hidden" name="products[{{ $key }}][variant]" value="{{ $variant->name }}">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" name="products[{{ $key }}][price]" id="price" value="{{ old('price') }}" class="{{ $errors->has('price') ? 'form-control is-invalid' : 'form-control' }}">
                            @if ($errors->has('price'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 pt-3 pt-md-0">
                        <label for="">Qty</label>
                        <input type="number" min="0" name="products[{{ $key }}][qty]" id="qty" value="{{ old('qty') }}" class="{{ $errors->has('qty') ? 'form-control is-invalid' : 'form-control' }}">
                        @if ($errors->has('qty'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('qty') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group mt-3 mt-md-3">
                    <label for="exampleFormControlFile1">Foto Produk</label>
                    <input type="file" name="products[{{ $key }}][picture]" id="picture" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <div class="form-row mt-3 mt-md-3 item-wrapper" item-wrapper={{ $key }}>
                    <span class="0"></span>
                    <div class="col-md-7 pt-3">
                        <label for="">Item</label>
                        <input type="text" name="products[{{ $key }}][items][0][name]" id="item" class="form-control">
                    </div>
                    <div class="col-md-2 pt-3">
                        <label for="">Recipe</label>
                        <input type="number" name="products[{{ $key }}][items][0][recipe]" id="recipe" class="form-control">
                    </div>
                    <div class="col-md-2 pt-3">
                        <label for="">Unit</label>
                        <select name="products[{{ $key }}][items][0][unit]" id="unit_id" class="form-control unit count-0">
                            @foreach ($units as $id => $item)
                                <option value="{{ $id }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 pt-3 d-flex align-items-end">
                        <button class="btn btn-danger w-100"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                <div class="form-group mt-4 d-flex justify-content-end">
                    <button class="btn btn-info add-list" data-index={{ $key }}><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>      
    @endforeach
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>