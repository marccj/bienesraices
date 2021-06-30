<?php 
    require '../../includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <form action="" class="formulario">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="titulo" placeholder="Titulo propiedad...">

                
                <label for="imagen">Precio</label>
                <input type="number" name="precio" id="precio" placeholder="Precio propiedad...">

                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion"></textarea>
            </fieldset>
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>
