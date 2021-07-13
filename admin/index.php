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

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
            $result = mysqli_query($db, $query);

            unlink('../imagenes/' . mysqli_fetch_assoc($result)['imagen']);

            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $result = mysqli_query($db, $query);

            if($result) {
                header("Location: /admin?resultado=3");
            }
        }

    }

    // Incluye un template
    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="alerta exito">La propiedad fue creada correctamente</p> 
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">La propiedad fue actualizada correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">La propiedad fue eliminada correctamente</p>  
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
                        <a class="boton-amarillo-block" href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad["id"]?>">Acutalizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar" />
                        </form>
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
