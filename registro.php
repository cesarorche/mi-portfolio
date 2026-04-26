<?php

include_once("models.php");
if(isset($_SESSION["usuario"])){
	    header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Item - Start Bootstrap Template</title>
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

    //variables
    $bandera = false;

    $nombre = "";
    $errorLabelNombre = "";
    $errorNombreVacio = "";
    $errorCajaNombre = "";

    $email = "";
    $errorEmailVacio = "";
    $errorLabelEmail = "";
    $errorCajaEmail = "";
    $errorEmailIncorrecto = "";

    $fechaNac = "";
    $errorLabelFechaNac = "";
    $errorFechaNacVacio = "";
    $errorCajaFecha = "";

    $codigoPostal = 0;
    $errorCodigoPostalVacio = "";
    $errorLabelCodigoPostal = "";
    $errorCajaCodigoPostal = "";
    $errorMensajeCodigo = "";

    $telefono = "";
    $errorTelefonoVacio = "";
    $errorLabelTelefono = "";
    $errorCajaTelefono = "";
    $errorMensajeTelefono = "";

    $sexo = "";
    $errorLabelSexo = "";
    $errorSeleccionaCampo = "";
    $checkedh = "";
    $checkedm = "";
    $checkedo="";

    $municipio = "";
    $errorMunicipioVacio = "";
    $estiloErrorMunicipio = "";

    
    $checkedma ="";
    $checkedta ="";
    $checkedno ="";
    $estiloErrorDisponibilidad="";
    $errorDisponibilidadVacio="";


    $pass1 = "";
    $errorLabelPass1 = "";
    $errorVacioPass1 = "";
    $errorCajaPass1 = "";

    $pass2 = "";
    $errorLabelPass2 = "";
    $errorVacioPass2 = "";
    $errorCajaPass2 = "";
    $errorNoSonIguales="";

    $usuarioYaRegistrado = "";
    $UsuarioRegistroOk = "";

    if (isset($_POST["registrar"])) {
        //NOMBRE
        $nombre = htmlentities($_POST["nombre"]);
        if ($nombre == "") {
            $errorNombreVacio = "rellena este campo";
            $errorCajaNombre = "border:1px solid red";
            $errorLabelNombre = "color:red";
            $bandera = true;
        }
        //EMAIL
        $email = htmlentities($_POST["email"]);

        if ($email != "") {    //compruebo que si no está vacio sea formato mail correcto y con la terminación deseada
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, "@educa.madrid.org")) {
                $errorLabelEmail = "color:red";
                $errorCajaEmail = "border:1px solid red";
                $errorEmailIncorrecto = "Email incorrecto";
                $bandera = true;
            }
        } else {
            $errorEmailVacio = "Rellene este campo";
            $errorLabelEmail = "color:red";
            $errorCajaEmail = "border:1px solid red";
            $bandera = true;
        }
        //FECHA NACIMIENTO
        $fechaNac = htmlentities($_POST["fechaNac"]);
        if ($fechaNac == "") {
            $errorLabelFechaNac = "color:red";
            $errorFechaNacVacio = "rellena este campo";
            $errorCajaFecha = "border:1px solid red";
            $bandera = true;
        }
        //CODIGO POSTAL
        $codigoPostal = htmlentities($_POST["codigoPostal"]);

        if ($codigoPostal == "") {
            $errorCodigoPostalVacio = "rellena este campo";
            $errorLabelCodigoPostal = "color:red";
            $errorCajaCodigoPostal = "border:1px solid red";
            $bandera = true;
        } else if (strlen($codigoPostal) != 5) {
            $errorCajaCodigoPostal = "border:1px solid red";
            $errorMensajeCodigo = "debe tener 5 números";
            $errorLabelCodigoPostal = "color:red";
            $bandera = true;
        } else if ($codigoPostal < 0) {
            $errorMensajeCodigo = "CP incorrecto";
            $errorLabelCodigoPostal = "color:red";
            $errorCajaCodigoPostal = "border:1px solid red";
            $bandera = true;
        }

        //TELEFONO   
        $telefono = htmlentities($_POST["telefono"]);
        if ($telefono == "") {
            $errorCajaTelefono = "border:1px solid red";
            $errorTelefonoVacio = "rellena este campo";
            $errorLabelTelefono = "color:red";
            $bandera = true;
        }
        else{
            if (strlen($telefono) != 12) {
            $errorCajaTelefono = "border:1px solid red";
            $errorMensajeTelefono = "debe tener un simbolo + y 11 números";
            $errorLabelTelefono = "color:red";
            $bandera = true;
            }
            //validacion simbolo + y números 
            $tieneSimboloMas = 0;
            $contadorNumero = 0;

            //Validación simbolo +
            if($telefono[0] == "+"){
                $tieneSimboloMas++;
            }

            for ($i = 1; $i < 12; $i++) {
                if (is_numeric($telefono[$i])) {
                    $contadorNumero++;
                }
            }
        
            if ($contadorNumero != 11 || $tieneSimboloMas != 1) {
                $errorMensajeTelefono = "debe tener Un simbolo + en la 1ª posición y 11 números";
                $errorCajaTelefono = "border:1px solid red";
                $errorLabelTelefono = "color:red";
                $bandera = true;
            }

        }
        

        //SEXO
        if (!isset($_POST["sexo"])) {
            $errorLabelSexo = "color:red";
            $errorSeleccionaCampo = "Es obligatorio";
            $bandera = true;
        } else {
            $sexo = htmlentities($_POST["sexo"]);
            if ($sexo == "hombre") {
                $sexo = "hombre";
                $checkedh = "checked";
            } else if ($sexo == "mujer") {
                $sexo = "mujer";
                $checkedm = "checked";
            }
            else{
                $sexo="otro";
                $checkedo="checked";
            }
        }

        //MUNICIPIOS
        $municipio = htmlentities($_POST["municipio"]);
        if ($municipio == "") {
            $estiloErrorMunicipio = "color:red";
            $errorMunicipioVacio = "Se debe elegir un municipio";
            $bandera = true;
        }
        
        
        //DISPONIBILIDAD CAJA CHECK
        $disponibilidad = "";
        if(!isset($_POST["dis1"])&&!isset($_POST["dis2"])&&!isset($_POST["dis3"])){
            $estiloErrorDisponibilidad="color:red";
            $errorDisponibilidadVacio="Es obligatorio";
            $bandera = true;
        }else{
            if(isset($_POST["dis1"])){
                $disponibilidad.="m"; // Con .= concatenamos si seleccionamos varias opciones
                    $checkedma="checked";
                
            }
            if(isset($_POST["dis2"])){
                $disponibilidad.="t";  // Con .= concatenamos texto si seleccionamos varias opciones, si fueran sumar números sería con +=
                $checkedta="checked";
                
            }
            if(isset($_POST["dis3"])){
                $disponibilidad.="n";  // Con .= concatenamos si seleccionamos varias opciones
                $checkedno="checked";
                
            }
            $disponibilidad=htmlentities($disponibilidad);
        }


        //CONTRASEÑAS
        $pass1 = htmlentities($_POST["contrasena1"]);
        if ($pass1 == "") {
            $errorLabelPass1 = "color:red";
            $errorVacioPass1 = "rellena este campo";
            $errorCajaPass1 = "border:1px solid red";
            $bandera = true;
        }

        $pass2 = htmlentities($_POST["contrasena2"]);
        if ($pass2 == "") {
            $errorLabelPass2 = "color:red";
            $errorVacioPass2 = "rellena este campo";
            $errorCajaPass2 = "border:1px solid red";
            $bandera = true;
        }

        if (isset($_POST["contrasena1"]) && isset($_POST["contrasena2"])) {
            if ($pass1 != $pass2) {
                $errorLabelPass1 = "color:red";
                $errorNoSonIguales = "Las contraseñas no son iguales";
                $bandera = true;
            }
        }

        if ($bandera == false) {
            if (!$db->buscarUsuario($_POST["email"])) {
                $db->registrar($nombre, $email, $fechaNac, $codigoPostal, $telefono, $sexo, $municipio,$disponibilidad, $pass1);
                header("Location: login.php");
            } else {
                echo "El usuario ya existe";
            }

        }
    }

    ?>

    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-black ">

            <h1>Registro</h1>
            <form action="" method="POST">
                <!--NOMBRE-->
                <label style="<?= $errorLabelNombre ?>" for="nombre">Nombre:&nbsp&nbsp&nbsp<?= $errorNombreVacio ?></label><br>
                <input style="<?= $errorCajaNombre ?>" type="text" placeholder="Nombre" name="nombre" value="<?= $nombre ?>"/><br><br>

                <!--EMAIL-->
                <label style="<?= $errorLabelEmail ?>" for="email">Email:&nbsp&nbsp&nbsp<?= $errorEmailVacio ?><?= $errorEmailIncorrecto ?></label><br>
                <input style="<?= $errorCajaEmail ?>" type="text" placeholder="email" name="email" value="<?= $email ?>"/><br><br>

                <!--FECHA NACIMIENTO-->
                <label style="<?= $errorLabelFechaNac ?>" for="fechaNac">Fecha de Nacimiento:&nbsp&nbsp&nbsp<?= $errorFechaNacVacio ?></label><br>
                <input style="<?= $errorCajaFecha ?>" type="date" placeholder="fecha de nacimiento" name="fechaNac" value="<?= $fechaNac ?>"/><br><br>

                <!--CODIGO POSTAL-->
                <label style="<?= $errorLabelCodigoPostal ?>" for="codigoPostal">Codigo Postal:&nbsp&nbsp&nbsp<?= $errorCodigoPostalVacio ?><?= $errorMensajeCodigo ?></label><br>
                <input style="<?= $errorCajaCodigoPostal ?>" type="number" placeholder="Codigo Postal" name="codigoPostal" value="<?= $codigoPostal ?>"/><br><br>

                <!--TELEFONO-->
                <label style="<?= $errorLabelTelefono ?>" for="telefono">Telefono:&nbsp&nbsp&nbsp<?= $errorTelefonoVacio ?><?= $errorMensajeTelefono ?></label><br>
                <input style="<?= $errorCajaTelefono ?>" type="text" placeholder="Telefono" name="telefono" value="<?= $telefono ?>"/><br><br>

                <!--SEXO radio buttons   **IMPORTANTE EN LOS RADIO BUTTON el name tiene que ser el mismo en todos**-->
                <label style="<?= $errorLabelSexo ?>" for="sexo">Sexo:&nbsp&nbsp&nbsp<?= $errorSeleccionaCampo ?></label><br>
                <label style="<?= $errorLabelSexo ?>" for="hombre">Hombre</label>
                <input type="radio" name="sexo" id="hombre" <?= $checkedh ?> value="hombre"/><!--hago stycky el radio button-->
                <label style="<?= $errorLabelSexo ?>" for="mujer">Mujer</label>
                <input type="radio" name="sexo" id="mujer" <?= $checkedm ?> value="mujer" /><!--hago stycky el radio button-->
                <label style="<?= $errorLabelSexo ?>" for="otro">Otro</label>
                <input type="radio" name="sexo" id="otro" <?= $checkedo ?> value="otro" /><!--hago stycky el radio button-->
                <br /><br />
                <!--MUNICIPIOS desplegable-->
                <label style="<?= $estiloErrorMunicipio ?>" for="municipio">Municipio:&nbsp&nbsp&nbsp<?= $errorMunicipioVacio ?></label><br>
                <select name="municipio" id="municipio">
                    <option value="">Selecciona un municipio</option>
                    <option value="mejorada" <?php if ($municipio == "mejorada") {
                                                    echo "selected";
                                                } ?>>Mejorada del Campo</option>
                    <option value="velilla" <?php if ($municipio == "velilla") {
                                                echo "selected";
                                            } ?>>Velilla de San Antonio</option>
                    <option value="arganda" <?php if ($municipio == "arganda") {
                                                echo "selected";
                                            } ?>>Arganda del Rey</option>
                </select>
                <br /><br>
                <!--CAJA CHECK DISPONIBILIDAD-->
                <label style="<?= $estiloErrorDisponibilidad ?>" >Disponibilidad:&nbsp&nbsp&nbsp<?= $errorDisponibilidadVacio ?></label><br>
                <label for="man">Mañana</label>
                <input type="checkbox" value="m" name="dis1" id="man" <?= $checkedma ?>/> <br>
                <label for="tar">Tarde</label>
                <input type="checkbox" value="t" name="dis2" id="tar" <?= $checkedta ?>/> <br>
                <label for="noc">Noche</label>
                <input type="checkbox" value="n" name="dis3" id="noc" <?= $checkedno ?>/> <br>
                
                <br/>
                <!--CONTRASEÑA-->
                <label style="<?= $errorLabelPass1 ?>" for="contrasena">Contraseña:&nbsp&nbsp&nbsp<?= $errorVacioPass1 ?><?= $errorNoSonIguales ?></label><br>
                <input style="<?= $errorCajaPass1 ?>" type="password" placeholder="Contraseña" name="contrasena1" /><br><br>
                <!--REPITE CONTRASEÑA -->
                <label style="<?= $errorLabelPass2 ?>" for="contrasena2">Repite Contraseña:&nbsp&nbsp&nbsp<?= $errorVacioPass2 ?></label><br>
                <input style="<?= $errorCajaPass2 ?>" type="password" placeholder="repite contraseña" id="contrasena2" name="contrasena2" value="" /><br><br>
                <input type="submit" value="Registrar" name="registrar" />
            </form>
        </div>
    </div>
    <?php
    include_once("pie.php");
    ?>