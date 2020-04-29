@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Harian</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-primary">Cetak Laporan Harian</div>

                <div class="card-body">
                    <form action="{{ route('report.daily.pdf') }}" method="GET">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="date" class="form-control date"/>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Cetak</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('top')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endpush

@push('bottom')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.date').daterangepicker({
            singleDatePicker: true,
        });
    });
</script>
@endpush