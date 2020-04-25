@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User</h1>
        <a href="{{ route('user.create') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm modal-show" title="Tambah User"><i
                class="fas fa-plus fa-sm text-white-50"></i> Buat Baru</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary">Tabel User</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display nowrap table table-hover"
                            cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
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
            ajax:"{{ route('api.datatable.user') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        })
</script>
@endpush