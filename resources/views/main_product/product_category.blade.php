@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kategori {{ $mainProducts->name }}</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="row">
                @foreach ($mainProducts->mainProducts as $mainProduct)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header text-primary text-center">{{ $mainProduct->category->name }}</div>
                        <div class="card-body text-center">
                            {{ $mainProduct->name }}
                            @if ($mainProduct->is_variant != 0)
                            <div>
                                @foreach ($mainProduct->variants as $variant)
                                    <span class="badge badge-primary mt-3">{{ $variant->name }}</span>
                                @endforeach
                            </div>
                            @endif
                            <div class="mt-3">
                                @foreach ($mainProduct->products as $product)
                                    <span class="font-weight-bold d-block">Rp. {{ number_format($product->price, 0, ',', '.') }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('product.main-product.show', [$mainProduct->id]) }}"
                                        class="btn btn-primary btn-sm w-100"><i class="fas fa-eye"></i></a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('product.main-product.destroy', [$mainProduct->id]) }}"
                                        class="btn btn-danger btn-sm w-100 delete"
                                        data-name="{{ $mainProduct->name }}"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-primary text-center font-weight-bold">
                    Kategori
                </div>
                <div class="card-body">
                    <ul class="category text-primary">
                        @foreach ($categories as $category)
                        <li><a href="{{ route('product.main-product.category', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('top')
<style>
    ul.category {
        list-style-type: none;
        padding-left: 0;
    }

    ul.category li:first-child {
        padding-top: 0px;
    }

    ul.category li {
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
</style>
@endpush

@push('bottom')
<script>
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