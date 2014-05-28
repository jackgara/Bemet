<?
/*-------------------------------
Author: AR
Modifications by: 
Last change: 28/01/2009

Description: Class to send email.
Allows PEAR and sendmail.
-------------------------------*/

/*-------------------
Class to send emails.
-------------------*/
class cls_email{

	/*-----------------------------
	Headers. Can be an array (PEAR)
	or a string (sendmail).
	-----------------------------*/
	var $var_headers;

	/*----------------------------------
	What are we gonna use to send email.
	Can be PEAR or sendmail.
	----------------------------------*/
	var $str_type;

	/*-----------
	PEAR objects.
	-----------*/
	var $obj_message;

	var $obj_smtp;
	
	/*----------------------------
	Email configuration variables.
	----------------------------*/
	var $str_from;

	var $str_to;
	
	var $str_subject;

	var $str_body;

	/*---------------------------
	PEAR configuration variables.
	---------------------------*/
	var $str_host;
	
	var $bol_auth;
	
	var $str_username;
	
	var $str_password;

	/*-------------
	Return message.
	-------------*/
	var $str_message;

	/*------------------
	Class constructor.
	sendmail by default.
	------------------*/
	function cls_email($str_type = "sendmail") {
		
		$this->str_type	= $str_type;

		/*---------
		Valid type.
		---------*/
		switch ($this->str_type){

			case "PEAR":
				require_once "Mail.php";
				require_once "Mail/mime.php";
				$this->obj_message = new Mail_mime("\n");
				break;

			case "sendmail":
				$this->var_headers  = 'MIME-Version: 1.0' . "\r\n";
				$this->var_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				break;

			default:
				die("El tipo de sistema de envío de email debe ser 'PEAR' o 'sendmail'");
				break;
		}

	}

	/*--------------------------------
	Spliter function. Chooses the way
	to send email.
	--------------------------------*/
	function send(){

		switch ($this->str_type){

			case "PEAR":
				return $this->send_pear();
				break;

			case "sendmail":
				return $this->send_sendmail();
				break;

		}
	}
	
	/*---------------------
	Sends email using PEAR.
	---------------------*/
	function send_pear(){

		/*-------------------
		Headers sanity check. 
		-------------------*/
		$this->pear_build_headers();

		/*---------------------
		Sends email using PEAR.
		---------------------*/
		$this->obj_message->setHTMLBody($this->str_body);
		$this->body = $this->obj_message->get();
		$obj_mail = $this->obj_smtp->send($this->str_to, $this->var_headers, $this->str_body);
		if (PEAR::isError($obj_mail)){
			$this->str_message = $obj_mail->getMessage();
			return false;
		}else{
			return true;
		}

	}

	/*-------------------------
	Sends email using sendmail.
	-------------------------*/
	function send_sendmail(){

		if(mail($this->str_to, utf8_decode($this->str_subject), utf8_decode($this->str_body), $this->var_headers)){
			return true;	
		}else{
			$this->str_message = "Ocurrió un error al enviar el email usando sendmail. No hay más datos al respecto.";
			return false;
		}
	}

	/*-------------------------
	Build headers if not exist. 
	-------------------------*/
	function pear_build_headers(){

		/*-------------------
		Headers sanity check. 
		-------------------*/
		if(!$this->str_host) die('Por favor, setee $this->str_host');
		if(!$this->bol_auth) die('Por favor, setee $this->bol_auth');
		if(!$this->str_username) die('Por favor, setee $this->str_username');
		if(!$this->str_password) die('Por favor, setee $this->str_password');
		if(!$this->str_from) die('Por favor, setee $this->str_from');
		
		/*----------------------
		Builds PEAR mail object.
		----------------------*/
		$this->obj_smtp = Mail::factory('smtp', array ('host' => $this->str_host, 'auth' => $this->bol_auth, 'username' => $this->str_username, 'password' => $this->str_password));
		$this->var_headers = $this->obj_message->headers(array ('From' => $this->str_from, 'Subject' => $this->str_subject));

	}
	
}
?>