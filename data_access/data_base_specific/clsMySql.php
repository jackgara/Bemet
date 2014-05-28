<?
/*---------------------------------------------
Author: Andrés Rabinovich
Last change: 5/25/2007

Description: Class to access a MySql data base.
---------------------------------------------*/

/*------------------------------------- 
Requires data base specific Query class
to work with valid queries.
-------------------------------------*/
require "clsMySqlQuery.php";

/*---------------------
Class for using MySql.
Inherits from clsQuery.
---------------------*/
class clsSql extends clsQuery {
	
	/*------------------------------
	Data Base connection identifier.
	------------------------------*/
	var $intConnection;

	/*-------------
	Data Base Name.
	-------------*/
	var $strDataBase;

	/*-----------------------------
	Port number for the connection.
	-----------------------------*/
	var $intPort;

	/*-------------
	Data Base user.
	-------------*/
	var $strUser; 

	/*------------------------
	Data Base user's password.
	------------------------*/
	var $strPassword;

	/*---------------------
	Name of Data Base host.
	---------------------*/
	var $strHost;

	/*----------------
	Class constructor.
	----------------*/
	function clsSql() {

		/*----------------
		Empty constructor.
		----------------*/
	}

	/*----------------------------
	Connects to data base.
	Returns connection identifier.
	----------------------------*/
	function open() {

		/*----------------------------------
		Check if connection is already open.
		----------------------------------*/
		if(!$this->intConnection){

			/*----------------
			Connects to MySql.
			----------------*/
			$this->intConnection = mysql_connect($this->strHost.":".$this->intPort, $this->strUser, $this->strPassword) or die(mysql_error()); 

			/*----------------
			Selects data base.
			----------------*/
			mysql_select_db($this->strDataBase,$this->intConnection) or die(mysql_error()) ;
	
		}
	}

	/*----------------
	Closes connection.
	----------------*/
	function close() {

		/*--------------------------
		Check if connection is open.
		--------------------------*/
		if(!$this->intConnection){

			/*-------------------------
			Disconnects from data base.
			-------------------------*/
			mysql_close($this->intConnection) or die(mysql_error());
		}

	}

	/*-----------------------------------
	Queries data base and returns results
	ByRef on an array.
	-----------------------------------*/
	function query($strQuery, &$arrResults) {
		
		/*-----------------------------
		Auxiliar array to hold results.
		-----------------------------*/
		$arrAuxiliar = array();

		/*-------------
		Index of array.
		-------------*/
		$intIndex = 0;

		/*------------------------------------------------
		Queries data base. On error prints query and dies.
		------------------------------------------------*/
		$arrAuxiliar = mysql_query($strQuery, $this->intConnection);
		if(mysql_error() && ini_get('display_errors') == "On") die("<br><b>$strQuery</b><br>".mysql_error());

		/*-------------------
		Builds Results array.
		-------------------*/
		while ($arrRecord = mysql_fetch_assoc($arrAuxiliar)) {
			$arrResults[$intIndex] = $arrRecord;
			$intIndex++;
		}

		/*------------------------
		Returns amount of results.
		------------------------*/
		return $intIndex;
	}

    /*---------------------------------------------
    Executes INSERT, DELETE or UPDATE on data base.
	Returns InsertId on INSERT or affected rows on
	DELETE or UPDATE.
	---------------------------------------------*/
	function execute($strQuery) {

		/*------------------------------------------------
		Queries data base. On error prints query and dies.
		------------------------------------------------*/
		mysql_query($strQuery, $this->intConnection);
		if(mysql_error() && ini_get('display_errors') == "On") die("<br><b>$strQuery</b><br>".mysql_error());

		/*-------------------------------------------
		If INSERT then returns InsertId. Else returns
		affected rows.
		-------------------------------------------*/
		$intLastInsertId = mysql_insert_id();
		if ($intLastInsertId > 0){
			return $intLastInsertId;
		}else{
			return mysql_affected_rows();
		}

	} 
}
?>
