@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Omzet (Bulanan Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ number_format(core()->getOmzetMounth(), 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Omzet (Hari ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ number_format(core()->getOmzetDay(), 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transaksi (Hari ini)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ core()->countTransaction() }} Transaksi</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Produk/Menu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ core()->countProduct() }} Menu</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-primary font-weight-bold">Grafik Penjualan</div>

                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-primary font-weight-bold">Penjualan Terakhir</div>

                <div class="card-body">
                    @foreach (core()->limitTransaction() as $item)
                        <div class="jumbotron px-2 py-3 text-center" style="color:#5a5c69;">
                            <p class="font-weight-bold">{{ $item->invoice }} - {{ $item->user }} | Rp. {{ number_format($item->total, 0, ',', '.') }}</p>
                            <p>
                                @foreach ($item->orderDetail as $detail)
                                    <span>{{ $detail->product_name }} ({{ $detail->qty }})</span>
                                @endforeach
                            </p>
                            <button class="btn btn-primary btn-sm">Print Struk</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection