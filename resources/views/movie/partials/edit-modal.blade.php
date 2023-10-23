{{-- createmodal --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100 text-center">Crear Película</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("peliculas.store") }}" method="POST" enctype="multipart/form-data" class="form-register">
                @include('movie.partials._form')
            </form>
        </div>
    </div>
</div>
{{-- end createmodal --}}