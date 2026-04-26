<?php

include_once("models.php");
$id_producto = "";
$id_categoria = "";

if (isset($_GET["id_producto"])) {
    $id_producto = $_GET["id_producto"]; //recupero el id del producto seleccionado
}

//recojo el id de la categoria
if (isset($_GET["id_categoria"])) {
    
    $id_categoria = $_GET["id_categoria"];
}

$producto = $db->listarUnProducto($id_producto); //recupero el producto concreto
$productos = $db->listarProductosUnaCategoria($id_categoria);
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
    ?>
    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?= $producto["imagen"] ?>" alt="..." /></div>
                <div class="col-md-6">
                    <div class="small mb-1">ID:<?= $producto["id_productos"] ?> </div>
                    <h1 class="display-5 fw-bolder"><?= $producto["nombre"] ?></h1>
                    <div class="fs-5 mb-5">
                        <!--<span class="text-decoration-line-through">$45.00</span>-->
                        <span><?= $producto["precio"] ?>€</span>
                    </div>
                    <h4>Descripción:</h4>
                    <p class="lead"><?= $producto["descripcion"] ?></p>
                    <h4>Stock:</h4>

                    <p class="lead"><?= $producto["stock"] ?></p>
                   
                    <form action="producto.php?id_categoria=<?= $id_categoria ?>&id_producto=<?= $id_producto ?>" method="POST">
                        <input class="form-control text-center me-3" id="cantidad" name="cantidad" type="number" value="1" style="max-width: 4rem" />
                        <div class="d-flex">
                            <input type="hidden" name="id_producto" value="<?= $producto["id_productos"] ?>" /><!--Creo un tipo hidden para pasarle el id del producto-->
                            <!--Haciendo el ternario no necesito duplicar codigo y hacer un if preguntando por el stock y demas-->
                            <button class="btn btn-outline-dark flex-shrink-0" name="productoAlCarrito" <?= $producto["stock"]==0?"disabled":"" ?>>
                                <i class="bi-cart-fill me-1"></i>
                                Añadir al Carrito
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Related items section-->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Productos relacionados</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($productos as $producto) {
                ?>
                    <div class="col mb-5">
                        <a href="producto.php?id_producto=<?= $producto["id_productos"] ?>&id_categoria=<?= $id_categoria ?>"><!--Tengo que pasarle la id del producto-->
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="<?= $producto["imagen"] ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?= $producto["nombre"] ?></h5>
                                        <!-- Product price-->
                                        <?= $producto["precio"] ?>€
                                    </div>
                                </div>
                                <!-- Product actions-->
                                
                                <form action="producto.php?id_categoria=<?= $id_categoria ?>" method="POST">
                                    <input class="form-control text-center me-3" id="cantidad" name="cantidad" type="number" value="1" style="max-width: 4rem" />
                                    <div class="d-flex">
                                        <input type="hidden" name="id_producto" value="<?= $producto["id_productos"] ?>"  /><!--Creo un tipo hidden para pasarle el id del producto-->
                                        <button class="btn btn-outline-dark flex-shrink-0" name="productoAlCarrito" <?= $producto["stock"]==0?"disabled":"" ?>>
                                            <i class="bi-cart-fill me-1"></i>
                                            Añadir al Carrito
                                        </button>
                                    </div>
                                </form>
                                
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </section>
    <?php
    require_once("pie.php");
    ?>