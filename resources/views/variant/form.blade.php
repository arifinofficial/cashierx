<form action="{{ $model->exists ? route('product.variant.update', $model->id) : route('product.variant.store') }}" method="POST">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nama Variant <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="name" name="name" class="form-control" value="{{ $model->name }}" required placeholder="Masukkan nama..">
        </div>
    </div>
</form>