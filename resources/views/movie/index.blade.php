@extends('master', ['section' => 'index'])
@section('content')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-light-primary" href="#" role="button" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Nuevo registro
            </a>
        </div>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Titulo</th>
                    <th scope="col" class="text-center">Estatus</th>
                    <th scope="col" class="text-center">Inicio exhibición</th>
                    <th scope="col" class="text-center">Fin exhibición</th>
                    <th scope="col" class="text-center">Fecha registro</th>
                    <th scope="col" class="text-center"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($movies as $movie)
                    <tr>
                        <td class="text-center">{{ $movie->title }}</td>
                        <td class="text-center">{{ $movie->status }}</td>
                        <td class="text-center">{{ $movie->start_exhibition }}</td>
                        <td class="text-center">{{ $movie->finish_exhibition }}</td>
                        <td class="text-center">{{ $movie->created_at }}</td>


                        <td class="text-center">

                            <div class="dropdown">
                                <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item d-flex align-items-center gap-3" href="#"
                                            data-bs-toggle="modal" data-bs-target="#infoModal" data-id="{{ $movie->id }}"
                                            data-ticket="{{ $movie->ticket }}"
                                            data-participant="{{ $movie->participant_id }}"
                                            data-token="{{ $movie->token }}"><i class="fa-solid fa-check"></i>
                                            Validar</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-3" href="#"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="{{ $movie->id }}"><i class="fa-solid fa-ban"></i>
                                            Rechazar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $movies->appends([
                'search' => request('search'),
            ])->links() }}
    </div>
    @include('movie.partials.create-modal')
    <script>
        window.onload = function() {

            $('#createModal').on('show.bs.modal', function(event) {
                var modal = $(this);
                $("#duration").inputmask("9h 99m", {
                    "placeholder": "0"
                });
                modal.find('.modal-footer .delete-movie').addClass('d-none');
            });
            $('#createModal').on('hidden.bs.modal', function(e) {
                $('.form-register')[0].reset();
            })
            $('.form-register').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var formData = new FormData($(this)[0]);
                var url = $form.attr('action');
                var errorsHtml = '';
                $form.find('.register').prop('disabled', true);
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
                        $form.find('.register').html(
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

                        $form.find('.register').prop('disabled', false);
                        $form.find('.register').html("<i class='fa-solid fa-check'></i> Crear")
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

                    $form.find('.register').prop('disabled', false);
                    $form.find('.register').html("<i class='fa-solid fa-check'></i> Crear")
                });
            });
        };
    </script>
@endsection
