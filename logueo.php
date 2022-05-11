<?php
    require 'conexion.php';
    session_start();
    $usuario = $_POST['email'];
    $password = $_POST['password'];
    $pass_sha1 = sha1($password);

    $query = "SELECT count(*) as contar FROM usuarios WHERE email = '$usuario' AND password = '$password'";

    $consulta = mysqli_query($con, $query);

    $array = mysqli_fetch_array($consulta);

    if($array['contar'] > 0){
        $_SESSION['username'] = $usuario;
        $_SESSION['password'] = $password;
        header('location:principal.php'); 
    }else{
        echo "Datos incorrectos";
    }

?>