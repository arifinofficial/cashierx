<form action="{{ $model->exists ? route('product.category.update', $model->id) : route('product.category.store') }}" method="POST">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nama Kategori <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="name" name="name" class="form-control" value="{{ $model->name }}" required placeholder="Masukkan nama..">
        </div>
    </div>
    {{-- <div class="form-group row">
        <label for="picture" class="col-sm-3 col-form-label">Gambar</label>
        <div class="col-sm-9">
            <input type="file" id="picture" name="picture" class="form-control-file" value="{{ $model->picture }}">
        </div>
    </div> --}}
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Deskripsi</label>
        <div class="col-sm-9">
            <textarea id="description" name="description" class="form-control" rows="5" placeholder="Deskripsi..">{{ $model->description }}</textarea>
        </div>
    </div>
</form>