// Modal Show
$('body').on('click', '.modal-show', function(event){

    event.preventDefault();

    var me      = $(this),
        url     = me.attr('href'),
        title   = me.attr('title');

    $('#modal-title').text(title);
    $('#btn-submit').text(me.hasClass('edit') ? 'Ubah' : 'Tambah');
    $('#btn-submit').show();

    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response){
            $('#modal-body').html(response);
        }
    });

    $('#modalForm').modal('show');

});

// Ajax Post Data
$('#btn-submit').click(function (event){

    event.preventDefault();

    var form    = $('#modal-body form'),
        url     = form.attr('action'),
        method  = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';

    form.find('.invalid-feedback').remove();
    form.find('.form-control').removeClass('is-invalid');
    
    $.ajax({
        url: url,
        method: method,
        data: form.serialize(),
        success: function(response){    
            form.trigger('reset');
            $('#modalForm').modal('hide');

            if ($('#dataTable').length !== 0) {
                $('#dataTable').DataTable().ajax.reload();
            }

            swal({
                title: 'Sukses!',
                text: 'Data berhasil disimpan.',
                icon: 'success',
                timer: 3000
            });
        },
        error: function(xhr){
            var res = xhr.responseJSON;

            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function(key, value){
                    $('#'+key)
                    .closest('.form-control')
                    .addClass('is-invalid')
                    .after('<span class="invalid-feedback">'+value+'</span>')
                })
            }
        }
    })

});

// Modal Show for Action View
$('body').on('click', '.action-show', function(event){

    event.preventDefault();

    var me      = $(this),
        url     = me.attr('href'),
        title   = me.attr('title');

        console.log(url);
        
    
    $('#modal-title').text(title);
    $('#btn-submit').hide();

    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response){
            $('#modal-body').html(response); 
        }
    });

    $('#modalForm').modal('show');

});

// Ajax Delete
$('body').on('click', '.action-delete', function(event){
    
    event.preventDefault();

    var me          = $(this),
        name        = me.attr('data-name'),
        url         = me.attr('href'),
        csrf_token  = $('meta[name="csrf-token"]').attr('content');

    swal({
        text: 'Apakah anda yakin menghapus data ' + name + '?', 
        buttons: {
            cancel: true,
            confirm: true,
        }
    }).then((result) => {
        if (result) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    '_method': 'DELETE',
                    '_token': csrf_token,
                },
                success: function(response){
                    console.log(response);
                    
                    if ($('#dataTable').length !== 0) {
                        $('#dataTable').DataTable().ajax.reload();
                    }

                    swal({
                        title: 'Sukses!',
                        text: 'Data berhasil dihapus.',
                        icon: 'success',
                        timer: 3000
                    });
                },
                error: function(xhr){
                    swal({
                        title: 'Error!',
                        text: 'Data gagal dihapus.',
                        icon: 'error',
                        timer: 3000
                    });
                }
            });
        }
    });

});