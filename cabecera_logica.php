<?php
//Si existe sesión me traigo el carrito de BBDD
//si no existe sesión y existe cookie la cargo
//si no existe ninguna de las dos cosas creo la cookie vacia

// CARRITO si existe sesión
if (isset($_SESSION["usuario"])) { 
    $id_usuario = $_SESSION["usuario"]["id_usuario"];
    $carrito = $db->listaProductosCarrito($id_usuario);//recupero el carrito de un usuario 
}
else if (isset($_COOKIE["carrito"])) { //con json_decode decodifico el array login
    $carrito = json_decode($_COOKIE["carrito"], true); //si existe cargo la cookie
    if (!is_array($carrito)) {
        $carrito = [];
    }
} else {
    $carrito = []; //si no existe creo el array 
}

// Aqui es cuando pulso el botón de añadir al carrito
if (isset($_POST["productoAlCarrito"])) {

    $id_producto = $_POST["id_producto"];
    $cantidad = $_POST["cantidad"];

    if ($cantidad < 1) {
        $cantidad = 1;
    }

    if (isset($_SESSION["usuario"])) { // CARRITO si existe SESIÓN BBDD
        $id_usuario=$_SESSION["usuario"]["id_usuario"];//recojo unicamente el id del ususario
        $db->actualizarCarrito($id_usuario,$id_producto,$cantidad);// Actualizo el carrito
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
    $id_usuario=$_SESSION["usuario"]["id_usuario"];

    if(isset($_GET["borrarProducto"])){
        $id_producto=$_GET["borrarProducto"];
        $db->borrarProducto($id_usuario,$id_producto); 
    }
    else if(isset($_GET["aumentarCantidad"])&& isset($_GET["id_producto"])){
        $db->aumentarCantidad($id_usuario,$_GET["id_producto"],$_GET["aumentarCantidad"]); 
    }
    else if(isset($_GET["reducirCantidad"])&&isset($_GET["id_producto"])){
        $id_producto=$_GET["id_producto"];
        $cantidadActual=0;

        foreach ($carrito as $prod) {
            if ($prod["id_productos"] == $id_producto) {
                $cantidadActual = $prod["cantidad"];
            }
        }

        if ($cantidadActual > $_GET["reducirCantidad"]) {
            $db->reducirCantidad($id_usuario,$id_producto,$_GET["reducirCantidad"]); 
        }
    }
    $carrito = $db->listaProductosCarrito($id_usuario); // aqui recupero el carrito ya actualizado.

}else {  // BORRAR AUMENTAR O REDUCIR CANTIDAD CARRITO COOKIE

    if(isset($_GET["borrarProducto"])){
        unset($carrito[$_GET["borrarProducto"]]);
    }
    else if(isset($_GET["aumentarCantidad"])&& isset($_GET["id_producto"])){
        $id_producto=$_GET["id_producto"];
        $cantidad=$_GET["aumentarCantidad"];

        if (isset($carrito[$id_producto])) {
            $carrito[$id_producto] += $cantidad;
        }
    }
    else if(isset($_GET["reducirCantidad"])&&isset($_GET["id_producto"])){
        $id_producto=$_GET["id_producto"];
        $cantidad = $_GET["reducirCantidad"];

        if (isset($carrito[$id_producto]) && $carrito[$id_producto] > $cantidad) {
            $carrito[$id_producto] -= $cantidad; 
        }
    }
    setcookie("carrito", json_encode($carrito), time() + 3600 * 24 * 365 * 5); //le digo la cree o actualiza la cookie
}

$totalProductos=0;
if (isset($_SESSION["usuario"])) {
    foreach ($carrito as $prod) {
        $totalProductos+=$prod["cantidad"];
    }
} else {
    foreach ($carrito as $cantidad) {
        $totalProductos+=$cantidad;
    }
}

//FIN CARRITO

$categorias = $db->listarCategorias();

if (isset($_GET["cerrarSesion"])) {
    session_destroy();
    setcookie("carrito", "", time() - 3600);
    header("Location: login.php");
    exit();
}
?>
