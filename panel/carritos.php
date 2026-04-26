<?php
include_once("../models.php");
require_once("menu.php");

// CARRITO  si existe sesión

$total = 0;



//Borrar CARRITO COMPLETO, la recogo por POST
if (isset($_POST["borrarCarrito"])) {
  $id_carrito=$_POST["id_carrito"];

  $db->borrarCarrito($id_carrito);
}
$carritos = $db->listarCarritos();
print_r($carritos);

//VER UN CARRITO
if (isset($_POST["ver"])) {
  $id_carrito=$_POST["id_carrito"];
  $id_usuario=$_POST["id_usuario"];
  $carrito = $db->listaProductosCarrito($id_usuario);

?>

  <h3>Carrito</h3>
  
  <p>ID carrito: <?= $id_carrito ?>
  <?php
  foreach ($carrito as $prod) {
   
  ?>

    <p>ID PRODUCTO: <?= $prod["id_productos"] . "  <br>  " ?>NOMBRE: <?= $prod["nombre"] . "  <br>  " ?> PRECIO: <?= $prod["precio"] . "€  <br>  " ?> CANTIDAD: <?= $prod["cantidad"] . " " ?>

    <?php
  }
  
}
//SI QUIERO SACAR EL TOTAL DE PRODUCTOS, TENDRIA QUE HACERLO ASI.
// $totalProductos = 0;

// foreach ($carritos as $prod) {

//   $totalProductos += $prod["cantidad"];
//   $total += ($prod["cantidad"] * $prod["precio"]);
// }
//print_r($totalProductos);


  ?>

  <h2>Gestión de Carritos</h2>
  <table class="table">
    <tr>
      <th>ID </th>
      <th>Usuario</th>
      <th>Productos</th>
      <th>Total</th>
      <th>Acciones</th>
    </tr>
    <?php
    //MOSTRAR TODOS LOS CARRITOS
    $total = 0;
    
    foreach ($carritos as $prod) {
      $usuario = $db->listarUnUsuario($prod["id_usuario"]);
      $producto= $db->listarUnProducto($prod["id_producto"]);
      
      $total = ($prod["cantidad"] * $producto["precio"]);
     
    ?>
      <tr>
        <form action="" method="POST">
          <td><?= $usuario["id_usuario"] ?></td>
          <td><?= $usuario["nombre"] ?></td>
          <td><?= $prod["cantidad"] ?></td>
          <td><?= $total ?>€</td>
          <input type="hidden" name="id_carrito" value="<?= $prod["id_carrito"]?>"/>
          <input type="hidden" name="id_usuario" value="<?= $prod["id_usuario"]?>"/>
          <td><button type="submit" class="btn btn-sm btn-info" name="ver">Ver</button><!--añadimos el name-->
            <button type="submit" class="btn btn-sm btn-danger" name="borrarCarrito">Vaciar</button>

          </td>

        </form>
      </tr>
    <?php
    }
    ?>
  </table>

  </main>
  </div>
  </body>

  </html>