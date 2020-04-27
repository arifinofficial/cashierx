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
        <h1 class="h3 mb-0 text-gray-800">Role Permission</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('roles.permission.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required>
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <form action="{{ route('roles.permission.index') }}" method="GET">
                        <div class="form-group">
                            <label for="">Roles</label>
                            <div class="input-group">
                                <select name="role" class="form-control">
                                    @foreach ($roles as $value)
                                        <option value="{{ $value }}" {{ request()->get('role') == $value ? 'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger">Check!</button>
                                </span>
                            </div>
                        </div>
                    </form>
                    @if (!empty($permissions))
                            <form action="{{ route('roles.setRolePermission', request()->get('role')) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab">Permissions</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                @php $no = 1; @endphp
                                                @foreach ($permissions as $key => $row)
                                                    <input type="checkbox" 
                                                        name="permission[]" 
                                                        class="minimal-red" 
                                                        value="{{ $row }}"
                                                        {{ in_array($row, $hasPermission) ? 'checked':'' }}
                                                        > {{ $row }} <br>
                                                    @if ($no++%4 == 0)
                                                    <br>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pull-right">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-send"></i> Set Permission
                                    </button>
                                </div>
                            </form>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection