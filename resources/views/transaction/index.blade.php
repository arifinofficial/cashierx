@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary font-weight-bold">Data Transaksi</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display nowrap table table-hover"
                            cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>No Order</th>
                                    <th>Kasir</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#ID</th>
                                    <th>No Order</th>
                                    <th>Kasir</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials._modal')
@endsection

@push('bottom')
<script src="{{ asset('js/ajax.js') }}"></script>
<script>
    $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[ 0, "desc" ]],
            ajax:"{{ route('api.datatable.transaction-data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'invoice', name: 'invoice'},
                {data: 'user', name: 'user'},
                {data: 'total', name: 'total'},
                {data: 'cash', name: 'cash'},
                {data: 'total_change', name: 'total_change'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        })
</script>
@endpush