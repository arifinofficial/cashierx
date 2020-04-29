{{-- <form action="{{ $delete_url }}" method="POST">
    @csrf
    @method('DELETE') --}}
    <a href="{{ $show_url }}" class="btn btn-sm btn-outline-info action-show" data-toggle="tooltip" data-placement="bottom" title="View data {{ $model->name }}">
        <span class="btn-label btn-label-right"><i class="fas fa-eye"></i></span>
    </a>
    &nbsp; &nbsp;
    @if ($edit_url !== '#')
    <a href="{{ $edit_url }}" class="btn btn-sm btn-outline-warning modal-show edit" data-toggle="tooltip" data-placement="bottom" title="Ubah data {{ $model->name }}">
        <span class="btn-label btn-label-right"><i class="fas fa-pen"></i></span>
    </a>
    &nbsp; &nbsp;
    @endif
    <a href="{{ $delete_url }}" class="btn btn-sm btn-outline-danger action-delete" data-toggle="tooltip" data-name="{{ $model->name }}" data-placement="bottom" title="Hapus data {{ $model->name }}">
        <span class="btn-label btn-label-right"><i class="fas fa-trash"></i></span>
    </a>
{{-- </form> --}}