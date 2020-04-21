@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (core()->isVariant())
                @include('product.type.product_variant')
            @else
                @include('product.type.product_single')
            @endif
        </div>
    </div>
</div>
@endsection

@if (core()->isVariant())
@push('bottom')
<script>
var units = JSON.parse('{!! $units !!}');

$('.add-list').click(function(e){
    e.preventDefault();

    var buttonIndex = $(this).attr('data-index');
    var wrapper = $('.item-wrapper[item-wrapper='+buttonIndex+']');
    var count = parseInt($(wrapper).find('span').last().attr('class')) + 1;
    
    var html = `
    <span class="`+count+`"></span>
    <div class="col-md-7 pt-3">
        <label for="">Item</label>
        <input type="text" name="products[`+buttonIndex+`][items][`+count+`][name]" id="item" class="form-control" required>
    </div>
    <div class="col-md-2 pt-3">
        <label for="">Recipe</label>
        <input type="number" name="products[`+buttonIndex+`][items][`+count+`][recipe]" id="recipe" class="form-control" required>
    </div>
    <div class="col-md-2 pt-3">
        <label for="">Unit</label>
        <select name="products[`+buttonIndex+`][items][`+count+`][unit]" id="unit_id" class="form-control unit count-`+count+`">
        </select>
    </div>
    <div class="col-md-1 pt-3 d-flex align-items-end">
        <button class="btn btn-danger w-100"><i class="fa fa-trash"></i></button>
    </div>
    ` 
    console.log(count);
    
    $(wrapper).append(html);

    $.each(units, function(i, item){
        var option = new Option(item, i);
        $(option).html(item);
        $(".item-wrapper[item-wrapper="+buttonIndex+"] .unit.count-"+count+"").append(option);
    });
});
</script>
@endpush
@else
@push('bottom')
<script>
var count = 1;
var units = JSON.parse('{!! $units !!}');

$('#add-list').click(function(e){
    e.preventDefault();

    var wrapper = $('#item-wrapper');
    var html = `
    <div class="col-md-7 pt-3">
        <label for="">Item</label>
        <input type="text" name="items[`+count+`][name]" id="item" class="form-control" required>
    </div>
    <div class="col-md-2 pt-3">
        <label for="">Recipe</label>
        <input type="number" name="items[`+count+`][recipe]" id="recipe" class="form-control" required>
    </div>
    <div class="col-md-2 pt-3">
        <label for="">Unit</label>
        <select name="items[`+count+`][unit]" id="unit_id" class="form-control unit count-`+count+`">
        </select>
    </div>
    <div class="col-md-1 pt-3 d-flex align-items-end">
        <button class="btn btn-danger w-100"><i class="fa fa-trash"></i></button>
    </div>
    `
    $(wrapper).append(html);

    $.each(units, function(i, item){
        var option = new Option(item, i);
        $(option).html(item);
        $(".unit.count-"+count+"").append(option);
    });

    count++;
});
</script>
@endpush
@endif