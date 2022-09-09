<div class="modal modal_hidden" id="modal">

    <div class="modal_body" id="modal_body">
        <h1>Nueva Tarea</h1>
        <form id="modal_form">

            <div>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de la tarea" />
            </div>
            <div>
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción de la tarea"></textarea>
            </div>
            <div>
                <label for="entrega">Fecha de entrega</label>
                <input type="date" name="entrega" id="entrega" />
            </div>
            <div>
                <label for="prioridad">Prioridad</label>
                <select name="prioridad" id="prioridad">
                    <option value="" selected disabled>--Seleccione la Prioridad--</option>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            <input type="hidden" name="proyecto" id="proyecto" value="<?php echo $proyecto->id; ?>" />
            <input type="submit" value="Agregar Tarea" />
        </form>
        <div id="alerta_modal">
        </div>
    </div>
</div>