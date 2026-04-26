<?php
//Si existe sesión me traigo el carrito de BBDD
//si no existe sesión y existe cookie la cargo
//si no existe ninguna de las dos cosas creo la cookie vacia

// CARRITO  si existe sesión
if (isset($_SESSION["usuario"])) { 
    $id_usuario = $_SESSION["usuario"]["id_usuario"];
    
    $carrito = $db->listaProductosCarrito($id_usuario);//recupero el carrito de un usuario 
    //SI QUIERO SACAR EL TOTAL DE PRODUCTOS, TENDRIA QUE HACERLO ASI.
    $totalProductos=0;
    foreach ($carrito as $prod) {
    $totalProductos+=$prod["cantidad"];

    }
    print_r($totalProductos);
    
}
else if (isset($_COOKIE["carrito"])) { //con json_decode decodifico el array login
    $carrito = json_decode($_COOKIE["carrito"], true); //si existe cargo la cookie

} else {
    $carrito = []; //si no existe creo el array 

}

// Aqui es cuando pulso el botón de añadir al carrito
if (isset($_POST["productoAlCarrito"])) {

    $id_producto = $_POST["id_producto"];
    $cantidad = $_POST["cantidad"];

    if (isset($_SESSION["usuario"])) { // CARRITO  si existe SESIÓN BBDD
        $id_usuario=$_SESSION["usuario"]["id_usuario"];//recojo unicamente el id del ususario
        
        $db->actualizarCarrito($id_usuario,$id_producto,$cantidad);// Actualizo el carrito, como no devuelve nada la funcion no lo guardo en vaiable
        $carrito = $db->listaProductosCarrito($id_usuario); // aqui recupero el carrito ya actualizado.
        
    } 
    else {  // CARRITO COOKIE - si no existe sesión
        if (isset($carrito[$id_producto])) {
            $carrito[$id_producto] += $cantidad; //Si ya existe el producto le sumo

        } else {
            $carrito[$id_producto] = $cantidad; // Si no existe el producto lo creo

        }
        setcookie("carrito", json_encode($carrito), time() + 3600 * 24 * 365 * 5); //le digo la cree o actualiza la cookie
    }
}

//BORRAR AUMENTAR O REDUCIR CANTIDAD CARRITO BBDD
    if(isset($_SESSION["usuario"])){
        if(isset($_GET["borrarProducto"])){
            $id_producto=$_GET["borrarProducto"];
            $db->borrarProducto($id_producto);	
        }
        else if(isset($_GET["aumentarCantidad"])&& isset($_GET["id_producto"])){
            $db->aumentarCantidad($_GET["id_producto"],$_GET["aumentarCantidad"]);	
        }
        else if(isset($_GET["reducirCantidad"])&&isset($_GET["id_producto"])){
            $db->reducirCantidad($_GET["id_producto"],$_GET["reducirCantidad"]);	
        }
        $carrito = $db->listaProductosCarrito($id_usuario); // aqui recupero el carrito ya actualizado.

    
    }else {  // BORRAR AUMENTAR O REDUCIR CANTIDAD CARRITO COOKIE
    
        if(isset($_GET["borrarProducto"])){
            unset($carrito[$_GET["borrarProducto"]]);
        }
        else if(isset($_GET["aumentarCantidad"])&& isset($_GET["id_producto"])){
            $id_producto=$_GET["id_producto"];
            $cantidad=$_GET["aumentarCantidad"];
            $carrito[$id_producto] += $cantidad;
            print_r($carrito);
        }
        else if(isset($_GET["reducirCantidad"])&&isset($_GET["id_producto"])){
            $id_producto=$_GET["id_producto"];
            $cantidad = $_GET["reducirCantidad"];
            $carrito[$id_producto] -= $cantidad;	
            if($carrito[$id_producto]<=0){
                unset($carrito[$id_producto]);
            }
        }
        setcookie("carrito", json_encode($carrito), time() + 3600 * 24 * 365 * 5); //le digo la cree o actualiza la cookie
    }


//FIN CARRITO


$categorias = $db->listarCategorias();
if (isset($_GET["cerrarSesion"])) {
    session_destroy();
    header("Location: login.php");
}
?>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">
            <h1>VicioCleta</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        foreach ($categorias as $categoria) {
                        ?>
                            <li><a class="dropdown-item" href="productosCategoria.php?id_categoria=<?= $categoria["id_categorias"] ?>"><?= $categoria["nombre"] ?></a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">

                <?php
                if (isset($_SESSION["usuario"])) {
                    $usuarioNombre = $_SESSION["usuario"]["nombre"];

                ?>
                    <span style="margin-right:10px">Hola <?= $usuarioNombre ?></span>
                    <a class="btn btn-outline-dark" href="login.php?cerrarSesion=1" style="margin-right:10px">Cerrar Sesión</a>


                <?php
                } else {
                ?>
                    <a class="btn btn-outline-dark" style="margin-right:10px" href="registro.php">Registro</a>
                    <a class="btn btn-outline-dark" style="margin-right:10px" href="login.php">login</a>

                <?php
                
                }

                ?>
                <a class="btn btn-outline-danger" href="carrito.php" style="margin-right:10px">Carrito
                    <i class="bi-cart-fill me-1"></i>
                    <span class="badge bg-danger text-white ms-1 rounded-pill"><?= count($carrito) ?></span>
                </a>
            </form>
        </div>
    </div>
</nav>
<!-- Header-->
<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <img src="./imagenes/bici.png" alt="" width="230" height="130">
            <p class="lead fw-normal text-white-100 mb-0">VicioCleta</p>
        </div>
    </div>
</header>