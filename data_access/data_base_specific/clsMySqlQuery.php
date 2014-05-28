<?
/*-------------------------------------
Author: Andrés Rabinovich
Last change: 5/31/2007

Description: Class to validate queries.
-------------------------------------*/

/*----------------------
Data base query handler.
----------------------*/
class clsQuery {

	/*-----------
	Query string.
	-----------*/
	var $strQuery;

	/*----------------
	Class constructor.
	----------------*/
	function clsQuery() {

		/*----------------
		Empty constructor.
		----------------*/
	}

	/*--------------------------
	Creates a numeric parameter.
	--------------------------*/
	function numericParameter($fltParameter, $strName) {

		/*-------------------------------------
		Checks to see if it is a valid number.
		If it is, replaces the parameter on the
		query string with it. If not returns 
		false.
		-------------------------------------*/
		if(!is_numeric($fltParameter)){
			$this->strQuery = str_replace($strName, "0", $this->strQuery);
			return false;

		}else{

			/*-------------------------
			Replace parameter on query.
			-------------------------*/
			$this->strQuery = str_replace($strName, $fltParameter, $this->strQuery);
			return true;
		}
	}

	/*-------------------------
	Creates a string parameter.
	-------------------------*/
	function stringParameter($strParameter, $strName) {

		/*--------------
		On empty string.
		--------------*/
		if(strlen($strParameter) == 0){
		
			/*--------------------------------
			Turns parameter into a MySql NULL.
			--------------------------------*/
			$strParameter = "NULL";

		}else{

			/*----------------------------------
			Escape string and prepare it for the 
			query adding ' at the beggining and 
			at the end.
			----------------------------------*/
			$strParameter = "'".mysql_escape_string($strParameter)."'";
		}

		/*-------------------------
		Replace parameter on query.
		-------------------------*/
		$this->strQuery = str_replace($strName, $strParameter, $this->strQuery);
	}

	/*-------------------------------
	Creates a numeric list parameter.
	(1, 2, 3) generally for IN (ids).
	-------------------------------*/
	function numericListParameter($strParameter, $strName) {

		/*--------------
		On empty string.
		--------------*/
		if(strlen($strParameter) == 0){
		
			/*--------------------------------
			Turns parameter into a MySql NULL.
			--------------------------------*/
			$strParameter = "NULL";

		}else{

			/*----------------------------------
			Escape string and prepare it for the 
			query adding ' at the beggining and 
			at the end.
			----------------------------------*/
			$strParameter = mysql_escape_string($strParameter);
		}

		/*-------------------------
		Replace parameter on query.
		-------------------------*/
		$this->strQuery = str_replace($strName, $strParameter, $this->strQuery);
	}
}