<?php 
	session_start();
	$conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');
	$url_tematicas = $_GET['tematicas'];
	include("hour_control.php");
	
	if(empty($url_tematicas)){
		$tematicas = "";
	}else if($url_tematicas != $_SESSION['usuario']){ ?>
		<script>
			alert("No puedes solicitar las tematicas de otro USUARIO.");
			location.href="home.php";
		</script>
	<?php }else{
		$tematicas = "WHERE `correo_institucional` = "."'".$url_tematicas."@estudiante.uacm.edu.mx'";
	}
	if (mysqli_connect_errno()) {
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
    }else{

      	$sql = "SELECT `correo_institucional` FROM `estudiante` WHERE `usuario`='$_SESSION[usuario]';";
        $result = mysqli_query($conexion,$sql);

        while($row = mysqli_fetch_array($result)){ 
	        $db_email = $row['correo_institucional'];		
        }
    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>CONNECTIVE - HOME</title>

	
</head>
<body class="grey lighten-2">
	<ul id="filtracion_tematica" class="dropdown-content ">
	  <li><a href="#!" class="blue-text darken-3">Problematicas</a></li>
	  <li class="divider"></li>
	  <li><a href="#!" class="blue-text darken-3">Iniciativas</a></li>
	  <li class="divider"></li>
	  <li><a href="#!" class="blue-text darken-3">Peticiones</a></li>
	  <li class="divider"></li>
	  <li><a href="#!" class="blue-text darken-3">Eventos</a></li>
	  <li class="divider"></li>
	  <li><a href="#!" class="blue-text darken-3">Cursos</a></li>
	  <li class="divider"></li>
	  <li><a href="#!" class="blue-text darken-3">Debates</a></li>
	  <li class="divider"></li>
	</ul>
	<div class="navbar-fixed">
    <nav class="grey darken-4 z-depth-1">
      <div class="nav-wrapper blue-text darken-4">
        <a href="home.php" class="brand-logo blue-text darken-4">CONNECTIVE</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="home.php?tematicas=<?php echo $_SESSION['usuario'] ?>" class="tooltipped blue-text darken-3" data-position="bottom" data-delay="50" data-tooltip="Todos los temas que haz publicado en CONNECTIVE">Temáticas</a></li>
		    <li><a href="#!" class="tooltipped blue-text darken-3" data-position="bottom" data-delay="50" data-tooltip="Son aquellas tematicas a la cuales brindaste tu apoyo">Favoritos</a></li>
		    <li><a class="dropdown-button tooltipped blue-text darken-3" href="#!" data-activates="filtracion_tematica" data-position="bottom" data-delay="50" data-tooltip="Visualiza temáticas en especifico">Filtrar por:<i class="material-icons right">arrow_drop_down</i></a></li>
		    <li><a href="#!" class="tooltipped blue-text darken-3" data-position="bottom" data-delay="50" data-tooltip="Notificaciones"><i class="material-icons right red-text">lightbulb_outline</i><span class="new badge red">4</span></a></li>
		    <li><a href="auth/logout.php" class="tooltipped blue-text darken-3" data-position="bottom" data-delay="50" data-tooltip="Cerrar sesión"><i class="material-icons right">clear</i><?php echo $_SESSION['usuario']; ?></a></li>  
        </ul>       
      </div>
    </nav>
  </div><br>
  <div class="row">
  	<div class="col s12 m4 l4"><p></p></div>
  	<div class="col s12 m4 l4">
  		<ul class="collapsible" data-collapsible="accordion">
		    <li>
		    	<?php echo $msj ?>
		      <div class="collapsible-header"><i class="blue-text darken-3 material-icons">forum</i>Crea una tema</div>
		      <div class="collapsible-body">
					<center>
						<form method="POST">
							<div class="row">
					          <div class="input-field col s12">
					            <input id="input_text" required type="text" name="titulo" onKeyDown="valida_longitud()" onKeyUp="valida_longitud()" length="30">
					            <input type="hidden" name=caracteres size=4>
					            <label for="input_text">TITULO</label>
					          </div>
					        </div>
					        <div class="row">
					          <div class="input-field col s12">
					            <textarea id="textarea1" required class="materialize-textarea" name="descripcion" length="3000"></textarea>
					            <label for="textarea1">DESCRIPCIÓN</label>
					          </div>

								  <select class="browser-default" name="etiqueta" required>
								    <option value="" disabled selected>Selecciona una etiqueta</option>
								    <option value="Problematica">Problematica</option>
								    <option value="Iniciativa">Iniciativa</option>
								    <option value="Peticion">Petición</option>
								    <option value="Evento">Evento</option>
								    <option value="Curso">Curso</option>
								    <option value="Debate">Debate</option>
								  </select>
								  <label class="left-align">Una ETIQUETA es una clasificación que le darás a tu tematica.</label><br>
					          <button class="btn waves-effect waves-light blue darken-3" type="submit" name="publicar">Publicar
							    <i class="material-icons right">send</i>
							  </button>
					        </div>
							
						</form>
					</center>	
		      </div>
		    </li>
		  </ul>
  	</div>
  	<div class="col s12 m4 l4"><p></p></div>
  </div>
  <?php 
  		
			    if(mysqli_connect_errno()){
			    	echo "<h4 style=\"color: red\">Fallo la conexion a la base de datos</h4>".mysqli_connect_error();
			    }else{ 
			    	$query = "SELECT * FROM `tema` $tematicas ORDER BY id_tema DESC";
			    	$retorno = mysqli_query($conexion,$query);
			    	$contador = 0;

			    	while($row = mysqli_fetch_array($retorno)){			    		
					    		$num_comentarios = "SELECT COUNT(*) AS num_coments FROM `comentario`  WHERE `id_tema` = '$row[id_tema]';";			    		
					    		$num_simpatizantes = "SELECT COUNT(*) AS num_simpatizantes FROM `karma`  WHERE `id_tema` = '$row[id_tema]';";
					    		$simpatizantes = mysqli_query($conexion,$num_simpatizantes);						
								$result = mysqli_query($conexion,$num_comentarios);	
								if($contador%4 === 0){ ?> <div class="row"> <?php } ?>	
						<div class="col s12 m6 l3 ">
							<div class="card <?php echo $row['color'] ?> z-depth-2">
					            <div class="card-content white-text">
					              <b><span class="title"><?php echo strtoupper($row['titulo']); ?></span></b>
					              <span style="font-size: 18px" class="right"><a class="black-text" href="support.php?id=<?php echo $row['id_tema'] ?>"><i class="material-icons black-text">group</i><?php while($num = mysqli_fetch_array($simpatizantes)){ echo " ".$num['num_simpatizantes']; } ?></a></span>
					              <h6 style="font-size: 10px"><span><?php echo strtoupper($row['etiqueta']); ?><br></span>por <?php $usuario = explode('@',$row['correo_institucional']); $formato = str_replace('.',' ',$usuario[0]); echo ucwords($formato); ?></h6>
					              <p class="truncate"><?php echo $row['descripcion'] ?></p>
					            </div>
					            <div class="card-action">
					              <a href="coments.php?id=<?php echo $row['id_tema'] ?>" class="black-text">Comentarios 
					              <?php while($coments = mysqli_fetch_array($result)){ echo "(".$coments['num_coments'].")"; } ?></a>
					              <a href="petition.php?id=<?php echo $row['id_tema'] ?>" class="black-text">Leer más</a>
					            </div>
				            </div>
						</div>
					
		<?php ++$contador; } ?></div><?php }  

		if (isset($_POST['publicar'])) {
  			
  			$titulo = $_POST['titulo'];
  			$descripcion = $_POST['descripcion'];
  			$etiqueta = $_POST['etiqueta'];

  			switch ($etiqueta){
  				case "Problematica":
  					$color = "red darken-1";
  					break;
  				case "Iniciativa":
  					$color = "green darken-1";
  					break;
  				case "Peticion":
  					$color = "pink darken-1";
  					break;
  				case "Evento":
  					$color = "deep-purple darken-1";
  					break;
  				case "Curso":
  					$color = "teal darken-1";
  					break;
  				case "Debate":
  					$color = "deep-orange darken-1";
  					break;
  			}
  		
			if(mysqli_connect_errno()){
			    	echo "<h4 style=\"color: red\">Fallo la conexion a la base de datos</h4>".mysqli_connect_error();
			}else{
				$fecha_publicacion = $horaDeControl;

				$altaPeticion = "INSERT INTO `tema` VALUES ('$titulo','$descripcion', '0','','$db_email','0','$fecha_publicacion','$etiqueta','$color');";				
				mysqli_query($conexion,$altaPeticion);?>
				<script>
					location.href="home.php";
				</script>

				<?php
			}
		}?>


	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/limits.js"></script>
</body>
</html>