<?php

include_once("models.php");

if (isset($_SESSION["usuario"])) {
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
    //variables
    $bandera = false;

    $email = "";
    $errorEmailVacio = "";
    $errorLabelEmail = "";
    $errorCajaEmail = "";
    $errorEmailIncorrecto = "";

    $pass1 = "";
    $errorLabelPass1 = "";
    $errorVacioPass1 = "";
    $errorCajaPass1 = "";
    $errorNoSonIguales = "";

    if (isset($_POST["entrar"])) {

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
        //CONTRASEÑAS
        $pass1 = htmlentities($_POST["contrasena1"]);
        if ($pass1 == "") {
            $errorLabelPass1 = "color:red";
            $errorVacioPass1 = "rellena este campo";
            $errorCajaPass1 = "border:1px solid red";
            $bandera = true;
        }

        if ($bandera == false) { //Si todas las banderas estan en falso..
            if ($db->buscarUsuario($_POST["email"])) { //Si encuenentra al usuario..

                if ($db->obtenerIntentos($_POST["email"]) < 3) { // Si los intentos son menor a 3...
                    if ($db->login($_POST["email"], $_POST["contrasena1"])) { //Si el login es correcto...
                        session_regenerate_id(True);
                        $_SESSION["usuario"] = $db->obtenerUsuario($_POST["email"]);// En la sesión guardo el usuario
                        $db->resetearIntentos($_POST["email"]); // y reseteo los intentos a cero

                        header("Location: index.php");
                        exit();
                    } else {
                        echo "Contraseña incorrecta";
                        $db->incrementarIntentos($_POST["email"]); //*Si contraseña es incorrecta incrementa un intento
                    }
                } else {
                    echo "Usuario bloqueado";
                }
            } else {
                echo "Estar intentando entrar con un nombre no registrado";
            }
        }
    }
    require_once("cabecera.php");
    ?>

    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-black">
            <h1>Login</h1>
            <form action="" method="POST">
                <!--EMAIL-->
                <label style="<?= $errorLabelEmail ?>" for="email">Email:&nbsp&nbsp&nbsp<?= $errorEmailVacio ?><?= $errorEmailIncorrecto ?></label><br>
                <input style="<?= $errorCajaEmail ?>" type="text" placeholder="email" name="email" /><br><br>
                <!--CONTRASEÑA-->
                <label style="<?= $errorLabelPass1 ?>" for="contrasena">Contraseña:&nbsp&nbsp&nbsp<?= $errorVacioPass1 ?><?= $errorNoSonIguales ?></label><br>
                <input style="<?= $errorCajaPass1 ?>" type="password" placeholder="Contraseña" name="contrasena1" /><br><br>

                <input type="submit" value="Entrar" name="entrar" />
            </form>
        </div>
    </div>
    <?php
    include_once("pie.php");
    ?>