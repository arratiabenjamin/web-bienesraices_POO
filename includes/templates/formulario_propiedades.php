

<fieldset>
    <legend>Informacion General</legend>
    
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">
    
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>" min="100000">
    
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <label for="descripcion">Descripcion:</label>
    <textarea id="descripcion" name="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Informacion Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" value="<?php echo s($propiedad->habitaciones); ?>" min="1" max="9">

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="wc" placeholder="Ej: 3" value="<?php echo s($propiedad->wc); ?>" min="1" max="9">

    <label for="estacionamientos">Estacionamientos:</label>
    <input type="number" id="estacionamientos" name="estacionamientos" placeholder="Ej: 3" value="<?php echo s($propiedad->estacionamientos); ?>" min="1" max="9">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <select name="vendedorId">
        <option value="">-- Seleccione --</option>

    </select>
</fieldset>