<?php
    $servername = "localhost";
    $database = "postmortem";
    $username = "root";
    $password = "";

    $con = mysqli_connect($servername, $username, $password, $database);

    if(!$con){
        die("Fallo la conexion de la base de datos".mysqli_connect_error());
    }else{
        
    }  
?>