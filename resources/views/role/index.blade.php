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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role</h1>
        <a href="{{ route('user.create') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm modal-show" title="Tambah User"><i
                class="fas fa-plus fa-sm text-white-50"></i> Buat Baru</a>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-primary">Role</div>
                <div class="card-body">
                    <form role="form" action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Role</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Role</td>
                            <td>Guard</td>
                            <td>Created At</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($role as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->guard_name }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>
                                <form action="{{ route('role.destroy', $row->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="float-right">
                {!! $role->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection