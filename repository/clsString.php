<?php
/*---------------------------------------------
Author: Andrés Rabinovich
Modifications by: Federico Rabinovich
Last change: 15/03/2008

Description: String Class.
---------------------------------------------*/

/*----------------------
Class to manage strings.
----------------------*/
class clsString{

	/*--------------------
	If had to trim string.	
	--------------------*/
	var $bolTrimedString;

	/*--------------
	Amount of pages.
	--------------*/
	var $intPages;

	/*--------------
	Amount of pages.
	--------------*/
	var $strString;

	/*--------------------------
	Amount of chars before trim.
	--------------------------*/
	var $intChars;

	/*----------------------------
	Added string to trimed string.
	Ex: "..."
	----------------------------*/
	var $strAdded;

	//La funcion Macheo es una funcion que reemplaza en el textoOriginal, las palabras 
	//que coinciden en el array[n][1] por el modo, embebido con el texto y el id (array[n][0])
	
	function macheo(&$strTextoOriginal, &$arrOriginal, &$strModo){							
		$dimensionArrOriginal=count($arrOriginal);											
		for ($intArrOriginal=0; $intArrOriginal<$dimensionArrOriginal; $intArrOriginal++){	
			$strSustituta=str_replace("@id", $arrOriginal[$intArrOriginal][0], $strModo);	// aca se reemplaza el @id del modo por el id real sacado del array
			$strSustituta=str_replace("@texto", $arrOriginal[$intArrOriginal][1], $strSustituta); // aca se reemplaza el @texto del modo por el texto real sacado del array
			$strTextoOriginal = str_ireplace($arrOriginal[$intArrOriginal][1], $strSustituta, $strTextoOriginal);
		}
	}

	/*----------------
	Class constructor.
	----------------*/
	function clsString($strString = NULL, $intChars = NULL, $strAdded = "...") {
		
		$this->strString		= $strString;
		$this->intChars			= $intChars;
		$this->strAdded			= $strAdded;
		$this->bolTrimedString  = false;
		if($strSting) $this->pages();

	}

	/*----------------------------------------------
	function that trims a string to a desire length.
	Adds chars at the end if requiered.
	----------------------------------------------*/
	function maxLength($intChars = 0){
		
		if($intChars == 0){
			$intChars = $this->intChars;
		}
		if(strlen($this->strString) > $intChars){
			$this->bolTrimedString = true;
			return str_replace("\n", "<br>", str_replace("\r\n", "<br>", substr($this->strString, 0, $intChars))).$this->strAdded;
		}else{
			return $this->strString;
		}

	}

	/*---------------------------------------------
	function that gets amount of "pages" of a given
	string of a given lenght.
	---------------------------------------------*/
	function pages(){

		$this->intPages = ceil(strlen($this->strString) / $this->intChars);

	}

	/*-------------------------------------------
	function that returns a given page of a given
	string.
	-------------------------------------------*/
	function getPage($intPage){
		if($intPage < ($this->intPages - 1)){
			if(ord(substr($this->strString, $intPage * $this->intChars + $this->intChars, 1)) == 10){
				return preg_replace('#\r?\n#', '<br />', substr($this->strString, $intPage * $this->intChars, $this->intChars + 1).$this->strAdded);
			}else{
				return preg_replace('#\r?\n#', '<br />', substr($this->strString, $intPage * $this->intChars, $this->intChars).$this->strAdded);
			}
		}else{
			return $this->completeLastPage(substr($this->strString, $intPage * $this->intChars, $this->intChars));
		}
	}

	function completeLastPage($strString){
		$intChars = $this->intChars - strlen($strString);
		for($intChar = 0; $intChar < $intChars; $intChar++){
			$strString .= "&nbsp; ";
		}
		return $strString;
	}


}
?>