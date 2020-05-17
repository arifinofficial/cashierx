@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <strong>{!! $message !!}</strong>
    </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" v-model="priceStatus" name="price_cafe" id="price_cafe"
                    value="price">
                <label class="form-check-label" for="inlineRadio1">Harga Cafe</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" v-model="priceStatus" name="price_grab" id="price_grab"
                    value="price_grab">
                <label class="form-check-label" for="inlineRadio1">Harga Grab</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <input type="text" name="search" id="" v-model="search" v-on:keyup="searching" class="form-control mb-4"
                placeholder="Cari menu...">
            <div class="wrapper-category">
                <ul>
                    @foreach ($categories as $key => $category)
                    <li>
                        <input type="radio" name="radio" value="{{ $category->id }}" {!! $key==0 ? 'ref="triggerCat"'
                            : '' !!} v-model="categoryProduct" id="category-{{ $category->id }}">
                        <label class="btn btn-info" for="category-{{ $category->id }}">{{ $category->name }}</label>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="row">
                <div v-for="(product, index) in products" class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header text-primary text-center font-weight-bold">
                            @{{ product.main_product.category.name }}</div>
                        <div class="card-body">
                            <img src="{{ asset('images/cashierx/300x300.png') }}" alt="" class="img-fluid">
                            <span class="d-block text-center mt-4 font-weight-bold">@{{ product.name }}
                                @{{ product.variant }}</span>
                            <span
                                class="d-block text-center mt-2 font-weight-bold">@{{ product.price | currency }}</span>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary w-100" v-on:click="modalShow(product.id)">Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-primary font-weight-bold">Order <h4 class="d-inline float-right"><span :class="priceStatus == 'price' ? 'badge badge-primary' : 'badge badge-success'">@{{ priceStatusFormat }}</span></h4></div>
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table">
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
                                        <button @click.prevent="removeCart(index)" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-bottom-detail">
                                    <td colspan="1" class="font-weight-bold">Total</td>
                                    <td colspan="3" class="text-right font-weight-bold" v-if="total === subTotal">@{{ total | currency }}</td>
                                    <td colspan="3" class="text-right font-weight-bold" v-else><small><del>@{{ subTotal | currency }}</del> (@{{ discount.discountValue }}%)</small> @{{ total | currency }}</td>
                                </tr>
                                <tr class="bg-bottom-detail">
                                    <td colspan="1" class="font-weight-bold">Tunai</td>
                                    <td colspan="3" class="text-right font-weight-bold">@{{ cash | currency }}</td>
                                </tr>
                                <tr class="bg-bottom-detail">
                                    <td colspan="1" class="font-weight-bold">Kembalian</td>
                                    <td colspan="3" class="text-right font-weight-bold">@{{ totalChange | currency }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="pb-0">
                                        <div class="form-row align-items-center">
                                            <div class="col">
                                                <input type="text" name="member" id="member" v-model="discount.discountName" class="form-control" placeholder="Kode Diskon">
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary" @click.prevent='addDiscount' :disabled="Object.keys(listCart).length == 0">Update Harga</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row align-items-center">
                                <input type="number" name="" id="cash" v-model="cash" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 mt-4" v-if="priceStatus == 'price_grab'">
                            <div class="form-check">
                                <input class="form-check-input" :disabled="Object.keys(listCart).length == 0" type="checkbox" v-model="paymentType" true-value="ovo" false-value="" id="ovopayment">
                                <label class="form-check-label" for="ovopayment">
                                    <small>Centang jika pembayaran menggunakan OVO/non tunai.</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <form action="{{ route('order.store') }}" method="POST" class="diable-multi-submit">
                                @csrf
                                <input type="hidden" name="price_status" v-model="priceStatus">
                                <input type="hidden" name="sub_total" v-model="subTotal">
                                <input type="hidden" name="total" v-model="total">
                                <input type="hidden" name="cash" v-model="cash">
                                <input type="hidden" name="total_change" v-model="totalChange">
                                <input type="hidden" name="discount_name" v-model="discount.discountName">
                                <input type="hidden" name="discount_value" v-model="discount.discountValue">
                                <input type="hidden" name="payment_type" v-model="paymentType">
                                <button type="submit" class="btn btn-info btn-lg w-100" id="submitOrder" :disabled="Object.keys(listCart).length == 0">
                                    Bayar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">@{{ product.name }} @{{ product.variant }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" @submit.prevent="addToCart" method="POST">
                <input type="hidden" name="product_id" id="product_id" v-model="cart.product_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Qty</label>
                        <input type="number" name="qty" id="qty" v-model="cart.qty" value="1" min="1"
                            class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" :disabled="submitCart">
                        <i class="fa fa-shopping-cart"></i> @{{ submitCart ? 'Loading...':'Order' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('top')
<style>
    .bg-bottom-detail {
        background-color: #656565;
        color: #fff;
    }

    .wrapper-category ul {
        overflow-x: scroll;
        width: 100%;
        white-space: nowrap;
        padding-left: 0;
    }

    .wrapper-category ul li {
        display: inline-block;
        list-style-type: none;
        position: relative;
    }

    .wrapper-category label {
        opacity: 0.8;
    }

    .wrapper-category input[type="radio"] {
        position: fixed;
        width: 0;
        opacity: 0;
    }

    .wrapper-category input[type="radio"]:checked+label {
        opacity: 1;
        border: 2px solid #238290;
    }
</style>
@endpush

@push('bottom')
<script src="{{ asset('js/accounting.min.js') }}"></script>
<script src="{{ asset('js/transaction.js') }}"></script>
<script>
    $('.diable-multi-submit').on('submit', function(){
            $('#submitOrder').attr('disabled', 'true');
        });
</script>
@endpush