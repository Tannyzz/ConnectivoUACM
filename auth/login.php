<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--[if lte IE 8]><script src="js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="../css/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
	<title>CONNECTIVO - Ingresar</title>
</head>
<body>
<!-- Header -->
      <header id="header">
        <h1 style="color: #1565c0;">Connectivo</h1>
        <p>Argumenta &nbsp;&bull;&nbsp; Debate &nbsp;&bull;&nbsp; Difunde</p>
      </header>
	<form id="signup-form" method="POST">
		<p style="font-size: 18px">Usuario </p><input required type="text" name="usuario" >
		<p style="font-size: 18px">Contraseña </p><input required type="password" name="pass"><br>
		<input style="background: #1565c0;" type="submit" name="ingresar" value="Entrar">
	</form>  
  <footer id="footer">
        <ul class="copyright">
          <li>&copy; Alejandro Plancarte</li><li>Creación: 25/09/2021</li>
        </ul>
      </footer>  
	<?php      
      $conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');      
      if (isset($_POST['ingresar'])){

      		$usuario = $_POST['usuario'];
      		$contrasenia = $_POST['pass'];

      		if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
            }else{

      				$sql = "SELECT * FROM `usuario` WHERE `usuario`='$usuario';";
                    $result = mysqli_query($conexion,$sql);

                     while($row = mysqli_fetch_array($result)){ 

                     			$db_user = $row['usuario'];
                     			$db_hash = $row['contraseña'];
                     			$db_salt = $row['salt'];                  			
                     }
            } 
      	if ($db_hash === hash('sha512', $db_salt.$contrasenia) and $db_user === $usuario){      			
      		
      		if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
            }else{
            		$hora_entrada = date("Y-m-d H:i:s");
      				$sql = "UPDATE `usuario` SET `hora_entrada` = '$hora_entrada' WHERE `usuario`='$usuario';";
                    mysqli_query($conexion,$sql);                    
            }	
      			$_SESSION['usuario'] = $db_user;
                  header("Location: ../home.php");
   		}else{
   			echo "<text>Usuario o contraseña incorrectos. Intentalo nuevamente.</text>";
   		}
	}?>
	<script src="../js/main.js"></script>
</body>
</html>