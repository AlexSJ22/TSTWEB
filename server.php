<?php
include 'result2XML.php';

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


$con = mysqli_connect('mysql','root','pass');

if (!$con) {
  echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
  echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
  echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

mysqli_select_db($con,"baseDatos");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($group_id=$_POST["code"]) != "0" ){
  $sql="SELECT e.nombre, e.apellido, e.fecha_nacimiento, g.codigo, e.nota FROM estudiante e JOIN grupo g ON e.grp=g.id WHERE g.id=".$group_id.";";
} else {
  $sql="SELECT e.nombre, e.apellido, e.fecha_nacimiento, g.codigo, e.nota FROM estudiante e JOIN grupo g ON e.grp=g.id;";
}

$result = mysqli_query($con,$sql);


if($result){
  header('Content-Type: application/xml');
  echo result2XML($result,"estudiantes","estudiante");
}

mysqli_close($con);
?>