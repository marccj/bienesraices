<?php 
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';

    $db = connectDB();

    //Errores
    $errores = [];
    
    // Consultamos vendedores
    $query = "SELECT * FROM vendedor;";
    $result = mysqli_query($db, $query);

    // Inicializamos variables
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamientos = '';
    $vendedorId = '';

    // Ejecutar el codigo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamientos = mysqli_real_escape_string($db, $_POST['estacionamientos']);
        $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
        
        // Asignar files hacia una variable
        $imagen = $_FILES["imagen"];

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
    
        if(!$vendedorId) {
            $errores[] = "Debes seleccionar al menos un vendedor";
        }

        if(!$imagen['name'] || $imagen['error']) {
            $errores[] = "Debes añadir una imagen valida";
        }

        // Validar por tamaño
        $medida = 1000 * 2000;

        if($imagen['size'] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        if(empty($errores)){

            /** Subida de archivos */
            
            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            // Generar nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Subir imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            // Insertar en la bdd
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, vendedorId)
            VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamientos', '$vendedorId');";

            $result = mysqli_query($db, $query);
            
            if($result) {
                //Redir al usuario
                header("Location: /admin?resultado=1");
            }


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
        <form method="POST" action="/admin/propiedades/crear.php" class="formulario" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="titulo" placeholder="Titulo propiedad..." value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" placeholder="Precio propiedad..." value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
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
                    <?php while($row = mysqli_fetch_assoc($result)) : ?>
                        <option <?php echo $vendedorId === $row["id"] ? "selected" : ""?> value="<?php echo $row["id"] ?>"><?php echo $row['nombre'] . " " . $row['apellido'] ?></option>
                    <?php endwhile ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>
