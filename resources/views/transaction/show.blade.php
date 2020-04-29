<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>No Order</th>
            <th>Nama Kasir</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Kembalian</th>
        </tr>
    </thead>
    <tr>
        <td>{{ $model->id }}</td>
        <td>{{ $model->invoice }}</td>
        <td>{{ $model->user }}</td>
        <td>{{ number_format($model->total, 0, ',', '.') }}</td>
        <td>{{ number_format($model->cash, 0, ',', '.') }}</td>
        <td>{{ number_format($model->total_change, 0, ',', '.') }}</td>
    </tr>
</table>
<h6 class="text-primary font-weight-bold text-uppercase mt-4 mb-2">Detail Order</h6>
<table class="table text-center">
    <thead class="">
        <tr>
            <th>No</th>
            <th>Nama Item</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    @foreach ($model->orderDetail as $key => $item)
    <tr>
        <th>{{ $key+1 }}</th>
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->qty }}</td>
        <td>{{ number_format($item->price, 0, ',', '.') }}</td>
        <td>{{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</table>