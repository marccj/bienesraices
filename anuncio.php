<?php
    require 'includes/funciones.php';
    require 'includes/config/database.php';

    if(isset($_GET["id"]) && !empty($_GET["id"])) {
        $propiedadId = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    } else {
        header('Location: /');
    }

    $db = connectDB();

    $query = "SELECT * FROM propiedades WHERE id = ${propiedadId}";
    $result = mysqli_query($db, $query);

    if(!$result->num_rows) {
        header('Location: /');
    }

    $propiedad = mysqli_fetch_assoc($result);

    incluirTemplate("header");
?>
    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad["titulo"]?></h1>

        <img loading="lazy" src="/imagenes/<?php echo $propiedad["imagen"]?>" alt="imagen de la propiedad">

        <div class="resumen-propiedad">
            <p class="precio"><?php echo $propiedad["precio"]?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad["wc"]?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad["estacionamiento"]?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad["habitaciones"]?></p>
                </li>
            </ul>

            <p>
                <?php echo $propiedad["descripcion"]?>
            </p>
        </div>
    </main>

<?php 
    incluirTemplate("footer");
?>