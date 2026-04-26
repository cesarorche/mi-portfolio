<?php
include_once("../models.php");
require_once("menu.php");

//BORRAR CATEGORIA
if(isset($_GET["borrarCategoria"])){
  print_r($_GET["borrarCategoria"]);
	$id_categoria = $_GET["borrarCategoria"];
  $db->borrarCategoria($id_categoria);
	 
} 

?>

<h2>Gestión de Categorías</h2>
<a href="crear_categoria.php"><button class="btn btn-primary mb-3">Nueva categoría</button></a>

<table class="table">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Productos</th>
    <th>Acciones</th>
  </tr>
  <?php
  
  $totalProductosCategoria=$db->contarProdutosCategorias();
  
    foreach ($totalProductosCategoria as $categoria) {
    ?>
  <tr>
    
    <td><?= $categoria["id_categorias"] ?></td>
    <td><?= $categoria["nombre"] ?></td>
    <td><?= $categoria["totalProductosCategoria"] ?></td>
    <td><a href="crear_categoria.php?modificarCategoria=<?= $categoria["id_categorias"] ?>"><button class="btn btn-sm btn-warning">Editar</button></a>
        <a href="categorias.php?borrarCategoria=<?= $categoria["id_categorias"] ?>"><button class="btn btn-sm btn-danger">Eliminar</button></a>
    </td>
  </tr>

  <?php
    }
    ?>
</table>

</main>
</div>
</body>

</html>