<?php

class Tienda
{

	private $pdo;

	public function __construct($host, $port, $db, $user, $pass)
	{
		$this->pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $db, $user, $pass);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	/****************************************************************************************/
	public function listarProductos()
	{
		$sentencia = "SELECT * FROM productos ";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute();
		$registros = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	/****************************************************************************************/
	public function listarProductosUnaCategoria($id_categoria)
	{
		$sentencia = "SELECT * FROM productos WHERE id_categorias=:id_categorias ";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":id_categorias" => $id_categoria
			)
		);
		$registros = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	/****************************************************************************************/
	public function listarCategorias()
	{
		$sentencia = "SELECT * FROM categorias ";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute();
		$categorias = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $categorias;
	}
	/*************************************************************************************** */
	public function listarUnaCategoria($id_categorias)
	{
		$sentencia = "SELECT * FROM categorias WHERE id_categorias = :id_categorias";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":id_categorias" => $id_categorias
			)
		);
		$categoria = $ejecucion->fetch(PDO::FETCH_ASSOC);
		return $categoria;
	}
	/*****************************************************************************************/
	public function listarUnProducto($id_producto)
	{
		$sentencia = "SELECT * FROM productos WHERE id_productos = :id_producto";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":id_producto" => $id_producto
			)
		);
		$producto = $ejecucion->fetch(PDO::FETCH_ASSOC);
		return $producto;
	}
	/*************************************************************************************** */
	public function listarUnUsuario($id_usuario)
	{
		$sentencia = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":id_usuario" => $id_usuario
			)
		);
		$usuario = $ejecucion->fetch(PDO::FETCH_ASSOC);
		return $usuario;
	}
	/*****************************************************************************************/
	public function listarProductosMasVendidos()
	{
		$sentencia = " SELECT * FROM productos ORDER BY ventas DESC LIMIT 4 ";

		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute();

		return $ejecucion->fetchAll(PDO::FETCH_ASSOC);
	}
	/****************************************************************************************/
	public function listaProductosCarrito($id_usuario)
	{
		$sentencia = "SELECT productos.nombre as nombre, productos.id_productos as id_productos, carrito.cantidad as cantidad, productos.precio as precio FROM carrito, productos WHERE id_usuario=:id_usuario AND carrito.id_producto=productos.id_productos";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":id_usuario" => $id_usuario
			)
		);
		$registros = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	/************************************************************************************** */
	public function listarCarritos()
	{
		$sentencia = "SELECT * FROM carrito";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute();
		
		$registros = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	/****************************************************************************************/
	public function actualizarCarrito($id_usuario, $id_producto, $cantidad){
		//pregunto por el producto si esta en el carrito
		$sentencia =  "SELECT * FROM carrito WHERE id_producto =:id_producto AND id_usuario=:id_usuario";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":id_producto" => $id_producto,
				":id_usuario" => $id_usuario
			)
		);
		$registro = $ejecucion->fetch(PDO::FETCH_ASSOC);
		//Si NO existe el producto lo agrego al carrito
		if (!$registro) {
			$sentencia = "INSERT INTO carrito(id_usuario,id_producto,cantidad) VALUES (:id_usuario,:id_producto,:cantidad)"; //la sentencia que queremos realizar la guardamos en 1 variable
			$ejecucion = $this->pdo->prepare($sentencia);  // preparamos la sentencia en otra variable
			$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
				array(
					":id_usuario" => $id_usuario,
					":id_producto" => $id_producto,
					":cantidad" => $cantidad

				)
			);
		} else { // Y si SI existe lo actualizo la cantidad
			$sentencia = "UPDATE carrito SET cantidad = cantidad+ :cantidad 
										WHERE id_producto = :id_producto AND id_usuario=:id_usuario "; // sin el id actualizaria todas las filas de la tabla

			$ejecucion = $this->pdo->prepare($sentencia);
			$ejecucion->execute([
				":id_usuario" => $id_usuario,
				":id_producto" => $id_producto,
				":cantidad" => $cantidad
			]);
		}
		
	}
	
/******************************************************************************************* */ 
	public function aumentarCantidad($id_usuario, $id_producto, $cantidad){
		$sentencia = "UPDATE carrito SET cantidad = cantidad+ :cantidad
										WHERE id_producto = :id_producto AND id_usuario=:id_usuario";

		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":id_usuario" => $id_usuario,
			":id_producto" => $id_producto,
			":cantidad" => $cantidad
		]);
	}
	/******************************************************************************************* */ 
	public function reducirCantidad($id_usuario, $id_producto, $cantidad){
		$sentencia = "UPDATE carrito SET cantidad = cantidad- :cantidad
										WHERE id_producto = :id_producto AND id_usuario=:id_usuario AND cantidad > :cantidad";

		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":id_usuario" => $id_usuario,
			":id_producto" => $id_producto,
			":cantidad" => $cantidad
		]);
	}
	/************************************************************************************** */
	public function crearCategoria($nombre){
		try{
			$sentencia = "INSERT INTO categorias(nombre) VALUES (:nombre)";
			$ejecucion = $this->pdo->prepare($sentencia);
			$ejecucion->execute(
				array(
					":nombre" => $nombre
				)
			);
		} catch (PDOException $e) {
        echo "ERROR SQL: " . $e->getMessage();
        exit;
    	}
			
	}
	/****************************************************************************************/
	public function crearProducto($nombre,$precio,$stock,$imagen,$descripcion,$ventas,$id_categorias)
	{	
		try{
			$sentencia = "INSERT INTO productos(nombre,precio,stock,imagen,descripcion,ventas,id_categorias) VALUES (:nombre,:precio,:stock,:imagen,:descripcion,:ventas,:id_categorias)"; //la sentencia que queremos realizar la guardamos en 1 variable
			$ejecucion = $this->pdo->prepare($sentencia);  // preparamos la sentencia en otra variable
			$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
				array(
					":nombre" => $nombre,
					":precio" => $precio,
					":stock" => $stock,
					":imagen" => $imagen,
					":descripcion" => $descripcion,
					":ventas" => $ventas,
					":id_categorias" => $id_categorias
					
				)
			);
		} catch (PDOException $e) {
        echo "ERROR SQL: " . $e->getMessage();
        exit;
    	}
		//para una vez creada la noticia se ponen los campos vacios
		//se deja esticky solo cuando no estan todos los campos rellenos
		// $nombre = "";
		// $descripcion = "";
		// $precio = "";
	}
	/************************************************************************************** */
	public function borrarProductoPanel($id_producto)
	{
		try{
			$sentencia = "DELETE FROM productos WHERE id_productos =:id_productos";
			$ejecucion = $this->pdo->prepare($sentencia);
			$ejecucion->execute(
				array(
					":id_productos" => $id_producto
				)
			);
		} catch (PDOException $e) {
        echo "ERROR SQL: " . $e->getMessage();
        exit;
    	}
	}
	/****************************************************************************************/
	public function borrarProducto($id_usuario, $id_producto)
	{
		$sentencia = "DELETE FROM carrito WHERE id_producto =:id_producto AND id_usuario=:id_usuario";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":id_usuario" => $id_usuario,
				":id_producto" => $id_producto
			)
		);
	}
	/************************************************************************************* */
	
	public function borrarCarrito($id_carrito){
		$sentencia = "DELETE FROM carrito WHERE id_carrito =:id_carrito";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":id_carrito" => $id_carrito
			)
		);
	}
	/************************************************************************************* */
	public function borrarCategoria($id_categorias){
		try{
			$sentencia = "DELETE FROM categorias WHERE id_categorias =:id_categorias";
			$ejecucion = $this->pdo->prepare($sentencia);
			$ejecucion->execute(
				array(
					":id_categorias" => $id_categorias
				)
			);
		} catch (PDOException $e) {
        echo "ERROR SQL: " . $e->getMessage();
        exit;
    	}
	}

	/****************************************************************************************/
	public function modificarProducto($id_productos,$nombre,$id_categorias,$precio,$stock,$descripcion)
	{
		//Esto le dice a MySQL:“Actualiza SOLO la noticia cuyo id es X”
		try{
			$sentencia = "UPDATE productos SET 
											nombre = :nombre,
											id_categorias = :id_categorias,
											precio = :precio,
											stock = :stock,
											descripcion = :descripcion
										WHERE id_productos = :id_productos"; // sin el id actualizaria todas las filas de la tabla

			$ejecucion = $this->pdo->prepare($sentencia);
			$ejecucion->execute([
				":nombre" => $nombre,
				":id_categorias" => $id_categorias,
				":precio" => $precio,
				":stock" => $stock,
				":descripcion" => $descripcion,
				":id_productos" => $id_productos
			]);
		} catch (PDOException $e) {
        echo "ERROR SQL: " . $e->getMessage();
        exit;
    	}
	}
	/************************************************************************************************** */
	
	public function modificarCategoria($id_categoria,$nombre){
		//Esto le dice a MySQL:“Actualiza SOLO la noticia cuyo id es X”
		try{
			$sentencia = "UPDATE categorias SET 
											nombre = :nombre
										WHERE id_categorias = :id_categorias"; // sin el id actualizaria todas las filas de la tabla

			$ejecucion = $this->pdo->prepare($sentencia);
			$ejecucion->execute([
				":nombre" => $nombre,
				":id_categorias" => $id_categoria
			]);
		} catch (PDOException $e) {
        echo "ERROR SQL: " . $e->getMessage();
        exit;
    	}
	}
	/*************************************************************************************************** */
	 
	public function contarProdutosCategorias(){
		$sentencia = "SELECT c.id_categorias,c.nombre,COUNT(p.id_productos) AS totalProductosCategoria
					  FROM categorias c LEFT JOIN productos p ON p.id_categorias = c.id_categorias
					  GROUP BY c.id_categorias, c.nombre";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute();
		$resultado = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//LEFT JOIN	Todas las categorías aunwue tengan 0 productos
	//INNER JOIN	Solo categorías con productos, las que tienen 0 las elimina

	/*****************REGISTRO Y LOGIN********************************* */

	public function buscarUsuario($email)
	{
		$sentencia = "SELECT COUNT(*) as cantidad FROM usuario WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":email" => $email
		]);
		$res = $ejecucion->fetch(PDO::FETCH_ASSOC);
		if ($res["cantidad"] == 0) {
			return false;
		} else {
			return true;
		}
	}

	public function registrar($nombre, $email, $fechaNacimiento, $codigoPostal, $telefono, $sexo, $municipio, $disponibilidad, $password)
	{
		$sentencia = "INSERT INTO usuario(nombre, email, fechaNacimiento, codigoPostal, telefono, sexo, municipio, disponibilidad, password) VALUES (:nombre,:email,:fechaNacimiento,:codigoPostal,:telefono,:sexo,:municipio, :disponibilidad, :password)";
		$ejecucion = $this->pdo->prepare($sentencia);  // preparamos la sentencia en otra variable
		$password = password_hash($password, PASSWORD_DEFAULT);	//así encripto la contraseña, solo en registro, en login no hace falta.
		$ejecucion->execute(					// ejecutamos la sentencia añadiendo una fila a la tabla 
			array(
				":email" => $email,
				":nombre" => $nombre,
				":fechaNacimiento" => $fechaNacimiento,
				":codigoPostal" => $codigoPostal,
				":telefono" => $telefono,
				":sexo" => $sexo,
				":municipio" => $municipio,
				":disponibilidad" =>$disponibilidad,
				":password" => $password

			)
		);
	}

	public function login($email, $pass1)
	{
		$sentencia = "SELECT password FROM usuario WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":email" => $email
		]);
		$res = $ejecucion->fetch(PDO::FETCH_ASSOC);
		if (password_verify($pass1, $res["password"])) {
			return True;
		} else {
			return False;
		}
	}

	public function incrementarIntentos($email)
	{
		$sentencia = "UPDATE usuario SET intentos=intentos+1 WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":email" => $email
			)
		);
	}

	public function obtenerIntentos($email)
	{
		$sentencia = "SELECT intentos FROM usuario WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":email" => $email
		]);
		$res = $ejecucion->fetch(PDO::FETCH_ASSOC);
		return $res["intentos"];
	}

	public function obtenerId($email)
	{
		$sentencia = "SELECT id_usuario FROM usuario WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":email" => $email
		]);
		$res = $ejecucion->fetch(PDO::FETCH_ASSOC);
		return $res["id_usuario"];
	}
	public function obtenerUsuario($email)
	{

		$sentencia = "SELECT * FROM usuario WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":email" => $email
		]);
		$usuario = $ejecucion->fetch(PDO::FETCH_ASSOC);
		return $usuario;
	}

	public function resetearIntentos($email)
	{

		$sentencia = "UPDATE usuario SET intentos=0 WHERE email=:email";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":email" => $email
			)
		);
	}


	public function listarTareas($id)
	{

		$sentencia = "SELECT * FROM lista WHERE id_users=:id";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute([
			":id" => $id
		]);
		$registros = $ejecucion->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}

	public function crearTarea($tarea, $id)
	{
		$sentencia = "INSERT INTO lista(tarea,id_users) VALUES (:tarea,:id)";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":tarea" => $tarea,
				":id" => $id
			)
		);
	}

	public function borrarTarea($id, $id_users)
	{
		$sentencia = "DELETE FROM lista WHERE id_lista=:id_lista AND id_users=:id_users";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":id_lista" => $id,
				":id_users" => $id_users
			)
		);
	}


	public function limpiarTareas($id)
	{
		$sentencia = "DELETE FROM lista WHERE id_users=:id";
		$ejecucion = $this->pdo->prepare($sentencia);
		$ejecucion->execute(
			array(
				":id" => $id
			)
		);
	}
}
