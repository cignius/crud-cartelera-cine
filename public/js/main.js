//Show modals
$('#createModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-footer .edit-movie-modal').addClass('d-none');
    modal.find('.details').html("");
    $("#duration").inputmask("9h 99m", {
        "placeholder": "0"
    });

});
$('#showModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-footer .edit-movie-modal').prop('disabled', false);
    modal.find('.details').html("");
    var button = $(event.relatedTarget);
    var url = button.data('url');

    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (data) {
        modal.find('form').attr('action', url);
        modal.find('.modal-title').text(data.title);
        modal.find('.modal-body #title').val(data.title).attr('disabled', true);
        modal.find('.modal-body #director').val(data.director).attr('disabled', true);
        modal.find('.modal-body #duration').val(data.duration).attr('disabled', true);
        modal.find('.modal-body #classification').val(data.classification).attr('disabled', true);
        modal.find('.modal-body #start_exhibition').val(data.start_exhibition.split(' ')[0]).attr('disabled', true);
        modal.find('.modal-body #finish_exhibition').val(data.finish_exhibition.split(' ')[0]).attr('disabled', true);
        modal.find('.modal-body #image').attr('disabled', true);
        modal.find('.modal-body #urlImage').attr('href', data.image).text('clic para ver imagen');
        modal.find('.modal-footer .edit-movie-modal').attr('data-id', data.id);
        modal.find('.modal-footer .create-movie').addClass('d-none');
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.status)
    });
});

$('#deleteModal').on('show.bs.modal',function (event) {
    var button = $(event.relatedTarget);
    console.log(button);
    var url = button.data('url');
    var id = button.data('id');
    var modal = $(this);
    modal.find('.modal-body .info').html('¿Desea eliminar el registro <strong>' + id +
        '</strong>?');
    modal.find('.form-delete').attr('action', url);
});

//Hide modal
$('#createModal, #showModal').on('hidden.bs.modal', function (e) {
    $('.form-register')[0].reset();
    window.location.reload();
});
$('#deleteModal').on('hidden.bs.modal', function (e) {
    var modal = $(this);
    modal.find('.modal-body .info').html("");
    modal.find('.form-delete').attr('action', "");
});
$(document).on('submit', '.form-register', function (e) {
    e.preventDefault();
    var $form = $(this);
    var action = $form.find('#put').val() ? 'update' : 'create';
    console.log(action);
    var formData = new FormData($(this)[0]);
    var modal = $(this).parents('.modal');
    var url = $form.attr('action');
    var errorsHtml = '';
    var successHtml = '';
    $form.find('.create-movie').prop('disabled', true);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $form.find('.create-movie').html(
                "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Enviando..."
            )

        }
    }).done(function (data) {
        if (data.type == "success") {
            if (data.action === 'update') {
                successHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                successHtml += data.message;
                successHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                $form.find('.details').html(successHtml);
                $form.find('.form-control').prop("disabled", true);
                $form.find('.create-movie').html("<i class='fa-solid fa-check'></i> Crear");
                $form.find('.create-movie').addClass('d-none');
                $form.find('.edit-movie-modal').prop('disabled', false);
                $form.find('#urlImage').attr('href', data.extra);
                $form.find('#image').val('');
                modal.find('.badge-title-modal').remove();
            } else {
                window.location.reload();
            }
        } else {
            errorsHtml =
                '<div class="invalid-feedback d-block normal-input"><ul class="px-3">';
            errorsHtml += '<li>' + data.message + '</li>';
            errorsHtml += '</ul></div>';
            $form.find('.details').html(errorsHtml);
            $form.find('.create-movie').prop('disabled', false);
            if (action === 'update') {
                $form.find('.modal-footer .create-movie').html('<i class="fa-solid fa-rotate"></i> Actualizar')
            } else {
                $form.find('.modal-footer .create-movie').html("<i class='fa-solid fa-check'></i> Crear")

            }
        }

    }).fail(function (jqXHR, textStatus, errorThrown) {
        var errors = jqXHR.responseJSON;
        errorsHtml =
                '<div class="invalid-feedback d-block normal-input"><ul class="px-3">';
        if (jqXHR.responseJSON) {
            
            if(!errors.type)
            {
                $.each(errors.errors, function (key, value) {
                    errorsHtml += '<li>' + value[0] +
                        '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></div>';
            }else{
                errorsHtml += errors.message;
                errorsHtml += '</div>';
            }
            

            

            $form.find('.details').html(
                errorsHtml); //appending to a <div id="form-errors"></div> inside form  
        } else {
            errorsHtml =
                '<div class="invalid-feedback d-block normal-input"><ul class="px-3"><li>Por el momento no podemos registrar la pelicula, intenta de nuevo más tarde</li></ul></div>';
            $form.find('.details').html(errorsHtml);
        }

        $form.find('.create-movie').prop('disabled', false);
        if (action === 'update') {
            $form.find('.modal-footer .create-movie').html('<i class="fa-solid fa-rotate"></i> Actualizar')
        } else {
            $form.find('.modal-footer .create-movie').html('<i class="fa-solid fa-check"></i> Crear')

        }
    });
});

//Action EDIT
$('.edit-movie-modal').on('click', function (event) {
    $(this).prop('disabled', true);
    var modal = $(this).parents('.modal');
    modal.find('form .form-control').prop("disabled", false);
    var title = modal.find('.modal-title').text();
    modal.find('.modal-title').html("<small class='badge bg-secondary badge-title-modal'>Editando</small> " + title);
    $('<input>').attr({
        type: 'hidden',
        name: '_method',
        value: 'PUT',
        id: 'put'
    }).appendTo(modal.find('form'));
    modal.find('.modal-footer .create-movie').html('<i class="fa-solid fa-rotate"></i> Actualizar')
    modal.find('.modal-footer .create-movie').removeClass('d-none');
    modal.find('.details').html("");
});