<?php
include_once("../models.php");
require_once("menu.php");

//BORRAR PRODUCTO
if (isset($_SESSION["usuario"])) {
  if (isset($_GET["borrarProducto"])) {
    $id_producto = $_GET["borrarProducto"];
    $db->borrarProductoPanel($id_producto);
  }
}

$productos = $db->listarProductos();
?>

<h2>Gestión de Productos</h2>
<a href="crear_producto.php"><button class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Nuevo producto</button></a>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Imagen</th>
      <th>Nombre</th>
      <th>Categoría</th>
      <th>Precio</th>
      <th>Stock</th>
      <th>Ventas</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($productos as $producto) {
    ?>
      <tr>
        <td><?= $producto["id_productos"] ?></td>
        <td><img src="../<?= $producto["imagen"] ?>"></td>
        <td><?= $producto["nombre"] ?></td>
        <td><?= $producto["id_categorias"] ?></td>
        <td><?= $producto["precio"] ?>€</td>
        <td><?= $producto["stock"] ?></td>
        <td><?= $producto["ventas"] ?></td>
        <td>
          <a href="editar_producto.php?modificarProducto=<?= $producto["id_productos"] ?>"><button class="btn btn-sm btn-warning">Editar</button></a>
          <a href="productos.php?borrarProducto=<?= $producto["id_productos"] ?>"><button class="btn btn-sm btn-danger">Eliminar</button></a>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

</main>
</div>
</body>

</html>