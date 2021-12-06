<?php 
	session_start();
	date_default_timezone_set('America/Mexico_City');
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $horaDeControl = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ." ". date('H:i:s A');
	$conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');
	$id_tema = $_GET['id'];	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>CONNECTIVO - COMENTARIOS</title>
</head>
<body>

	<div class="navbar-fixed">
    <nav class="grey darken-4 z-depth-1">
      <div class="nav-wrapper blue-text darken-4">
        <a href="home.php" class="brand-logo blue-text darken-4"><i class="material-icons left">navigate_before</i>CONNECTIVO</a>
        <ul class="right hide-on-med-and-down">
          <li><?php echo $_SESSION['usuario']; ?></li>
          <li><a href="auth/logout.php">Cerrar sesión</a></li>
        </ul>
      </div>
    </nav>
  </div><br>

	<div class="row">
		<div class="col hide-on-med-and-down l3"><p></p></div>
		<!--Apartado de comentarios-->
		<div class="col s12 m12 l6">
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
   		<h2><?php echo $titulo ?></h2><span class="right"><a href="support.php?id=<?php echo $id_tema ?>" class="rigth"><i class="material-icons right">group</i><?php while($num = mysqli_fetch_array($simpatizantes)){ echo " Apoyos: ".$num['num_simpatizantes']." "; } ?></a></span></li>
  		<h5><i class="material-icons left  <?php $clr_formato = explode(" ", $color); echo $clr_formato[0]."-text "."$clr_formato[1];" ?>">label</i><?php echo $categoria; ?></h5>
  		<h6>por <b><?php $usuario = explode('@',$email); $formato = str_replace('.',' ',$usuario[0]); echo ucwords($formato); ?></b> del Plantel <?php echo $plantel."." ?></h6>
		<h6><b>Publicado: </b><?php echo $fecha_publicacion."."; ?></h6> 
  		<br><h4 class="center blue-text darken-3">COMENTARIOS <?php switch ($categoria) {
  			case 'Curso':
  			case 'Evento':
  			case 'Debate':
  				$conector_text = "DEL ";
  				break;
  			
  			default:
  				$conector_text = "DE LA ";
  				break;
  		} echo $conector_text.strtoupper($categoria); ?></h4>
  		<p class="flow-text">Conoce la opinion de las demás personas. Te invitamos a que tú tambien nos compartas lo que piensas.</p><br>
  		<ul class="collapsible" data-collapsible="accordion">
		    <li>
		      <div class="collapsible-header"><i class="material-icons blue-text darken-3 right">expand_more</i><h5>Comenta algo <b> <?php $formato = str_replace('.',' ',$_SESSION['usuario']); echo ucwords($formato); ?></b></h5></div>
		      <div class="collapsible-body">
					<form method="POST">
			  			<div class="row">
							<div class="input-field col s12">
							    <textarea id="textarea1" class="materialize-textarea" name="comentario" length="500"></textarea>
							        <label for="textarea1">Comentario</label>
							</div><br>
							<button class="btn waves-effect waves-light right blue darken-3" type="submit" name="comentar">Comentar
							    <i class="material-icons right">send</i>
							</button>
						</div>
			  		</form>
		      </div>
		    </li>
		</ul> 
		<?php if(isset($_POST['comentar'])){

  			$usuario_comentario = $_SESSION['usuario'];
  			$comentario = $_POST['comentario'];
  			$fecha_publicacion_comentario = $horaDeControl;
  			
  			if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
		    }else{
		    	$query_usuario = "SELECT `correo_institucional` FROM `estudiante` WHERE `usuario` = '$_SESSION[usuario]';";
		    	$retorno = mysqli_query($conexion,$query_usuario);
		    	while ($row = mysqli_fetch_array($retorno)) {
		    		$correo = $row['correo_institucional'];
		    	}
		    	$query = "INSERT INTO `comentario` VALUES('','$id_tema','$comentario','$correo','$fecha_publicacion_comentario','$usuario_comentario');";
		    	mysqli_query($conexion,$query); ?>
					<script>
						location.href="coments.php?id=<?php echo $id_tema ?>";
					</script>
		    	<?php
		    	mysqli_close($conexion);
		    }
  		} ?>		
		<!--Body-->
			<ul class="collection">
  		<?php  
  			if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
		    }else{
		    	$query_usuario = "SELECT * FROM `comentario` WHERE `id_tema` = '$id_tema' ORDER BY `fecha_publicacion_comentario` DESC;";
		    	$retorno = mysqli_query($conexion,$query_usuario);
		    	while ($row = mysqli_fetch_array($retorno)) {
		    		$bandera = $row['id_comentario'];
		    		$num_respuestas = "SELECT COUNT(*) AS numero_respuestas FROM `respuesta`  WHERE `id_comentario` = '$bandera';"; 					    		
					$result_respuesta = mysqli_query($conexion,$num_respuestas);
					$sql_respuesta = "SELECT * FROM `respuesta` WHERE `id_comentario` = '$bandera'";
					$result_respuesta_obtenida = mysqli_query($conexion,$sql_respuesta);
  		?>
		   <li class="collection-item avatar">
		      <i class="material-icons circle yellow darken-1">star_border</i>
		      <b><span class="title"><?php echo ucwords(str_replace("."," ",$row['usuario_comentario'])) ?></span></b>
		      <p class="container" style="font-size: 12px; text-align: justify;"><?php echo $row['descripcion']; ?></p>		      
		      <a href="#!" class="secondary-content blue-text darken-3"><span  class="right" style="font-size: 10px"><?php echo $row['fecha_publicacion_comentario']; ?><form method="post">
		      <input type="hidden" name="id_comentario" value="<?php echo $row['id_comentario']; ?>">
		      		<?php if($row['usuario_comentario'] == $_SESSION['usuario']){ ?>
		           		<button class="tooltipped btn-flat right" type="submit" name="eliminar_coment" data-position="botton" data-delay="10" data-tooltip="Eliminaras tu cometario para siempre" href="#!"><i class="material-icons red-text darken-1 right">delete_sweep</i></button>
		      		<?php } ?>
		      </form></span></a>
				<ul class="collapsible" data-collapsible="accordion">
				    <li>
				      <div class="collapsible-header blue-text darken-3"><i class="left material-icons">chevron_right</i>Respuestas
				      <?php while($retorno_num = mysqli_fetch_array($result_respuesta)){ echo " ( ".$retorno_num['numero_respuestas']." )"; } ?></div>
				      <div class="collapsible-body">
						<!--ESCRIBE UNA RESPUESTA-->						
						<a class="waves-effect waves-light blue-text darken-3 btn-flat modal-trigger" href="#<?php echo $row['id_comentario']; ?>">Escribe una respuesta...</a>
						<!--RESPUESTAS A COMENTARIOS-->
								<ul class="collection">
						      		<?php while($respuesta_ob = mysqli_fetch_array($result_respuesta_obtenida)){ ?>
						      		 	<li class="left-align collection-item" style="background: #f1f1f1;">
										      <b><span><?php echo ucwords(str_replace("."," ",$respuesta_ob['usuario_respuesta'])); ?></span></b><br>
										      <span style="font-size: 10px">Publicado: </span><span style="font-size: 10px" class="blue-text darken-3"><?php echo $respuesta_ob['fecha_publicacion_respuesta']; ?></span><br>
										      <span class="left-align" style="font-size: 12px"><?php echo $respuesta_ob['respuesta']; ?></span>	
											      <form method="POST" class="right-align">
											      <input type="hidden" name="id_respuesta" value="<?php echo $respuesta_ob['id_respuesta']; ?>">
											      		<?php if($respuesta_ob['usuario_respuesta'] == $_SESSION['usuario']){ ?>
											           		<button class="tooltipped btn-flat" type="submit" name="eliminar_respuesta" data-position="botton" data-delay="10" data-tooltip="Eliminaras tu respuesta para siempre">
											           		<i class="material-icons red-text darken-1">delete_sweep</i></button>
											      		<?php } ?>
											      </form>
										</li>
						      		<?php } ?>
					      		</ul>
						<!--MODAL PARA COMENTARIO-->
						<div id="<?php echo $row['id_comentario']; ?>" class="modal">
						    <div class="modal-content">
						      <h4>Responde a este comentario: </h4>
						      <p>
						      		<form method="POST">
							  			<div class="row">
											<div class="input-field col s12">
											<input type="hidden" value="<?php echo $row['id_comentario']; ?>" name="id_comentario_respuesta">
											    <textarea id="textarea_respuesta" class="materialize-textarea" name="respuesta" length="500"></textarea>
											        <label for="textarea_respuesta">Escribe tu respuesta</label>
											</div><br>
											<button class="btn waves-effect waves-light right blue darken-3" type="submit" name="responder">Responder
											    <i class="material-icons right">send</i>
											</button>
										</div>
							  		</form>
							  </p>
						    </div>
						    <div class="modal-footer">
						      <a href="#!" class="modal-action modal-close waves-effect waves-light btn red darken-1">CANCELAR</a>
						    </div>
						  </div>
				      </div>
				    </li>
				 </ul>
		      </li>
		    <?php } } ?>
		</ul>
		</div>
		<div class="col hide-on-med-and-down l3"><p></p></div>
	</div>
	<?php 
  			if(isset($_POST['eliminar_coment'])){
  				$id_comentario = $_POST['id_comentario'];
  				if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
			    }else{
			    	$query_eliminar_comentario = "DELETE FROM `comentario` WHERE `id_comentario` = '$id_comentario';";
			    	mysqli_query($conexion,$query_eliminar_comentario);	?>
			    	<script>
						location.href="coments.php?id=<?php echo $id_tema ?>";
					</script>
	  			<?php }
	  		}
	  		if(isset($_POST['responder'])){

  			$usuario_respuesta = $_SESSION['usuario'];
  			$respuesta = $_POST['respuesta'];
  			$id_comentario = $_POST['id_comentario_respuesta'];
  			$fecha_publicacion_respuesta = $horaDeControl;
  			
  			if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
		    }else{		    	

		    	$query = "INSERT INTO `respuesta` VALUES('','$id_comentario','$usuario_respuesta','$respuesta','$fecha_publicacion_respuesta');";
		    	mysqli_query($conexion,$query); ?>
					<script>
					location.href="coments.php?id=<?php echo $id_tema ?>";
				</script>
		    	<?php
		    }
  		}
  		if(isset($_POST['eliminar_respuesta'])){
	  			$id_respuesta = $_POST['id_respuesta'];
  				if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
			    }else{
			    	$query_eliminar_respuesta = "DELETE FROM `respuesta` WHERE `id_respuesta` = '$id_respuesta';";
			    	mysqli_query($conexion,$query_eliminar_respuesta);	?>
			    	<script>
						location.href="coments.php?id=<?php echo $id_tema ?>";
					</script>
	  			<?php }
	  		}
  		 ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>	    
    <script type="text/javascript" src="js/connective.js"></script>
</body>
</html>