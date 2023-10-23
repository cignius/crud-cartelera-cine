$('#createModal').on('show.bs.modal', function(event) {
    var modal = $(this);
    $("#duration").inputmask("9h 99m", {
        "placeholder": "0"
    });
    modal.find('.modal-footer .delete-movie').addClass('d-none');
});
$('#showModal').on('show.bs.modal', function(event) {
    var modal = $(this);
    var button = $(event.relatedTarget);
    var url = button.data('url');
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        
    }).done(function(data) {
        console.log(data);
        modal.find('.modal-title').text('Información de: ' + data.title);
        modal.find('.modal-body #title').val(data.title).attr('disabled', true);
        modal.find('.modal-body #director').val(data.director).attr('disabled', true);
        modal.find('.modal-body #duration').val(data.duration).attr('disabled', true);
        modal.find('.modal-body #classification').val(data.classification).attr('disabled', true);
        modal.find('.modal-body #start_exhibition').val(data.start_exhibition.split(' ')[0]).attr('disabled', true);
        modal.find('.modal-body #finish_exhibition').val(data.finish_exhibition.split(' ')[0]).attr('disabled', true);
        modal.find('.modal-body #image').attr('disabled', true);
        modal.find('.modal-body #urlImage').attr('href', data.image).text('Clic para ver imagen');
        modal.find('.modal-footer .edit-movie-modal').attr('data-id', data.id);
        modal.find('.modal-footer .create-movie').addClass('d-none');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.status)
    });
});
$('#createModal, #showModal').on('hidden.bs.modal', function(e) {
    $('.form-register')[0].reset();
})
$('.form-register').on('submit', function(e) {
    e.preventDefault();
    var $form = $(this);
    var formData = new FormData($(this)[0]);
    var url = $form.attr('action');
    var errorsHtml = '';
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
        beforeSend: function() {
            $form.find('.create-movie').html(
                "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Enviando..."
            )

        }
    }).done(function(data) {
        if (data.type == "success") {
            window.location.reload();
        } else {
            errorsHtml =
                '<div class="invalid-feedback d-block normal-input"><ul class="px-3">';
            errorsHtml += '<li>' + data.message + '</li>';
            errorsHtml += '</ul></div>';
            $form.find('.errors').html(errorsHtml);

            $form.find('.create-movie').prop('disabled', false);
            $form.find('.create-movie').html("<i class='fa-solid fa-check'></i> Crear")
        }

        // 

    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.status)
        if (jqXHR.responseJSON) {
            var errors = jqXHR.responseJSON;
            errorsHtml =
                '<div class="invalid-feedback d-block normal-input"><ul class="px-3">';

            $.each(errors.errors, function(key, value) {
                errorsHtml += '<li>' + value[0] +
                    '</li>'; //showing only the first error.
            });
            errorsHtml += '</ul></div>';

            $form.find('.errors').html(
                errorsHtml); //appending to a <div id="form-errors"></div> inside form  
        } else {
            errorsHtml =
                '<div class="invalid-feedback d-block normal-input"><ul class="px-3"><li>Por el momento no podemos registrar la pelicula, intenta de nuevo más tarde</li></ul></div>';
            $form.find('.errors').html(errorsHtml);
        }

        $form.find('.create-movie').prop('disabled', false);
        $form.find('.create-movie').html("<i class='fa-solid fa-check'></i> Crear")
    });
});

//Action EDIT

$('.edit-movie-modal').on('click', function(event){
    
});