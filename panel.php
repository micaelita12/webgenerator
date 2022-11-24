<?php 
	session_start();
	include 'credenciales.php';
	if (!isset($_SESSION["email"])) {
		header("Location: login.php");
	}
	$mensage="";
	if (isset($_POST["createWeb"])) {
		if ($_POST["dominio"]=="") {
			$mensage = "Ingresar nombre de dominio antes de presionar el boton";
		}else{
			$dominio = $_SESSION['idUsuario'].$_POST["dominio"];
			$connection = mysqli_connect(HOST,USER,PASS,DB);
			$consulta = "SELECT * FROM webs";
			$respuesta = mysqli_query($connection, $consulta);
			$ver = true;
			while ($fila = mysqli_fetch_array($respuesta, MYSQLI_ASSOC)) {
				if ($fila["dominio"] == $dominio) {
					$mensage = "El dominio ya está ingresado, intenta de nuevo";
					$ver = false;
				}
			}
			if ($ver) {
				$tiempo = date("Y-m-d");
				$consulta = 'INSERT INTO webs(idUsuario,dominio,fechaCreacion) VALUES ("'.$_SESSION["idUsuario"].'","'.$dominio.'",CURRENT_TIMESTAMP)';
				if (mysqli_query($connection,$consulta)) {
					$msg="Dominio creado correctamente";
					shell_exec('./wix.sh ../'.$dominio);
				}else{
					$mensage = "Error: ".$consulta."<br>".mysqli_errno($connection);
				}
			}
		}
	}
	$connection = mysqli_connect(HOST,USER,PASS,DB);
	$consulta = "SELECT * FROM webs";
	$respuesta = mysqli_query($connection, $consulta);
	$tabla="<table>";
	while($fila=mysqli_fetch_array($respuesta,MYSQLI_ASSOC)){
		if ($fila["idUsuario"]==$_SESSION["idUsuario"]){
			$tabla.='<tr><td><a href="../'.$fila["dominio"].'">'.$fila["dominio"].'</a></td><td><a href="zip.php?zip='.$fila["dominio"].'">Descargar web</a></td><td><a href="delete.php?dominio='.$fila["dominio"].'">Eliminar web</a></td></tr>';
		}
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
		<h1>Panel</h1>
		<label for="formulario"><h3>Generar Web de: </h3></label>
		<form method="POST" id="formulario">
			<input type="text" name="dominio" placeholder="Nombre web">
			<input type="submit" name="createWeb" value="Crear">
		</form>
		<?php echo $mensage; ?>
		<br>
		<?php echo $tabla; ?>
		<a href="logout.php">Cerrar sesión</a><br>
	</center>
</body>
</html>