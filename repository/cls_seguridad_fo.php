<?
/*------------------------------------------------
Clase para manejo de seguridad en el front office.
METODO UTILIZADO: POST
------------------------------------------------*/
class cls_seguridad_fo{

	var $obj_data_base;					//Base de datos

	var $str_tabla_de_usuarios;			//Nombre de la tabla en la DB de usuarios
	var $str_campo_usuario;				//Nombre del campo usuario en la DB
	var $str_campo_contrasena;			//Nombre del campo contraseña o password en la DB

	var $str_nombre_textbox_usuario;	// names de los textbox del form
	var $str_nombre_textbox_contrasena;

	var $str_array_credenciales;		//Nombre del array de $_SESSION para las credenciales
	var $str_mensaje_error;				//mensaje que presenta cuando se ingresan mal los datos 
	var $str_mensaje_bienvenida;		//mensaje que presenta cuando se ingresa por primera vez
	var $str_mensaje;					//Mensaje que envía el login al sistema.
	var $str_retorno;					//Pantalla a la que retorna despues de desloguearse

	/*----------------------
	Constructor de la clase.
	----------------------*/
	function cls_seguridad_fo(&$obj_data_base = NULL){

		/*----------------------
		CONFIGURACION DEL LOGIN.
		----------------------*/
		$this->str_tabla_de_usuarios			= "clientes";	          
		$this->str_campo_usuario				= "usuario";	         
		$this->str_campo_contrasena				= "contrasena";	          

		$this->str_nombre_textbox_usuario		= "usuario";			  
		$this->str_nombre_textbox_contrasena	= "clave";

		$this->str_array_credenciales			= "credenciales";         
		$this->str_mensaje_error				= "datos inválidos";   
		$this->str_mensaje_bienvenida			= "";   
		$this->str_retorno						= "index.php";
	
		/*----------------
		FIN CONFIGURACION.
		----------------*/
		
		/*-----------------------
		Perpetuadores de objetos.
		-----------------------*/
		$this->obj_data_base					= $obj_data_base;
		
	}

	/*---------------------------------------
	Valída si el usuario está logueado.
	En caso de que no esté logueado, controla
	si el usuario se está tratando o no de 
	loguear.
	---------------------------------------*/
	function validar_usuario(){

		/*----------------------------------
		Se fija si el usuario está logueado.
		----------------------------------*/
		if($this->esta_logueado()){

				/*---------------------------------
				Avisa que el usuario está logueado.
				---------------------------------*/
				return true;

		}else{

			/*---------------------------------------
			Como el usuario no está logueado, se fija 
			si se está intentando loguear.
			---------------------------------------*/
			if($this->esta_intentando_loguearse()){

				/*-----------------------------------------
				Como se está intentando loguear, genera las
				credenciales necesarias.
				-----------------------------------------*/
				if($this->generar_credenciales()){

					/*--------------------------------------
					Las credenciales ingresadas son válidas.
					Avisa que el usuario está logueado.
					--------------------------------------*/
					return true;

				}else{
					
					/*-----------------------------------------
					Las credenciales ingresadas no son válidas.
					Avisa del error en el logueo.
					-----------------------------------------*/
					$this->generar_error_de_logueo();

					return false;
				}
					
			}else{

				/*------------------------------------------
				El usuario ingresa por primera vez. Genera
				mensaje de bienvenida y avisa que el usuario
				no está logueado.
				------------------------------------------*/
				$this->generar_mensaje_de_bienvenida();

				return false;

			}
		}
	}

	/*-------------------------------
	Función que desloguea al usuario.
	-------------------------------*/
	function logoff(){
			
			/*--------------------------------
			Destruye el array de credenciales.
			--------------------------------*/
			unset($_SESSION[$this->str_array_credenciales]);
	}

	/*------------------------------------------------
	Función que controla que el usuario esté logueado.
	------------------------------------------------*/
	function esta_logueado(){

		/*--------------------------------
		Avisa de la condición del usuario.
		--------------------------------*/
		if(isset($_SESSION[$this->str_array_credenciales])){
			return true;
		}else{
			return false;
		}
	}

	/*-------------------------------------------------------------
	Función que se fija si el usuario se esta intentando loguearse.
	-------------------------------------------------------------*/
	function esta_intentando_loguearse(){

		/*--------------------------------
		Avisa de la condición del usuario.
		--------------------------------*/
		if(isset($_POST[$this->str_nombre_textbox_usuario]) || isset($_POST[$this->str_nombre_textbox_contrasena])){
			return true;
		}else{
			return false;
		}
	}

	/*---------------------------------------------------------------
	Función que valida las credenciales del usuario y las genera para 
	que el resto del sistema las pueda usar.
	---------------------------------------------------------------*/
	function generar_credenciales(){

		/*----------------------------------------
		Se conecta a la base de datos para validar
		las credenciales del usuario.
		Las devuelve todas en un array para su uso
		posterior por el resto del sistema.
		----------------------------------------*/
		$this->obj_data_base->strQuery = "SELECT * FROM ".$this->str_tabla_de_usuarios." WHERE ".$this->str_campo_usuario." = @usuario AND ".$this->str_campo_contrasena." = @contrasena AND habilitar = 1 LIMIT 1";
		$this->obj_data_base->stringParameter($_POST[$this->str_nombre_textbox_usuario], "@usuario");
		$this->obj_data_base->stringParameter($_POST[$this->str_nombre_textbox_contrasena], "@contrasena");

		/*--------------------------------
		Avisa de la condición del usuario.
		--------------------------------*/
		if($this->obj_data_base->query($this->obj_data_base->strQuery, $arr_credenciales)){
			
			$_SESSION[$this->str_array_credenciales] = $arr_credenciales[0];

			return true;

		}else{

			return false;

		}

	}

	/*---------------------------------
	Función que produce un mensaje de 
	error en el logueo.
	---------------------------------*/
	function generar_error_de_logueo(){

		$this->str_mensaje = "ERROR";
	}

	/*---------------------------------
	Función que produce un mensaje de 
	bienvenida
	---------------------------------*/
	function generar_mensaje_de_bienvenida(){
		
		$this->str_mensaje = "BIENVENIDA";
	}


}
?>