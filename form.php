<?php

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$nombre=$_POST["nombre"];
$apellido=$_POST["apellido"];
$fecha_nacimiento=$_POST["fecha_nacimiento"];
$grupo=$_POST["grupo"];
$nota=$_POST["nota"];

$con = mysqli_connect('mysql','root','pass');

if (!$con) {
  echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
  echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
  echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

mysqli_select_db($con,"baseDatos");

$sql="INSERT INTO estudiante (nombre,apellido,fecha_nacimiento,grp,nota) VALUES ('".$nombre."','".$apellido."', '".$fecha_nacimiento."',".$grupo.",".$nota.");";

$result = mysqli_query($con,$sql);
?>

<html lang="en">
<head>

</head>
<body>
  <h1>Usuario añadido a la base de datos</h1>
  <a href="index.html">
    <input type="button" value="Volver" />
  </a>
</body>
</html>


