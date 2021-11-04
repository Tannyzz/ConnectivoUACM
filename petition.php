<?php 
	session_start();
	$conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');
	$id_tema = $_GET['id'];
	include("hour_control.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>CONNECTIVE - TEMA</title>
	<style type="text/css">
		#global {
			height: 550px;
			border: 1px solid #ddd;
			background: #eceff1;
			overflow-y: scroll;
			border-radius: 8px;
		}
	</style>
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

  <?php 
  	if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
    }else{

      	$sql = "SELECT * FROM `tema` WHERE `id_tema`='$id_tema';";
        $result = mysqli_query($conexion,$sql);

        while($row = mysqli_fetch_array($result)){ 
	        $titulo = $row['titulo'];
	        $descripcion = $row['descripcion'];
	        $simpatizantes = $row['simpatizantes'];
	        $email = $row['correo_institucional'];	
	        $fecha_publicacion = $row['fecha_publicacion'];	
	        $categoria = $row['etiqueta'];
	        $color = $row['color'];
        }
        
        $sql = "SELECT `plantel` FROM `estudiante` WHERE `correo_institucional`='$email';";
        $result = mysqli_query($conexion,$sql);
         while($row = mysqli_fetch_array($result)){ 
	        $plantel = $row['plantel'];	        	
        }
    }
   ?>

  <div class="row">
  	<div class="col hide-on-med-and-down l1"><p></p></div>
  	<!--Apartado de tema-->
  	<div class="col s12 m12 l6">
  		<h2><?php echo $titulo ?></h2><span class="right"><a class="blue-text darken-3" href="support.php?id=<?php echo $id_tema ?>" class="rigth"><i class="material-icons right">group</i><?php
  			if(mysqli_connect_errno()) {
    	            echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
  			}else{
  					$num_simpatizantes = "SELECT COUNT(*) AS num_simpatizantes FROM `karma`  WHERE `id_tema` = '$id_tema';";
			    	$simpatizantes = mysqli_query($conexion,$num_simpatizantes);
  		 while($num = mysqli_fetch_array($simpatizantes)){ echo " Apoyos: ".$num['num_simpatizantes']." "; } }?></a></span></li>
  		<h5><i class="material-icons left  <?php $clr_formato = explode(" ", $color); echo $clr_formato[0]."-text "."$clr_formato[1];" ?>">label</i><?php echo $categoria; ?></h5>
  		<h6>por <b><?php $usuario = explode('@',$email); $formato = str_replace('.',' ',$usuario[0]); echo ucwords($formato); ?></b> del Plantel <?php echo $plantel."." ?></h6>
		<h6><b>Publicado: </b><?php echo $fecha_publicacion."."; ?></h6> 		
  		<p class="flow-text" style="text-align: justify;"><?php echo $descripcion ?></p><br>
  		<!--Apoyo-->
  		<form method="POST">
  			<?php

  				if (mysqli_connect_errno()) {
    	            echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
			    }else{
			    	
			    	$correo = "SELECT `correo_institucional` FROM `estudiante` WHERE `usuario` = '$_SESSION[usuario]';";
			    	$key = mysqli_query($conexion,$correo); 
			    	while ($row = mysqli_fetch_array($key)) {
			      		$llave_apoyo = $row['correo_institucional'];
			      	}
			      	
			      	$sql = "SELECT * FROM `karma` WHERE `id_tema`='$id_tema' AND `correo_institucional` = '$llave_apoyo';";
			      	$key2 = mysqli_query($conexion,$sql); 
			      	
			      	while ($row = mysqli_fetch_array($key2)) {
			      		$llave1 = $row['id_tema'];
			      		$llave2 = $row['correo_institucional'];
			      	}
			      	if(empty($llave1) AND empty($llave2)){
			      			$hidden_no_apoyo = "hide";
			      			$hidden_apoyo = "";
			      		}else{
			      			$hidden_no_apoyo = "";
			      			$hidden_apoyo = "hide";
			      		}
			      			?>
  			<!--Apoyo la causa-->  			
							<button class="<?php echo $hidden_no_apoyo; ?> btn waves-effect red lighten-1 waves-light" type="submit" name="no_apoyo">Ya no apoyo la causa
						    <i class="material-icons right">clear</i>
						  </button>
  			<!--Ya no apoyo la causa-->
	  					<button class="<?php echo $hidden_apoyo;?> btn waves-effect teal lighten-2 waves-light" type="submit" name="apoyo">Apoyo la causa
					    <i class="material-icons right">plus_one</i>
					  </button>
				
				  <?php 
				  }?>

  		</form><br>
  		<?php 
  			if(isset($_POST['apoyo'])){

  				if (mysqli_connect_errno()) {
    	            echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
			    }else{

			      	$sql = "SELECT `correo_institucional` FROM `estudiante` WHERE `usuario`='$_SESSION[usuario]';";
			      	$correo = mysqli_query($conexion,$sql);

			      	while ($row = mysqli_fetch_array($correo)) {
			      		$llave_si_apoyo = $row['correo_institucional'];
			      	}	
			      		$agregar_simpatizante = "INSERT INTO `karma` (`id_tema`,`correo_institucional`) VALUES('$id_tema','$llave_si_apoyo');";
			        mysqli_query($conexion,$agregar_simpatizante); ?>
						<script>
							location.href="petition.php?id=<?php echo $id_tema ?>";
						</script>
			  	<?php }
			  			
			 }

			  if(isset($_POST['no_apoyo'])){
				  if (mysqli_connect_errno()) {
	    	            echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
				    }else{

				      	$sql = "SELECT `correo_institucional` FROM `estudiante` WHERE `usuario`='$_SESSION[usuario]';";
				      	$solicitar_llave = mysqli_query($conexion,$sql);

				      	while ($row = mysqli_fetch_array($solicitar_llave)) {
				      		$llave_no_apoyo = $row['correo_institucional'];
				      	}	
				      		$eliminar_simpatizante = "DELETE FROM `karma` WHERE `id_tema`='$id_tema' AND `correo_institucional` = '$llave_no_apoyo' ;";
				        mysqli_query($conexion,$eliminar_simpatizante);	
				        } ?>
							<script>
								location.href="petition.php?id=<?php echo $id_tema ?>";
							</script>
				  	<?php }
			
  		 ?>
  		<div class="divider blue darken-3"></div>
  		
  		<h5>Publica un comentario <b> <?php $formato = str_replace('.',' ',$_SESSION['usuario']); echo ucwords($formato); ?></b></h5>
  		<form method="POST">
  			<div class="row">				
				    <textarea placeholder="Escribe un comentario..." style="border-radius: 8px;" class="blue-grey lighten-5" name="comentario"></textarea>
				<br>
				<button class="btn waves-effect waves-light right blue darken-3" type="submit" name="comentar">Comentar
				    <i class="material-icons right">send</i>
				</button>
			</div>
  		</form>
  	</div>

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
					location.href="petition.php?id=<?php echo $id_tema ?>";
				</script>

		    	<?php
		    }
  		} ?>
  	<!--Apartado de comentarios-->
  	<div class="col s12 m12 l4" id="global">
  		<h4>Comentarios</h4>
  		<div class="divider blue darken-3"></div>  		
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
			  <?php 
			  		$total_destacados = "SELECT COUNT(*) AS numero_destacados FROM `comentario_destacado` WHERE `id_comentario` = '$bandera';";
					$num_destacado = mysqli_query($conexion,$total_destacados);

					while($num_destacado = mysqli_fetch_array($num_destacado)){  
			  							  		
					      if($num_destacado['numero_destacados'] === "1") 
					      	$persona = " persona"; 
					      else $persona = " personas"; 
					      $total_numero_destacados = $num_destacado['numero_destacados'].$persona; }
					
					 	if(0 >= $total_numero_destacados AND $total_numero_destacados < 1){
					 			$color_estrella = "grey";
					 	}else if (1 >= $total_numero_destacados AND $total_numero_destacados < 2) {
					 		$color_estrella = "blue-grey";
					 	}else if (2 >= $total_numero_destacados AND $total_numero_destacados < 3) {
					 		$color_estrella = "brown";
					 	}else if (3 >= $total_numero_destacados AND $total_numero_destacados < 4) {
					 		$color_estrella = "light-green";
					 	}else if (4 >= $total_numero_destacados AND $total_numero_destacados < 5) {
					 		$color_estrella = "green";
					 	}else if (5 >= $total_numero_destacados AND $total_numero_destacados < 6) {
					 		$color_estrella = "deep-purple";
					 	}else if (6 >= $total_numero_destacados AND $total_numero_destacados < 7) {
					 		$color_estrella = "deep-orange";
					 	}else if (7 >= $total_numero_destacados AND $total_numero_destacados < 8) {
					 		$color_estrella = "indigo";
					 	}else if (8 >= $total_numero_destacados AND $total_numero_destacados < 9) {
					 		$color_estrella = "pink";
					 	}else if (9 >= $total_numero_destacados AND $total_numero_destacados < 10) {
					 		$color_estrella = "red darken-3";
					 	}else if ($total_numero_destacados > 10) {
					 		$color_estrella = "amber darken-2";
					 	}
						
			  		 ?>



			  <i class="material-icons circle <?php echo $color_estrella ?>">star_border</i>
		      <b><span class="title"><?php echo ucwords(str_replace("."," ",$row['usuario'])) ?></span></b><br>
		      <span style="font-size: 11px"><b>Comentario destacado por:</b> <?php echo $total_numero_destacados ?>.</span> 
		      <p class="container" style="font-size: 12px; text-align: justify;"><?php echo $row['descripcion']; ?></p>	
			
			<!--Cometario destacado-->
			<div class="row">
					<div class="col s4 m4 l4">
							
								
						      	<?php 
						      		$query_usuario_mas1 = "SELECT * FROM `comentario_destacado` WHERE `id_comentario` = '$bandera' AND `usuario` = '$_SESSION[usuario]';";
									$ejecucion_usuario_mas1 = mysqli_query($conexion,$query_usuario_mas1);

									$execute_sql = mysqli_fetch_array($ejecucion_usuario_mas1);

									if(empty($execute_sql)){
										$hidden_no_destacar = "hide";
							      		$hidden_destacar = "";
									}else{
										$hidden_no_destacar = "";
							      		$hidden_destacar = "hide";	
									}
							      		?>   
						      		<!--DESTACAR GREY-->
						      	<form method="POST">
						      		<input type="hidden" value="<?php echo $bandera; ?>" name="id_comentario_destacado">
						      			<button class="<?php echo $hidden_destacar; ?> tooltipped btn-flat waves-effect waves-blue" data-position="botton" data-delay="10" data-tooltip="Da un +1 para destacar el comentario" type="submit" 
										 name="destacado"> 
										 	<i class="material-icons grey-text darken-4">group_add</i> 
										 </button>	
									
									<!--DESTACAR BLUE-->	 
										 <button class="<?php echo $hidden_no_destacar; ?> tooltipped btn-flat waves-effect waves-blue" data-position="botton" data-delay="10" data-tooltip="Ya no quiero destacar este comentario" type="submit" 
							      		name="no_destacado">
							      		 	<i class="material-icons blue-text darken-4">group_add</i> 
							      		 </button> 								 
						      </form>
						      <?php 
						      	if(isset($_POST['destacado'])){

						      		$comentario_destacado = $_POST['id_comentario_destacado'];
						      			if (mysqli_connect_errno()) {
							                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
									    }else{
									    	$sql_destacado = "INSERT INTO `comentario_destacado` values('$_SESSION[usuario]','$comentario_destacado');";
									    	mysqli_query($conexion,$sql_destacado); ?>
									    	<script>
												location.href="petition.php?id=<?php echo $id_tema ?>";
											</script>
									    <?php }

						      	}
						      	if (isset($_POST['no_destacado'])) {

						      		$comentario_destacado = $_POST['id_comentario_destacado'];
						      			if (mysqli_connect_errno()) {
							                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
									    }else{
									    	$sql_no_destacado = "DELETE FROM  `comentario_destacado` WHERE  `id_comentario` =  '$comentario_destacado' AND  `usuario` =  '$_SESSION[usuario]';";
									    	mysqli_query($conexion,$sql_no_destacado);?>
									    	<script>
												location.href="petition.php?id=<?php echo $id_tema ?>";
											</script>
									    <?php }
						      	}
						       ?>
					</div>					
					<div class="col s4 m4 l4">
						<a href="#!" class="btn-flat tooltipped blue-text darken-3" data-position="bottom" data-delay="50" data-tooltip="<?php echo $row['fecha_publicacion_comentario']; ?>"><i class="material-icons center">date_range</i></a>
					</div>
					<div class="col s4 m4 l4">
						<form method="post">
						      <input type="hidden" name="id_comentario" value="<?php echo $row['id_comentario']; ?>">
						      		<?php if($row['usuario'] == $_SESSION['usuario']){ ?>
						           		<button class="tooltipped btn-flat" type="submit" name="eliminar_coment" data-position="botton" data-delay="10" data-tooltip="Eliminaras tu cometario para siempre">
						           		<i class="material-icons red-text darken-1 right">delete_sweep</i>
						           		</button>
						      		<?php } ?>
						</form>	
					</div>
			</div>
		     <div class="divider"></div>



		      
				<ul class="collapsible" data-collapsible="accordion">
				    <li>
				      <div class="collapsible-header blue-text darken-3"><i class="left material-icons">chevron_right</i>
				      <?php while($retorno_num = mysqli_fetch_array($result_respuesta)){ echo $retorno_num['numero_respuestas']; } ?> Respuestas</div>
				      <div class="collapsible-body">
						<!--ESCRIBE UNA RESPUESTA-->

						
						<a class="waves-effect waves-light blue-text darken-3 btn-flat modal-trigger" href="#<?php echo $row['id_comentario']; ?>">Escribe una respuesta...</a>


						<!--RESPUESTAS A COMENTARIOS-->

								<ul class="collection">
						      		<?php while($respuesta_ob = mysqli_fetch_array($result_respuesta_obtenida)){ ?>
						      		 	<li class="left-align collection-item" style="background: #f1f1f1;">
										      <b><span><?php echo ucwords(str_replace("."," ",$respuesta_ob['usuario'])); ?></span></b><br>
										      <span style="font-size: 10px">Publicado: </span><span style="font-size: 10px" class="blue-text darken-3"><?php echo $respuesta_ob['fecha_publicacion_respuesta']; ?></span><br>
										      <span class="left-align" style="font-size: 12px"><?php echo $respuesta_ob['descripcion']; ?></span>
											      <form method="POST" class="right-align">
											      <input type="hidden" name="id_respuesta" value="<?php echo $respuesta_ob['id_respuesta']; ?>">
											      		<?php if($respuesta_ob['usuario'] == $_SESSION['usuario']){ ?>
											           		<button class="tooltipped btn-flat" type="submit" name="eliminar_respuesta" data-position="botton" data-delay="10" data-tooltip="Eliminaras tu respuesta para siempre">
											           		<i class="material-icons red-text darken-1 right">delete_sweep</i></button>
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
  	<div class="col hide-on-med-and-down l1"><p></p></div>
  </div>  
  		<?php 
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
					location.href="petition.php?id=<?php echo $id_tema ?>";
				</script>
		    	<?php
		    }
  		}
  			if(isset($_POST['eliminar_coment'])){
  				$id_comentario = $_POST['id_comentario'];
  				if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
			    }else{
			    	$query_eliminar_comentario = "DELETE FROM `comentario` WHERE `id_comentario` = '$id_comentario';";
			    	mysqli_query($conexion,$query_eliminar_comentario);	?>
			    	<script>
						location.href="petition.php?id=<?php echo $id_tema ?>";
					</script>
	  			<?php }
	  		}
	  		if(isset($_POST['eliminar_respuesta'])){
	  			$id_respuesta = $_POST['id_respuesta'];
  				if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
			    }else{
			    	$query_eliminar_respuesta = "DELETE FROM `respuesta` WHERE `id_respuesta` = '$id_respuesta';";
			    	mysqli_query($conexion,$query_eliminar_respuesta);	?>
			    	<script>
						location.href="petition.php?id=<?php echo $id_tema ?>";
					</script>
	  			<?php }
	  		}
  		 ?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/connective.js"></script>
</body>
</html>