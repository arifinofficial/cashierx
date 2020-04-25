<form action="{{ $model->exists ? route('user.update', $model->id) : route('user.store') }}" method="POST">
    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" id="name" name="name" class="form-control" value="{{ $model->name }}" required placeholder="Masukkan nama..">
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="email" id="email" name="email" class="form-control" value="{{ $model->email }}" placeholder="Masukkan email.." required>
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select id="role" name="role" class="form-control" required>
                @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>