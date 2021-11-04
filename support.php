<?php 
	session_start();
	$conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');
	$id_tema = $_GET['id'];	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>CONNECTIVE - APOYOS</title>
</head>
<body>
	<div class="navbar-fixed">
    <nav class="grey darken-4 z-depth-1">
      <div class="nav-wrapper blue-text darken-4">
        <a href="home.php" class="brand-logo blue-text darken-4"><i class="material-icons left">navigate_before</i>CONNECTIVE</a>
        <ul class="right hide-on-med-and-down">
          <li><?php echo $_SESSION['usuario']; ?></li>
          <li><a href="auth/logout.php">Cerrar sesión</a></li>
        </ul>
      </div>
    </nav>
  </div><br>

  <div class="row">
  	<div class="col hide-on-small-only m2 l2"><p></p></div>
  	<div class="col s12 m8 l8">
		<!--Header-->
		 <?php 
		  	if (mysqli_connect_errno()) {
		                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
		                              
		    }else{

		      	$sql = "SELECT * FROM `tema` WHERE `id_tema`='$id_tema';";
		        $result = mysqli_query($conexion,$sql);

		        while($row = mysqli_fetch_array($result)){ 
			        $titulo = $row['titulo'];
			        $simpatizantes = $row['simpatizantes'];
			        $email = $row['correo_institucional'];	
			        $fecha_publicacion = $row['fecha_publicacion'];				        
			        $categoria = $row['etiqueta'];
			        $color = $row['color'];
		        }
		        
		        $sql = "SELECT `plantel` FROM `estudiante` WHERE `correo_institucional`='$email';";
		        $result = mysqli_query($conexion,$sql);

		        $num_simpatizantes = "SELECT COUNT(*) AS num_simpatizantes FROM `karma`  WHERE `id_tema` = '$id_tema';";
			    $simpatizantes = mysqli_query($conexion,$num_simpatizantes);

		         while($row = mysqli_fetch_array($result)){ 
			        $plantel = $row['plantel'];
			        	
		        }
		    }
		   ?>
   		<h2><?php echo $titulo ?></h2><span class="right"><a href="#!" class="rigth"><i class="material-icons right">group</i><?php while($num = mysqli_fetch_array($simpatizantes)){ echo " Apoyos: ".$num['num_simpatizantes']." "; } ?></a></span></li>
  		<h5><i class="material-icons left  <?php $clr_formato = explode(" ", $color); echo $clr_formato[0]."-text "."$clr_formato[1];" ?>">label</i><?php echo $categoria; ?></h5>
  		<h6>por <b><?php $usuario = explode('@',$email); $formato = str_replace('.',' ',$usuario[0]); echo ucwords($formato); ?></b> del Plantel <?php echo $plantel."." ?></h6>
		<h6><b>Publicado: </b><?php echo $fecha_publicacion."."; ?></h6> 
  		<br><h4 class="center blue-text darken-3">APOYOS <?php switch ($categoria) {
  			case 'Curso':
  			case 'Evento':
  			case 'Debate':
  				$conector_text = "DEL ";
  				break;
  			
  			default:
  				$conector_text = "DE LA ";
  				break;
  		} echo $conector_text.strtoupper($categoria); ?></h4>
  		<p class="flow-text">Todos y cada uno de las personas que se encuentran en la siguiente lista brindan su apoyo y
  		respaldo a esta tematica. Por una mejor UACM.</p><br>
  		
  		<table class="bordered striped responsive-table">
        <thead>
          <tr>
              <th data-field="nombre">Nombre</th>
              <th data-field="plantel">Plantel</th>
              <th data-field="carrera">Carrera</th>
          </tr>
        </thead>

        <tbody>

        <?php  
        	if (mysqli_connect_errno()) {
		                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
		                              
		    }else{
		    	$sql = "SELECT `correo_institucional` FROM `karma` WHERE `id_tema`='$id_tema' ";
		    	$result1 = mysqli_query($conexion,$sql);

		    	while($row = mysqli_fetch_array($result1)){ 
			    	$correo_institucional = $row['correo_institucional'];		    	
			    	$sql2 = "SELECT * FROM `estudiante` WHERE `correo_institucional` = '$correo_institucional';";
			    	$result2 = mysqli_query($conexion,$sql2);
			    	while($row = mysqli_fetch_array($result2)){ ?>
          <tr>
            <td><?php echo $row['nombre']." ".$row['apellido_p']." ".$row['apellido_m']; ?></td>
            <td><?php echo $row['plantel'] ?></td>
             <td><?php echo $row['carrera'] ?></td>
          </tr>
          <?php } } }?>
        </tbody>
      </table>

  	</div>
  	<div class="col hide-on-small-only m2 l2"><p></p></div>
  </div>


	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>