<?php 
	include 'credenciales.php';
	$connection = mysql_connect(HOST,USER,PASS,DB);
	$consulta = "SELECT * FROM webs";
	$respuesta = mysqli_query($connection, $consulta);
	$tabla = "<table>";
	while($fila=mysqli_fetch_array($response,MYSQLI_ASSOC)){
		$lista.='<tr><td><a href="../'.$fila["dominio"].'">'.$fila["dominio"].'</a></td></tr>';
		
	}
	$tabla.="</table>"
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tarea Baez</title>
</head>
<body>
	<center>
		<h1>Panel Admin</h1>
		<a href="logout.php">Cerrar sesion</a><br><br>
		<?php echo $lista; ?>
	</center>
</body>
</html>