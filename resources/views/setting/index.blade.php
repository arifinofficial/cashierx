@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Setting</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary">Store Setting</div>

                <div class="card-body">
                    <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">Nama Toko</label>
                                <input type="text" name="store_name" id="store_name" value="{{ $setting != null ? $setting->store_name : '' }}" class="{{ $errors->has('store_name') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('store_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">Email Toko</label>
                                <input type="email" name="store_email" id="store_email" value="{{ $setting != null ? $setting->store_email : '' }}" class="{{ $errors->has('store_email') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('store_email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">Nomor Telpon</label>
                                <input type="number" min="0" name="store_phone" id="store_phone" value="{{ $setting != null ? $setting->store_phone : '' }}" class="{{ $errors->has('store_phone') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('store_phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">Alamat</label>
                                <input type="text" name="store_address" id="store_address" value="{{ $setting != null ? $setting->store_address : '' }}" class="{{ $errors->has('store_address') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('store_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mt-3 mt-md-3">
                            @if ($setting != null)
                            <div class="mb-3">
                                <img src="{{ asset($setting->store_logo) }}" alt="" class="img-fluid">
                            </div>
                            @endif
                            <label for="exampleFormControlFile1">Logo Toko</label>
                            <input type="file" class="form-control-file" name="store_logo" id="exampleFormControlFile1">
                        </div>
                        <div class="form-group mt-4 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection