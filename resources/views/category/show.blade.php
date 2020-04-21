<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>Nama Category</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>{{ $model->id }}</td>
        <td>{{ $model->name }}</td>
        <td>{{ $model->description }}</td>
    </tr>
</table>