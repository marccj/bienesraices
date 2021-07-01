<?php 
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';

    $db = connectDB();

    //Errores
    $errores = [];
    
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamientos = '';
    $vendedorId = '';

    // Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamientos = $_POST['estacionamientos'];
        $vendedorId = $_POST['vendedor'];

        // Validación del formulario
        if(!$titulo) {
            $errores[] = "Debes añadir un titulo";
        }

        if(!$precio) {
            $errores[] = "Debes añadir un precio";
        }

        if(strlen($descripcion) < 50) {
            $errores[] = "Debes añadir una descripción obligatoriamente y que tenga más de 50 caracteres";
        }

        if(!$habitaciones) {
            $errores[] = "Debes añadir una o más habitaciones";
        }

        if(!$wc) {
            $errores[] = "Debes añadir uno o mas wc's";
        }

        if(!$estacionamientos) {
            $errores[] = "Debes añadir uno o mas estacionamientos";
        }
    
        if(!$vendedorId || $vendedorId === '') {
            $errores[] = "Debes seleccionar al menos un vendedor";
        }

        if(empty($errores)){
            // Insertar en la bdd
            $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedorId)
            VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamientos', '$vendedorId')";

            $result = mysqli_query($db, $query);
        }



        
    }

    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error):  ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
        <?php endforeach ?>
        <form method="POST" action="/admin/propiedades/crear.php" class="formulario">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="titulo" placeholder="Titulo propiedad..." value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" placeholder="Precio propiedad..." value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion">
                    <?php echo $descripcion; ?> 
                </textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">WC</label>
                <input type="number" name="wc" id="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamientos">Estacionamientos</label>
                <input type="estacionamientos" name="estacionamientos" id="estacionamientos" placeholder="Ej: 1" min="1" max="9" value="<?php echo $estacionamientos; ?>">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor" id="vendedor">
                    <option value="">-- Seleccione --</option>
                    <option value="1">Juan</option>
                    <option value="2">Karen</option>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>
