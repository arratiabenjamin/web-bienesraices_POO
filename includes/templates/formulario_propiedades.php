

<fieldset>
    <legend>Informacion General</legend>
    
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">
    
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>" min="100000">
    
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

    <?php if($propiedad->imagen) { ?>
        <h3 style="text-align: left;">Imagen Usada Anteriormente</h3>
        <img src="/imagenes/<?php echo $propiedad->imagen; ?> " class="imagen-small">
    <?php } ?>

    <label for="descripcion">Descripcion:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Informacion Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" value="<?php echo s($propiedad->habitaciones); ?>" min="1" max="9">

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" value="<?php echo s($propiedad->wc); ?>" min="1" max="9">

    <label for="estacionamientos">Estacionamientos:</label>
    <input type="number" id="estacionamientos" name="propiedad[estacionamientos]" placeholder="Ej: 3" value="<?php echo s($propiedad->estacionamientos); ?>" min="1" max="9">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorId]" id="vendedor">
        <option value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : '' ?> value="<?php echo s($vendedor->id); ?>"><?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
        <?php  } ?>

    </select>
</fieldset>