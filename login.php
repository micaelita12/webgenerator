<?php
	session_start();
	include 'credenciales.php';
	$consola=" ";
	if (isset($_GET['boton'])) {
		$email = $_GET['email'];
		$contraseña = $_GET['contraseña'];
		if ($email == "usuario@gmail.com" && $contraseña == "random1234") {
			$consola = "Has iniciado sesion correctamente";
			$consola = "¡Bienvenido!";
			session_start();
			$_SESSION['email'] = $email;
			$_SESSION['contraseña'] = $contraseña;
			header("Location: paneladmin.php");
		}
		$connection = mysqli_connect(HOST, USER, PASS, DB);
		$query = "SELECT * FROM usuarios";
		$respuesta = mysqli_query($connection, $query);

		if (mysqli_num_rows($respuesta)>0) {
			while ($fila=mysqli_fetch_array($respuesta, MYSQLI_ASSOC)) {
				if ($fila["email"]==$email && $fila["password"]==$contraseña) {
			 		$consola = "¡Bienvenido!";
			 		session_start();
			 		$_SESSION['idUsuario'] = $fila['idUsuario'];
			 		$_SESSION['email'] = $email;
			 		$_SESSION['password'] = $contraseña;
			 		header("Location: panel.php");
			 	}else{
			 		$consola = "Usuario y contraseña incorrectos, vuelva a intentarlo";
			 	}
			}
		}	 
	}
?>

<html>
  <head>
    <meta charset="utf-8" />
    <title>Document</title>
  </head>
  <body>
		<h1 class="title">Micaela Manzoni</h1>
  		<h2 class="name">Iniciar sesion</h2>
	  	<form method="GET" name="miFormu">
	  		<input type="text" name="email" placeholder="Email">
	  		<input type="text" name="contraseña" placeholder="Contraseña">
	  		<input type="submit" name="boton" value="Continuar">
	  	</form>
	  	<p>Todavia no tienes cuenta? <a href="register.php">Registrate aqui</a></p>
	  	<?php
	  	echo $consola;
	  	?>
		</section>
	</section>
  </body>
</html>