<form action="{{ $model->exists ? route('product.unit.update', $model->id) : route('product.unit.store') }}" method="POST">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nama Unit <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="name" name="name" class="form-control" value="{{ $model->name }}" required placeholder="Masukkan nama..">
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Kode <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="code" name="code" class="form-control" value="{{ $model->code }}" required placeholder="Masukkan code..">
        </div>
    </div>
</form>