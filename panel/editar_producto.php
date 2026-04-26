<?php
include_once("../models.php");
require_once("menu.php");

$categorias = $db->listarCategorias();
$id_producto = $_GET["modificarProducto"];

//RECUPERO EL ID DEL PRODUCTO A EDITAR DE LA PAG PRODUCTOS
//RECUPERO LOS DATOS DEL PRODUCTO Y LOS MUESTRO
if (isset($_GET["modificarProducto"])) {

  $producto = $db->listarUnProducto($id_producto); //cojo un producto

  $nombre = $producto["nombre"];
  $categoria = $producto["nombre"];
  $precio = $producto["precio"];
  $stock = $producto["stock"];
  $descripcion = $producto["descripcion"];
  $id_categorias=$producto["id_categorias"];

  //MODIFICO EL PRODUCTO Y GUARDO LOS CAMBIOS
  if(isset($_POST["guardarProducto"])){
    
    //RECOJO LO QUE LLEGA POR POST
    $nombre = htmlentities($_POST["nombre"]);
    $id_categorias = htmlentities($_POST["categoria"]);
    $precio = htmlentities($_POST["precio"]);
    $stock = htmlentities($_POST["stock"]);
    $descripcion = htmlentities($_POST["descripcion"]);
    print_r($_POST);
    
    $db->modificarProducto($id_producto,$nombre,$id_categorias,$precio,$stock,$descripcion,); 
    $nombre = "";
    $id_categorias = "";
    $precio = "";
    $stock = "";
    $descripcion ="";
    
  }

}
?>

      <h2>Editar producto</h2>
      <form action="" class="card p-4" method="POST">
        <input type="hidden" name="id" value="<?= $id_producto ?>" />
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $nombre ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label>Categoría</label>
            <select class="form-select" name="categoria" id="categoria">
            <?php
              foreach ($categorias as $categoria) {
        ?>

          <option value="<?= $categoria["id_categorias"] ?>" <?php if ($categoria["id_categorias"] == $id_categorias) {
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
            <label>Precio</label>
            <input type="number" name="precio" id="precio" class="form-control" value="<?= $precio ?>">
          </div>
          <div class="col-md-4 mb-3">
            <label>Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="<?= $stock ?>">
          </div>
          <div class="col-md-4 mb-3">
            <label>Ventas</label>
            <input type="number" name="ventas" id="ventas" class="form-control" value="25" disabled>
          </div>
        </div>

        <div class="mb-3">
          <label>Descripción</label>
          <textarea id="descripcion" name="descripcion" required class="form-control"><?= $descripcion ?></textarea>
        </div>

        <button type="submit" name="guardarProducto" class="btn btn-primary">Guardar cambios</button>
        <a href="productos.php" class="btn btn-secondary">Cancelar</a>
      </form>

    </main>
  </div>
</body>

</html>