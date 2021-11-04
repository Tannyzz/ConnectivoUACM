<?php
		session_start();
		$conexion = mysqli_connect('localhost','root','QUORRAlegacy','connective');

			if (mysqli_connect_errno()){
                echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";                              
            }else{
            		$hora_salida = date("Y-m-d H:i:s");
      				$sql = "UPDATE `usuario` SET `hora_salida` = '$hora_salida' WHERE `usuario`='$_SESSION[usuario]';";
                    mysqli_query($conexion,$sql);     
                    mysqli_close($conexion);               
            }
		session_unset($_SESSION['usuario']);
		session_unset($_SESSION['email']);
		session_destroy(); 		
        header('location: ../index.php');
        exit();
?>