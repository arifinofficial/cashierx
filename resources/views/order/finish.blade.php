@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="badge badge-success">Nomor Order = {{ request('orderInvoice') }}</span></h4>
                    <table class="table">
                        <tr>
                            <th>Total</th>
                            <td>:</td>
                            <th><strong>Rp. {{ number_format(request('orderTotal')) }}</strong></th>
                        </tr>
                        <tr>
                            <th>Tunai</th>
                            <td>:</td>
                            <th><strong>Rp. {{ number_format(request('orderCash')) }}</strong></th>
                        </tr>
                        <tr>
                            <th>Kembalian</th>
                            <td>:</td>
                            <th><strong>Rp. {{ number_format(request('orderTotalChange')) }}</strong></th>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('print-order', ['orderInvoice' => request('orderInvoice')]) }}" class="btn btn-info mt-4"><i class="fas fa-print"></i> Print</a>
                        <a href="{{ route('order.transaksi') }}" class="btn btn-primary mt-4">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection