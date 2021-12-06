<!DOCTYPE HTML>
<!--
	Highlights by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>CONNECTIVO - REGISTRO</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
			<section id="header">
				<header class="major">
					<h1>CONNECTIVO</h1>
					<p>ARGUMENTA &nbsp;&bull;&nbsp; DEBATE &nbsp;&bull;&nbsp; DIFUNDE</p>
					<?php
			    //include('database/config.php');

			    $conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');

			    if(mysqli_connect_errno()){
			    	echo "<h4 style=\"color: red\">Fallo la conexion a la base de datos</h4>".mysqli_connect_error();
			    }else{

			    	if(isset($_POST['registrar'])){

			    		$nombre = ucwords($_POST['nombre']);
			    		$apellido_p = ucwords($_POST['apaterno']);
			    		$apellido_m = ucwords($_POST['amaterno']);
			    		//Generamos el Pantel del estudiante por la matricula
			    		$matricula = $_POST['matricula'];
			    		$uPlantel = explode('-', $matricula);
			    		$plantel = $uPlantel[1];

			    		if($plantel == '008'){
			    			$plantel = 'Centro Histórico';	
			    		}else if($plantel == '009'){
			    			$plantel = 'Del Valle';	
			    		}else if($plantel == '010'){
			    			$plantel = 'Casa Libertad';	
			    		}else if($plantel == '011'){
			    			$plantel = 'Cuautepec';	
			    		}else if($plantel == '012'){
			    			$plantel = 'San Lorenzo Tezonco';	
			    		}

			    		$email = $_POST['email'];
			    		$carrera = strtoupper($_POST['carrera']);
			    		$creacion = date("Y-m-d H:i:s");
			    		echo $creacion;

			    		//Encriptamos la contraseña
			    		$contrasenia = ($_POST['pass']);
			    		$salt = md5(uniqid(rand(), true)); 
						$pass = hash('sha512', $salt.$contrasenia); 
			    		
			    		//Generamos el usuario del mismo correo institucional
			    		$creacionUsuario = explode("@", $email);
			    		$usuario = $creacionUsuario[0];

			    		if($contrasenia != $_POST['rpass']){
			    			echo "<p style=\"color: red\">La contraseña no coincide. Intentalo nuevamente.</p>";
			    		}else{
			    			
			    			$query = "INSERT INTO `estudiante` VALUES('$nombre', '$apellido_p', '$apellido_m', '$carrera', '$usuario', '$matricula', '$email', '$pass', 0, '$plantel');";
			    			mysqli_query($conexion, $query);

			    			$registroUs = "INSERT INTO `usuario` VALUES('$usuario','$pass','$salt','$creacion',NULL,NULL);";
			    			mysqli_query($conexion, $registroUs);

			    			echo "<p style=\"color:blue\">Registro exitoso. <br> Serás redireccionado a la pagina de LOGIN automaticamente.</p>";
			    			mysqli_close($conexion);
			    			unset($contrasenia); 
			    			header("refresh:5,url=login.php");
			    		}
			    		

			    	}
			    }
		?>
				</header>
				<div class="container">
					<ul class="actions special">
						<li><a href="#one" class="button primary scrolly">REGISTRATE</a></li>
					</ul>
				</div>
			</section>
		<!-- One -->
			<section id="one" class="main special">
				<div class="container">
					<span class="image fit primary"><img src="images/pic01.jpg" alt="" /></span>
					<div class="content">
						<header class="major">
							<h2>CONNECTIVO</h2>
						</header>
						<form id="signup-form" method="POST">
							Nombre: <input required type="text" name="nombre"><br>
							Apellido Paterno:<input required type="text" name="apaterno"><br>
							Apellido Materno:<input required type="text" name="amaterno"><br>
							Matricula: <input required type="text" name="matricula"><br>
							Correo Instiitucional:<input required type="email" value="@estudiante.uacm.edu.mx" name="email"><br>
							Carrera:<input required type="text" name="carrera"><br>
							Contraseña<input required type ="password" name="pass"><br>
							Repite contraseña: <input required type ="password" name="rpass"><br>
							<input type="submit" name="registrar" value="Registrar">
						</form>						
					</div>
				</div>
					
					<ul class="copyright">
						<li>&copy;2021 Alejadro Plancarte - Connectivo</li></li>
					</ul>
			</section>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>