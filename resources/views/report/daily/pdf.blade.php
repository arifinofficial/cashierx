<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Laporan Harian</title>
    <style>
        .page_break {
            page-break-before: always;
        }

        table {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="text-center">GOUD KOFFIE</h4>
                <small>JL. MT. Haryono No 8, Tulungagung</small> <br>
                <small>Laporan Penjualan Tanggal 02-05-2020</small>
                <hr style="border-color:#000">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Faktur</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembali</th>
                            <th>Tanggal</th>
                        </tr>
                        @php
                        $total = 0;
                        $cash = 0;
                        $total_change = 0;
                        @endphp
                        @foreach ($results as $key => $result)
                        <tr>
                            <th class="text-center">{{ $key+1 }}</th>
                            <td class="text-center">{{ $result->invoice }}</td>
                            <td class="text-center">{{ $result->user }}</td>
                            <td class="text-center">{{ number_format($result->total, 0, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($result->cash, 0, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($result->total_change, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $result->created_at->format('d-m-Y - H:i:s') }}</td>
                        </tr>
                        @php
                        $total += $result->total;
                        $cash += $result->cash;
                        $total_change += $result->total_change;
                        @endphp
                        @endforeach
                        <tr class="text-center">
                            <th class="border-0" colspan="3"><strong>Sub Total:</strong></th>
                            <th class="border-0"><strong>{{ number_format($total, 0, ',', '.') }}</strong></th>
                            <th class="border-0"><strong>{{ number_format($cash, 0, ',', '.') }}</strong></th>
                            <th class="border-0"><strong>{{ number_format($total_change, 0, ',', '.') }}</strong></th>
                            <th class="border-0"></th>
                        </tr>
                        <tr class="text-center">
                            <th class="border-top-1 border-left-0 border-right-0 border-bottom-0" colspan="3">
                                <strong>Total:</strong></th>
                            <th class="border-top-1 border-left-0 border-right-0 border-bottom-0">
                                <strong>{{ number_format($total, 0, ',', '.') }}</strong></th>
                            <th class="border-top-1 border-left-0 border-right-0 border-bottom-0">
                                <strong>{{ number_format($cash, 0, ',', '.') }}</strong></th>
                            <th class="border-top-1 border-left-0 border-right-0 border-bottom-0">
                                <strong>{{ number_format($total_change, 0, ',', '.') }}</strong></th>
                            <th class="border-top-1 border-left-0 border-right-0 border-bottom-0"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="page_break"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @foreach ($results as $result)
                <hr>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Faktur: {{ $result->invoice }}</th>
                            <td>Kasir: {{ $result->user }}</td>
                            <td>Total: {{ number_format($result->total, 0, ',', '.') }}</td>
                            <td>Bayar: {{ number_format($result->cash, 0, ',', '.') }}</td>
                            <td>Kembali: {{ number_format($result->total_change, 0, ',', '.') }}</td>
                            <td>{{ $result->created_at->format('d-m-Y - H:i:s') }}</td>
                        </tr>
                    </thead>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result->orderDetail as $key => $item)
                        <tr class="text-center">
                            <th>{{ $key+1 }}</th>
                            <td>{{ $item->product_name }} {{ $item->variant }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="text-center">
                            <th colspan="4">Total:</th>
                            <th>{{ number_format($result->total, 0, ',', '.') }}</th>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>