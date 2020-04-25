@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h2>Total: <strong>Rp. {{ number_format(request('orderTotal')) }}</strong></h2>
                    <h2 class="mt-3">Cash: <strong>Rp. {{ number_format(request('orderCash')) }}</strong></h2>
                    <h2 class="mt-3">Kembalian: <strong>Rp. {{ number_format(request('orderTotalChange')) }}</strong></h2>
                    <a href="{{ route('order.transaksi') }}" class="btn btn-primary mt-4">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection