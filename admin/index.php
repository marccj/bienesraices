<?php 

    // Consultar DB
    require('../includes/config/database.php');
    $db = connectDB();

    // Escribir query
    $query = "SELECT * FROM propiedades;";

    // Consultar la BD
    $result = mysqli_query($db, $query);

    // Muestra mensaje condicional
    $resultado =  $_GET['resultado'] ?? null;

    // Incluye un template
    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="alerta exito">La propiedad fue creada correctamente</p> 
        <?php endif; ?>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while($propiedad = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $propiedad['id']?></td>
                    <td><?php echo $propiedad['titulo']?></td>
                    <td><img src="/imagenes/<?php echo $propiedad['imagen']?>" alt="Imagen propiedad" class="imagen-tabla"></td>
                    <td><?php echo $propiedad['precio']?> €</td>
                    <td>
                        <a class="boton-amarillo-block" href="">Acutalizar</a>
                        <a class="boton-rojo-block" href="">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile ?>
            </tbody>
        </table>
    </main>

<?php
    //Cerrar conexion
    mysqli_close($db);

    incluirTemplate('footer');
?>
