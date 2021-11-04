		contenido_textarea = "" ;
		num_caracteres_permitidos = 30;
		function valida_longitud(){ 
			   num_caracteres = document.forms[0].titulo.value.length; 

			   if (num_caracteres > num_caracteres_permitidos){ 
			      document.forms[0].titulo.value = contenido_textarea; 
			   }else{ 
			      contenido_textarea = document.forms[0].titulo.value;	
			   } 

			   if (num_caracteres >= num_caracteres_permitidos){ 
			      document.forms[0].caracteres.style.color="#ff0000"; 
			   }else{ 
			      document.forms[0].caracteres.style.color="#000000"; 
			   }
			cuenta();
         } 
		function cuenta(){ 
		   document.forms[0].caracteres.value=document.forms[0].titulo.value.length;
		} 