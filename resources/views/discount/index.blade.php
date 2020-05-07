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
        <h1 class="h3 mb-0 text-gray-800">Discount Member</h1>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-primary">Tambah Discount</div>
                <div class="card-body">
                    <form role="form" action="{{ route('discount.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Value</label>
                            <input type="text" name="value" class="form-control {{ $errors->has('value') ? 'is-invalid':'' }}" id="value" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="active">Aktif</option>
                                <option value="deactive">Tidak Aktif</option>
                            </select>
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
                            <td>Nama</td>
                            <td>Value</td>
                            <td>Status</td>
                            <td>Dibuat</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($discount as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->value }}</td>
                            <td>{{ $row->status }}</td>
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
                {!! $discount->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection