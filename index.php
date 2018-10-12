<?php 
try {
	$conexion = new PDO('mysql:host=localhost;dbname=curso_paginacion', 'root', '');	
} catch (PDOException $e) {
	echo "ERROR: " . $e->getMessage();
	die();
}

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$PostPorPagina = 5;

$inicio = ($pagina > 1) ? ($pagina * $PostPorPagina - $PostPorPagina) : 0;

$articulos = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT $inicio, $PostPorPagina"); 
$articulos->execute();
$articulos = $articulos->fetchall();

if (!$articulos) {
	header('location: index.php');
}

$totalArticulos = $conexion->query('SELECT FOUND_ROWS() AS total');
$totalArticulos = $totalArticulos->fetch()['total'];

$numeroPagina = ceil($totalArticulos / $PostPorPagina);
require 'index.view.php';
 ?>