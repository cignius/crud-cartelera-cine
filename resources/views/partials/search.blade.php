<div class="row justify-content-end">
    <div class="col-12 align-self-end">
        <form>
            <div class="input-group">
                <input type="email" class="form-control" required placeholder="usuario@email.com" name="search"
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-search" type="submit" id="button-addon2"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
