{{-- delete modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100 text-cente">Eliminar película</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" class="form-delete">
                @method('DELETE')
                @csrf
                <div class="modal-body text-center">
                    <div class="info"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal"><i
                            class="fa-solid fa-xmark"></i> Cancelar</button>


                    <button type="submit" class="btn btn-light-danger"><i class="fa-solid fa-ban"></i>
                        Eliminar</button>

                </div>
            </form>
        </div>
    </div>
</div>
{{-- end delete modal --}}