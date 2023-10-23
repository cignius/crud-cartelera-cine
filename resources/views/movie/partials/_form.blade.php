@csrf
<div class="modal-body">
    <div class="mb-3">
        <label for="title" class="form-label">*Titulo:</label>
        <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="255" required />
    </div>
    <div class="mb-3">
        <label for="director" class="form-label">*Director:</label>
        <input type="text" class="form-control" id="director" name="director" minlength="2" maxlength="255"
            required />
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="duration" class="form-label">*Duration</label>
                <input type="text" class="form-control" id="duration" name="duration" maxlength="10" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="classification" class="form-label">*Clasificación:</label>
                <select class="form-select form-control" name="classification" id="classification" required>
                    <option hidden disabled>Elegir...</option>
                    <option value="aa">AA</option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="b15">B15</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="start_exhibition" class="form-label">*Inicio exhibición</label>
                <input id="start_exhibition" name="start_exhibition" class="form-control" type="date" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="finish_exhibition" class="form-label">*Fin exhibición</label>
                <input id="finish_exhibition" name="finish_exhibition" class="form-control" type="date" required />
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">*Imagen <small>(Medida minima w=1024 h=720 10MB)</small>: <a id="urlImage" target="_blank"></a> </label>
        <input class="form-control" type="file" id="image" name="image"
            accept="image/png, image/gif, image/jpeg, image/jpg">
    </div>

    <div class="details"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancelar</button>

    <button type="button" class="btn btn-light-primary edit-movie-modal" data-id=""><i class="fa-regular fa-pen-to-square"></i>
        Editar</button>
    <button type="submit" class="btn btn-light-success create-movie"><i class="fa-solid fa-check"></i>
        Crear</button>

</div>
