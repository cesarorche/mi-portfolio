<?php
include_once("../models.php");
require_once("menu.php");

$id="";
$nombre = "";
$precio = "";
$stock = "";
$imagen = "";
$descripcion="";
$ventas="";
$categoria = "";

$categorias = $db->listarCategorias();
//print_r($_POST);

if (isset($_POST["guardarProducto"])) {
  
  //RECOJO LO QUE LLEGA POR POST
  $nombre = htmlentities($_POST["nombre"]);
  $precio = htmlentities($_POST["precio"]);
  $stock = htmlentities($_POST["stock"]);
  $imagen = htmlentities($_POST["imagen"]);
  $descripcion = htmlentities($_POST["descripcion"]);
  $ventas = htmlentities($_POST["ventas"]);
  $id_categorias = htmlentities($_POST["categoria"]);
  print_r($_POST["categoria"]);

   //Estamos creando una multa
    $db->crearProducto($nombre,$precio,$stock ,$imagen ,$descripcion,$ventas,$id_categorias);
  
  //para una vez creada la noticia se ponen los campos vacios
  //se deja esticky solo cuando no estan todos los campos rellenos
  $nombre = "";
  $categoria = "";
  $precio = "";
  $stock = "";
  $imagen = "";
  $descripcion="";
  $ventas="";
  

}
?>
<h2>Crear producto</h2>
<form action="" method="POST" class="card p-4">
  <input type="hidden" name="id" value="<?= $id ?>" /><!--Aqui guardo la id cuando vengo de modificar-->
  <div class="row">
    <div class="col-md-6 mb-3">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" required class="form-control" value="<?= $nombre ?>">
    </div>
    <div class="col-md-6 mb-3">
      <label for="categoria">Categoría</label>

      <select class="form-select" name="categoria" id="categoria">
        <?php

        foreach ($categorias as $categoria) {
        ?>

          <option value="<?= $categoria["id_categorias"] ?>" <?php if ($categoria == $categoria["nombre"]) {
                                                        echo "selected";
                                                      } ?>><?= $categoria["nombre"] ?></option>

        <?php
        }
        ?>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4 mb-3">
      <label for="precio">Precio</label>
      <input type="number" name="precio" id="precio" required class="form-control" value="<?= $precio ?>">
    </div>
    <div class="col-md-4 mb-3">
      <label for="stock">Stock</label>
      <input type="number" name="stock" id="stock" required class="form-control" value="<?= $stock ?>">
    </div>
    <div class="col-md-4 mb-3">
      <label for="ventas">Ventas</label>
      <input type="number" name="ventas" id="ventas" required class="form-control"  value="0">
    </div>
  </div>

  <div class="mb-3">
    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" required class="form-control"><?= $descripcion ?></textarea>
  </div>

  <div class="mb-3">
    <label for="imagen">Imagen</label>
    <input type="file" name="imagen" id="imagen" class="form-control">
  </div>

  <button type="submit" name="guardarProducto" class="btn btn-success">Guardar</button>
  <a href="productos.php" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>

</html>