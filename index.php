<?php
include_once("models.php");

$productos = $db->listarProductosMasVendidos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
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

    <!-- Section-->
    <section class="py-5">

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($productos as $producto) {
                ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product details-->
                            <a href="producto.php?id_producto=<?= $producto["id_productos"] ?>"><!--Tengo que pasarle la id del producto-->
                                <!-- Product image-->
                                <img class="card-img-top" src="<?= $producto["imagen"] ?>" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?= $producto["nombre"] ?></h5>
                                        <!-- Product price-->
                                        <?= $producto["precio"] ?>€
                                    </div>
                                </div>
                            </a>
                            <!-- Product actions  -->
                            
                            <form action="index.php" method="POST">
                                <input class="form-control text-center me-3" id="cantidad" name="cantidad" type="number" value="1" style="max-width: 4rem" />
                                <div class="d-flex">
                                    <input type="hidden" name="id_producto" value="<?= $producto["id_productos"] ?>" /><!--Creo un tipo hidden para pasarle el id del producto-->
                                    <!--Haciendo el ternario no necesito duplicar codigo y hacer un if preguntando por el stock y demas-->
                                    <button class="btn btn-outline-dark flex-shrink-0" name="productoAlCarrito" <?= $producto["stock"]==0 ? "disabled":"" ?>>
                                        <i class="bi-cart-fill me-1"></i>
                                        Añadir al Carrito 
                                    </button>
                                </div>
                            </form>
                        </div>
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
</body>

</html>