<?php
	session_start();
	if (isset($_SESSION['email'])){
		header("Location: panel.php");
	}
	include 'credenciales.php';
	$mensaje="";
	if(isset($_POST["button"])){
		$email = $_POST['email'];
		$contraseña = $_POST['contraseña'];
		$contraseña2 = $_POST['contraseña2'];
		$conexion = mysqli_connect(HOST,USER,PASS,DB);
		$consulta="SELECT * FROM usuarios";
		$respuesta= mysqli_query($conexion, $consulta);
		$ver=true;
		if(mysqli_num_rows($respuesta)>0){
			while($fila=mysqli_fetch_array($respuesta,MYSQLI_ASSOC)){
				if ($fila["email"]==$email){
					$mensaje="El email ya está registrado, intenta de nuevo";
					$ver=false;
				}
			}
			if($ver){
				if($contraseña!=$contraseña2){
					$mensaje="Las contraseñas no coinciden";
				}else{
					$dia=date("Y-m-d");
					$consulta='INSERT INTO usuarios(email,password,fechaRegistro) VALUES ("'.$email.'","'.$contraseña.'","'.$dia.'")';
					if (mysqli_query($conexion, $consulta)) {
      					$mensaje="Se ha registrado correctamente";
      					header("Location: login.php");
					}
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Tarea baez</title>
</head>
<body>
	<section class="container">
		<section class="tarjeta">
			<h1>Registrarse</h1>
		<form method="POST">
			<input type="text" name="email" placeholder="Email">
			<input type="password" name="contraseña" placeholder="Contraseña">
			<input type="password" name="contraseña2" placeholder="Repite contraseña">
			<input type="submit" name="button" value="Registrarse">
		</form>
		<div>
			<?php
				echo $mensaje;
			?>
		</div>
		</section>
	</section>
</body>
</html>