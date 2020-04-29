@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Main Produk</h1>
        <a href="{{ route('product.main-product.create') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" title="Tambah Produk"><i
                class="fas fa-plus fa-sm text-white-50"></i> Buat Baru</a>
    </div>
    <div class="row justify-content-center">
        @foreach ($mainProducts as $mainProduct)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header text-primary text-center">{{ $mainProduct->name }}</div>

                    <div class="card-body">
                        {{ $mainProduct->category->name }}
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('product.main-product.show', [$mainProduct->id]) }}" class="btn btn-primary btn-sm w-100"><i class="fas fa-eye"></i> Lihat</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('product.main-product.destroy', [$mainProduct->id]) }}" class="btn btn-danger btn-sm w-100 delete" data-name="{{ $mainProduct->name }}"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $mainProducts->links() }}
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