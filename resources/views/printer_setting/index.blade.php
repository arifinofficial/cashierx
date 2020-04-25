@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Setting</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary">Printer Setting</div>

                <div class="card-body">
                    <form action="{{ route('setting-printer.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">Nama Printer</label>
                                <input type="text" name="printer_name" id="printer_name" value="{{ $printerSetting != null ? $printerSetting->printer_name : '' }}" class="{{ $errors->has('printer_name') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('printer_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('printer_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <label for="">IP Printer</label>
                                <input type="text" name="printer_ip" id="printer_ip" value="{{ $printerSetting != null ? $printerSetting->printer_ip : '' }}" class="{{ $errors->has('printer_ip') ? 'form-control is-invalid' : 'form-control' }}">
                                @if ($errors->has('printer_ip'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('printer_ip') }}</strong>
                                    </span>
                                @endif
                            </div>
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