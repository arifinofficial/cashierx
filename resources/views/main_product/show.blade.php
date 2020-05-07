@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <strong>{!! $message !!}</strong>
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <strong>{!! $message !!}</strong>
    </div>
    @endif
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Kategori
                </div>
                <div class="card-body">
                    <form action="{{ route('product.main-product.update', request('main_product')) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-10">
                                <select name="category_id" id="" class="form-control">
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $key }}" {{ $mainProducts[0]->mainProduct->category_id == $key ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($mainProducts as $mainProduct)
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-3 text-primary">Detail Produk</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Nama Produk</th>
                                        <td>{{ $mainProduct->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Produk ID</th>
                                        <td>{{ $mainProduct->id }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Harga</th>
                                        <td>{{ $mainProduct->price }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Harga Grab</th>
                                        <td>{{ $mainProduct->grab_price }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td>{{ $mainProduct->is_active != 1 ? 'Tidak Aktif' : 'Aktif' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4 d-none">
                                <h4 class="mb-3 text-primary">Produk Item</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Item</th>
                                            <th scope="col">Recipe</th>
                                            <th scope="col">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mainProduct->productItems()->get() as $item)
                                        <tr>
                                            <th scope="row">{{ $item->name }}</th>
                                            <td>{{ $item->recipe }}</td>
                                            <td>{{ $item->unit->name }} ({{ $item->unit->code }})</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="{{$mainProduct->picture != null ? asset($mainProduct->picture) :  asset('images/cashierx/300x300.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('product.main-product.product.edit', [$mainProduct->mainProduct->id, $mainProduct->id]) }}"
                                class="btn btn-info btn-sm mr-3"><i class="fas fa-pen"></i> Ubah</a>
                            <a href="{{ route('product.main-product.product.destroy', [$mainProduct->mainProduct->id, $mainProduct->id]) }}" class="btn btn-danger btn-sm delete" data-name="{{ $mainProduct->name }}"><i class="fas fa-trash"></i> Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     @endforeach
    </div>
</div>
@endsection

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
                        window.location = '{{ route("product.main-product.index") }}';
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