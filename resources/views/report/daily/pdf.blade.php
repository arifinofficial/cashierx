<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <title>Laporan Harian</title>
    <style>
        .page_break {
            page-break-before: always;
        }
        table {
            font-size: 10px;
            border-collapse: collapse;
            /* border: 1px solid #585858; */
        }
        table th, table td{
            border: 1px solid #676767;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .border-0{
            border: none !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center" style="margin-bottom: 20px">
                <h4 class="text-center" style="margin-bottom: 8px">GOUD KOFFIE</h4>
                <small>JL. MT. Haryono No 8, Tulungagung</small> <br>
                <small>Laporan Penjualan Tanggal 02-05-2020</small>
                <hr style="border-color:#000">
            </div>
        </div>
        <!-- Transaksi Total -->
        <h5 style="margin-bottom: 15px">Total Transaksi</h5>
        <div class="row">
            <div class="col-md-12">
                <table class="table" style="width:100%">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Faktur</th>
                        <th>Kasir</th>
                        <th>Bayar</th>
                        <th>Kembali</th>
                        <th>Order Status</th>
                        <th>Diskon</th>
                        <th>Diskon Kode</th>
                        <th>Sub Total</th>
                        <th>Grand Total</th>
                        <th>Tanggal</th>
                    </tr>
                    @php
                    $sub_total = 0;
                    $total = 0;
                    @endphp
                    @foreach ($results as $key => $result)
                    <tr>
                        <th class="text-center">{{ $key+1 }}</th>
                        <td class="text-center">{{ $result->invoice }}</td>
                        <td class="text-center">{{ $result->user }}</td>
                        <td class="text-center">{{ number_format($result->cash, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($result->total_change, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $result->order_status == 'Grab' ? 'Grab' : 'Cafe' }}</td>
                        <td class="text-center">{{ $result->discount_value != NULL ? $result->discount_value . '%' : '-' }}</td>
                        <td class="text-center">{{ $result->discount_name != NULL ? $result->discount_name : '-' }}</td>
                        <td class="text-center">{{ number_format($result->sub_total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($result->total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $result->created_at->format('d-m-Y - H:i:s') }}</td>
                    </tr>
                    @php
                    $sub_total += $result->sub_total;
                    $total += $result->total;
                    @endphp
                    @endforeach
                    <tr class="text-center">
                        <th class="" colspan="10"><strong>Sub Total:</strong></th>
                        <th class=""><strong>{{ number_format($sub_total, 0, ',', '.') }}</strong></th>
                    </tr>
                    <tr class="text-center">
                        <th class="" colspan="10">
                            <strong>Total:</strong>
                        </th>
                        <th class="">
                            <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- End Transaksi Total -->
        <!-- Transaksi Cafe -->
        <h5 style="margin-bottom: 15px">Total Transaksi Offline</h5>
        <div class="row">
            <div class="col-md-12">
                <table class="table" style="width:100%">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Faktur</th>
                        <th>Kasir</th>
                        <th>Bayar</th>
                        <th>Kembali</th>
                        <th>Order Status</th>
                        <th>Diskon</th>
                        <th>Diskon Kode</th>
                        <th>Sub Total</th>
                        <th>Grand Total</th>
                        <th>Tanggal</th>
                    </tr>
                    @php
                    $sub_total = 0;
                    $total = 0;
                    @endphp
                    @foreach ($results->where('order_status', 'Cafe') as $key => $result)
                    <tr>
                        <th class="text-center">{{ $key+1 }}</th>
                        <td class="text-center">{{ $result->invoice }}</td>
                        <td class="text-center">{{ $result->user }}</td>
                        <td class="text-center">{{ number_format($result->cash, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($result->total_change, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $result->order_status == 'Grab' ? 'Grab' : 'Cafe' }}</td>
                        <td class="text-center">{{ $result->discount_value != NULL ? $result->discount_value . '%' : '-' }}</td>
                        <td class="text-center">{{ $result->discount_name != NULL ? $result->discount_name : '-' }}</td>
                        <td class="text-center">{{ number_format($result->sub_total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($result->total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $result->created_at->format('d-m-Y - H:i:s') }}</td>
                    </tr>
                    @php
                    $sub_total += $result->sub_total;
                    $total += $result->total;
                    @endphp
                    @endforeach
                    <tr class="text-center">
                        <th class="" colspan="10"><strong>Sub Total:</strong></th>
                        <th class=""><strong>{{ number_format($sub_total, 0, ',', '.') }}</strong></th>
                    </tr>
                    <tr class="text-center">
                        <th class="" colspan="10">
                            <strong>Total:</strong>
                        </th>
                        <th class="">
                            <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- End Transaksi Cafe -->
        <!-- Transaksi Grab -->
        <h5 style="margin-bottom: 15px">Total Transaksi Grab</h5>
        <div class="row">
            <div class="col-md-12">
                <table class="table" style="width:100%">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Faktur</th>
                        <th>Kasir</th>
                        <th>Bayar</th>
                        <th>Kembali</th>
                        <th>Order Status</th>
                        <th>Diskon</th>
                        <th>Diskon Kode</th>
                        <th>Tipe Pembayaran</th>
                        <th>Sub Total</th>
                        <th>Grand Total</th>
                        <th>Tanggal</th>
                    </tr>
                    @php
                    $sub_total = 0;
                    $total = 0;
                    $cash = 0;
                    $ovo = 0;
                    @endphp
                    @forelse ($results->where('order_status', 'Grab') as $key => $result)
                    <tr>
                        <th class="text-center">{{ $key+1 }}</th>
                        <td class="text-center">{{ $result->invoice }}</td>
                        <td class="text-center">{{ $result->user }}</td>
                        <td class="text-center">{{ number_format($result->cash, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($result->total_change, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $result->order_status == 'Grab' ? 'Grab' : 'Cafe' }}</td>
                        <td class="text-center">{{ $result->discount_value != NULL ? $result->discount_value . '%' : '-' }}</td>
                        <td class="text-center">{{ $result->discount_name != NULL ? $result->discount_name : '-' }}</td>
                        <td class="text-center">{{ $result->payment_type }}</td>
                        <td class="text-center">{{ number_format($result->sub_total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ number_format($result->total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $result->created_at->format('d-m-Y - H:i:s') }}</td>
                    </tr>
                    @php
                    $sub_total += $result->sub_total;
                    $total += $result->total;
                    $cash += $result->order_status == 'Grab' && $result->payment_type != 'ovo' ? $result->total : 0;
                    $ovo += $result->order_status == 'Grab' && $result->payment_type == 'ovo' ? $result->total : 0;
                    @endphp
                    @empty
                    <tr class="text-center">
                        <td colspan="12">Tidak ada transaksi Grab</td>
                    </tr>
                    @endforelse
                    <tr class="text-center">
                        <th class="" colspan="11"><strong>Total Pembayaran Cash:</strong></th>
                        <th class=""><strong>{{ number_format($cash, 0, ',', '.') }}</strong></th>
                    </tr>
                    <tr class="text-center">
                        <th class="" colspan="11"><strong>Total Pembayaran OVO:</strong></th>
                        <th class=""><strong>{{ number_format($ovo, 0, ',', '.') }}</strong></th>
                    </tr>
                    <tr class="text-center">
                        <th class="" colspan="11"><strong>Sub Total:</strong></th>
                        <th class=""><strong>{{ number_format($sub_total, 0, ',', '.') }}</strong></th>
                    </tr>
                    <tr class="text-center">
                        <th class="" colspan="11">
                            <strong>Total:</strong>
                        </th>
                        <th class="">
                            <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- End Transaksi Grab -->
    </div>
    <div class="page_break"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @foreach ($results as $key => $result)
                <div style="{{ $key != 0 ? 'margin-top:20px;' : '' }}"></div>
                <hr>
                <table class="table" style="width:100%; margin-bottom:5px; background-color: #e4e4e4">
                    <thead>
                        <tr>
                            <th>Faktur: {{ $result->invoice }}</th>
                            <th>Kasir: {{ $result->user }}</th>
                            <th>Bayar: {{ number_format($result->cash, 0, ',', '.') }}</th>
                            <th>Kembali: {{ number_format($result->total_change, 0, ',', '.') }}</th>
                            <th>Order Status: {{ $result->order_status == 'Grab' ? 'Grab' : 'Cafe' }}</th>
                            <th>Diskon: {{ $result->discount_value != NULL ? $result->discount_value . '%' : '-' }}</th>
                            <th>Diskon Kode: {{ $result->discount_name != NULL ? $result->discount_name : '-' }}</th>
                            <th>Sub Total: {{ number_format($result->sub_total, 0, ',', '.') }}</th>
                            <th>Total: {{ number_format($result->total, 0, ',', '.') }}</th>
                            <th>Tanggal: {{ $result->created_at->format('d-m-Y - H:i:s') }}</th>
                        </tr>
                    </thead>
                </table>
                <table class="table" style="width:100%">
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