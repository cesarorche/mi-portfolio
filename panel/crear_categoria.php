<?php
include_once("../models.php");
require_once("menu.php");

$nombre = "";

if (isset($_POST["guardarProducto"])) {
  //RECOJO LO QUE LLEGA POR POST
  $nombre = htmlentities($_POST["nombre"]);
  print_r($_POST);

}

//MODIFICA CATEGORIA
if ($_GET["modificarCategoria"]) {
  $id_categorias = $_GET["modificarCategoria"];
   $categoria = $db->listarUnaCategoria($id_categorias); //cojo una categoria
   print_r($categoria);
}

//MODIFICO EL PRODUCTO Y GUARDO LOS CAMBIOS
if(isset($_GET["modificarCategoria"])){  
  $id_categoria = $_GET["modificarCategoria"];//recupero la id de la categoria deseado
  

}
if($id_categoria==""){
  //Estamos CREANDO una categoria
  $db->crearCategoria($nombre);
  
  //para una vez creada la categoria se ponen los campos vacios
  $nombre = "";
}
else{
    //Estamos MODIFICANDO una categoria
    //RECOJO LO QUE LLEGA POR POST
  $nombre = htmlentities($_POST["nombre"]);

  $db->modificarCategoria($id_categoria,$nombre); 
  $nombre = "";
}

?>

<h2>Crear categoría</h2>
<form action="" method="POST" class="card p-4">
  <input type="hidden" name="id" value="<?= $id ?>" /><!--Aqui guardo la id cuando vengo de modificar-->
  <div class="mb-3">
    <label for="nombre">Nombre de la categoria</label>
    <input type="text" name="nombre" id="nombre" required class="form-control" value="<?= $categoria["nombre"] ?>">
  </div>
  <button type="submit" name="guardarProducto" class="btn btn-success">Guardar</button>
  <a href="categorias.php" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>

</html>