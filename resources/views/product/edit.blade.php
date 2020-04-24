@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header text-primary">{{ $product->name }} - {{ $product->sku }}</div> --}}

                <div class="card-body">
                    <form action="{{ route('product.main-product.product.update', [$product->mainProduct->id, $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="">Nama Produk</label>
                                <input type="text" name="name" id="name" value="{{ $product->name }}" class="{{ $errors->has('name') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">SKU</label>
                                <input type="text" name="sku" id="sku" value="{{ $product->sku }}" class="{{ $errors->has('sku') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('sku'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sku') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row mt-3 mt-md-3">
                            <div class="col-md-6">
                                <label for="">Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                      </div>
                                    <input type="number" name="price" id="price" value="{{ $product->price }}" class="{{ $errors->has('price') ? 'form-control is-invalid' : 'form-control' }}">
                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">Qty</label>
                                <input type="number" name="qty" id="qty" value="{{ $product->qty }}" class="{{ $errors->has('qty') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('qty'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('qty') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mt-3 mt-md-3">
                            <div class="my-4">
                                <img src="{{$product->picture != null ? asset($product->picture) :  asset('images/cashierx/300x300.png')}}" class="img-fluid" alt="">
                            </div>
                            <label for="exampleFormControlFile1">Foto Produk</label>
                            <input type="file" class="form-control-file" name="picture" id="exampleFormControlFile1">
                        </div>
                        @if (count($productItems) == 0)
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
                        @else
                        <div class="form-row mt-3 mt-md-3" id="item-wrapper">
                            @foreach ($productItems as $key => $productItem)
                            <div class="col-md-7 pt-3">
                                <label for="">Item</label>
                                <input type="text" name="items[{{ $key }}][name]" value="{{ $productItem->name }}" id="item" class="form-control" required>
                            </div>
                            <div class="col-md-2 pt-3">
                                <label for="">Recipe</label>
                                <input type="number" name="items[{{ $key }}][recipe]" value="{{ $productItem->recipe }}" id="recipe" class="form-control" required>
                            </div>
                            <div class="col-md-2 pt-3">
                                <label for="">Unit</label>
                                <select name="items[{{ $key }}][unit]" id="unit_id" class="form-control unit count-{{ $key }}">
                                    @foreach ($units as $id => $item)
                                        <option value="{{ $id }}" {{ $productItem->unit->id == $id ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 pt-3 d-flex align-items-end">
                                <a href="{{ route('product.product-item.destroy', $productItem->id) }}" data-name="{{ $productItem->name }}" class="btn btn-danger w-100 delete"><i class="fa fa-trash"></i></a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="form-group mt-4 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button class="btn btn-info" id="add-list"><i class="fas fa-plus"></i></button>
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
    var count = parseInt($('.form-row .unit').last().attr('class').slice(-1)) + 1;
    var units = JSON.parse('{!! $units !!}');
    
    $('#add-list').click(function(e){
        e.preventDefault();
    
        var wrapper = $('#item-wrapper');
        var html = `
        <div class="col-md-7 pt-3">
            <label for="">Item</label>
            <input type="text" name="items[`+count+`][name]" id="item" class="form-control" required>
        </div>
        <div class="col-md-2 pt-3">
            <label for="">Recipe</label>
            <input type="number" name="items[`+count+`][recipe]" id="recipe" class="form-control" required>
        </div>
        <div class="col-md-2 pt-3">
            <label for="">Unit</label>
            <select name="items[`+count+`][unit]" id="unit_id" class="form-control unit count-`+count+`">
            </select>
        </div>
        <div class="col-md-1 pt-3 d-flex align-items-end">
            <button class="btn btn-danger w-100"><i class="fa fa-trash"></i></button>
        </div>
        `
        $(wrapper).append(html);
    
        $.each(units, function(i, item){
            var option = new Option(item, i);
            $(option).html(item);
            $(".unit.count-"+count+"").append(option);
        });
    
        count++;
    });

    $('.delete').click(function(e){
        e.preventDefault();

        var me      = $(this),
        name        = me.attr('data-name'),
        url         = me.attr('href'),
        csrf_token  = $('meta[name="csrf-token"]').attr('content');

        swal({
            text: 'Apakah anda yakin menghapus data ' + name + '?', 
            buttons: {
                cancel: true,
                confirm: true,
            }
        }).then((result) => {
            if (result) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token,
                    },
                    success: function(response){
                        swal({
                            title: 'Sukses!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 3000
                        });
                        location.reload();
                    },
                    error: function(xhr){
                        swal({
                            title: 'Error!',
                            text: 'Data gagal dihapus.',
                            icon: 'error',
                            timer: 3000
                        });
                    }
                });
            }
        });
    })
    </script>
@endpush