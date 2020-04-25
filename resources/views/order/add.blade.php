@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-primary">Menu</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="#" @submit.prevent="addToCart" method="POST">
                                <div class="form-group">
                                    <label for="">List Menu</label>
                                    <select name="product_id" id="product_id" class="form-control" required
                                    v-model="cart.product_id">
                                        <option value="">Pilih</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->is_active == 0 ? 'disabled="disabled"' : '' }}>{{ $product->name }} {{ $product->variant != null ? '- ' . $product->variant : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <input type="number" name="qty" id="qty"
                                    v-model="cart.qty" value="1" min="1" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm" :disabled="submitCart">
                                        <i class="fa fa-shopping-cart"></i> @{{ submitCart ? 'Loading...':'Ke Keranjang' }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-5">
                            <h4 class="text-center">Detail Menu</h4>
                            <div v-if="product.name">
                                <table class="table table-stripped">
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td>@{{ product.name }}</td>
                                    </tr>
                                    <tr v-if="product.variant != null">
                                        <th>Variant</th>
                                        <td>:</td>
                                        <td>@{{ product.variant }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>:</td>
                                        <td>@{{ product.price | currency }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <img :src="checkImg" 
                            class="img-fluid"
                            :alt="product.name">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-primary">Order</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in listCart">
                                    <td>@{{ row.name }} @{{ row.variant }}</td>
                                    <td>@{{ row.price | currency }}</td>
                                    <td>@{{ row.qty }}</td>
                                    <td>
                                        <button 
                                            @click.prevent="removeCart(index)"    
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="font-weight-bold">Total</td>
                                    <td colspan="3" class="text-right font-weight-bold">@{{ total | currency }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="font-weight-bold">Tunai</td>
                                    <td colspan="3" class="text-right font-weight-bold">@{{ cash | currency }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="font-weight-bold">Kembalian</td>
                                    <td colspan="3" class="text-right font-weight-bold">@{{ totalChange | currency }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <input type="number" name="" id="cash" v-model="cash" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="total" v-model="total">
                        <input type="hidden" name="cash" v-model="cash">
                        <input type="hidden" name="total_change" v-model="totalChange">
                        <button type="submit" class="btn btn-info btn-sm float-right">
                            Bayar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('bottom')
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/transaction.js') }}"></script>
@endpush
