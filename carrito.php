<?php

include_once("models.php");
require_once("cabecera_logica.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Item - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php
    
   
    require_once("cabecera.php");
    //imprimo el carrito
    
    ?>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1>Carrito</h1>

                <?php
                //carrito COOKIE
                $total=0;
                if(!isset($_SESSION["usuario"])){ 
                    foreach ($carrito as $id_prod => $cantidad) {

                        $productoCarrito = $db->listarUnProducto($id_prod);
                    ?>
                        <p>Nombre: <?= $productoCarrito["nombre"]." - " ?> Cantidad: <?= $cantidad." - " ?> Precio: <?= $productoCarrito["precio"] ?>€ 
                        <a class="btn btn-outline-light" style="margin-right:10px" href="carrito.php?aumentarCantidad=1&id_producto=<?= $id_prod?>">+ </a>
                        <?php if ($cantidad > 1) { ?>
                            <a class="btn btn-outline-light" style="margin-right:10px" href="carrito.php?reducirCantidad=1&id_producto=<?= $id_prod ?>">- </a>
                        <?php } else { ?>
                            <button class="btn btn-outline-secondary" style="margin-right:10px" disabled>- </button>
                        <?php } ?>
                        <a class="btn btn-outline-danger" style="margin-right:10px" href="carrito.php?borrarProducto=<?= $id_prod ?>">Eliminar <i class="bi bi-trash"></i></a></p>
                        
                        <?php
                        $total+=($cantidad*$productoCarrito["precio"]);

                    }
                    ?>
                    <p>Total Compra: <?= $total ?>€</p>
                    <?php
                }   //carrito SESIÓN Y BBDD
                else{
                    foreach ($carrito as $prod) {
                        ?>
                        <p>Nombre: <?= $prod["nombre"]." - " ?> Precio: <?= $prod["precio"] ?>€ Cantidad: <?= $prod["cantidad"]." " ?>
                        
                        <a class="btn btn-outline-light" style="margin-right:10px" href="carrito.php?aumentarCantidad=1&id_producto=<?= $prod["id_productos"] ?>">+ </a>
                        <?php if ($prod["cantidad"] > 1) { ?>
                            <a class="btn btn-outline-light" style="margin-right:10px" href="carrito.php?reducirCantidad=1&id_producto=<?= $prod["id_productos"] ?>">- </a>
                        <?php } else { ?>
                            <button class="btn btn-outline-secondary" style="margin-right:10px" disabled>- </button>
                        <?php } ?>
                        <a class="btn btn-outline-danger" style="margin-right:10px" href="carrito.php?borrarProducto=<?= $prod["id_productos"] ?>">Eliminar <i class="bi bi-trash"></i></a></p>
                        <?php
                        $total+=($prod["cantidad"]*$prod["precio"]);
                        
                    }
                    ?>
                    <p>Total Compra: <?= $total ?>€</p>
                <?php
                }
                ?>
            </div>
        </div>
    </header>
    <?php

    include_once("pie.php");
    ?>
