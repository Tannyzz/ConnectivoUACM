<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Usuarios</title>
</head>
<body>

		<form method="POST">
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

		<?php
			    include('database/config.php');

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

			    			$registroUs = "INSERT INTO `usuario` VALUES('$usuario','$pass','$creacion','$creacion','$creacion','$salt');";
			    			mysqli_query($conexion, $registroUs);

			    			echo "<p etyle=\"color:blue\">Registro exitoso. Verifica tu correo electrónico para verificar tu cuenta. Valida la cuenta antes de entrar al sistema.</p>";
			    			echo "<a href=\"login.php\">Ingresa al sistema</a>";
			    			mysqli_close($conexion);
			    			unset($contrasenia); 

			    		}
			    		

			    	}
			    }
		?>
	
</body>
</html>