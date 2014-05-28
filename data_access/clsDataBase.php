<?
/*------------------------------------------------
Author: Andrés Rabinovich
Last change: 5/25/2007

Description: Class to access a generic data base.
-----------------------------------------------*/

/*------------------------------------
Requires the data base specific files.
------------------------------------*/
global $gstrDataBaseType;
require $gstrDataBaseType;

/*-------------------------------
Generic class for using database.
-------------------------------*/
class clsDataBase extends clsSql{

	/*---------
	Debug mode.
	---------*/
	var $bolDebug;

	/*----------------
	Class constructor.
	----------------*/
	function clsDataBase($gstrDataBase = NULL, $gintPort = NULL, $gstrUser = NULL, $gstrPassword = NULL, $gstrHost = NULL) {
			
		/*---------------------
		Debug mode set to false
		by default.
		---------------------*/
		$bolDebug = false;
		
		/*-------------------------------------
		Get connection details from Config.php. 
		-------------------------------------*/

		/*-------------
		Data Base Name.
		-------------*/
		if(!$gstrDataBase) global $gstrDataBase;

		/*-----------------------------
		Port number for the connection.
		-----------------------------*/
		if(!$gintPort) global $gintPort;

		/*-------------
		Data Base user.
		-------------*/
		if(!$gstrUser) global $gstrUser; 
	
		/*------------------------
		Data Base user's password.
		------------------------*/
		if(!$gstrPassword) global $gstrPassword;

		/*---------------------
		Name of Data Base host.
		---------------------*/
		if(!$gstrHost) global $gstrHost;

		/*--------------------------------
		Puts all details into useful vars.
		--------------------------------*/
		$this->strDataBase  	= $gstrDataBase;
		$this->intPort			= $gintPort;
		$this->strUser			= $gstrUser;
		$this->strPassword		= $gstrPassword;
		$this->strHost			= $gstrHost;
	}

	/*--------------------
	Connects to data base.
	--------------------*/
	function open() {

		/*--------------------------------------------
		Connects to data base.
		On error specific data base object manages it.
		--------------------------------------------*/
		clsSql::open();

	}

	/*----------------
	Closes connection.
	----------------*/
	function close() {

		/*--------------------------------------------
		Disconnects from data base.
		On error specific data base object manages it.
		--------------------------------------------*/
		clsSql::close();
	}

	/*-----------------------------------
	Queries data base and returns results
	ByRef on an array.
	-----------------------------------*/
	function query($strQuery, &$arrResults) {

		/*----------------------------------
		If debug mode print query on screen.
		----------------------------------*/
		if($this->bolDebug) echo $strQuery."<br>";
		
		/*--------------------------------------------
		Queries data base. Returns amount of results.
		On error specific data base object manages it.
		--------------------------------------------*/
		return clsSql::query($strQuery, $arrResults);
	}

    /*---------------------------------------------
    Executes INSERT, DELETE or UPDATE on data base.
	Returns InsertId on INSERT or affected rows on
	DELETE or UPDATE.
	---------------------------------------------*/
	function execute($strQuery) {

		/*----------------------------------
		If debug mode print query on screen.
		----------------------------------*/
		if($this->bolDebug) echo $strQuery."<br>";
		
		/*--------------------------------------------
		Executes query on data base.
		On error specific data base object manages it.
		--------------------------------------------*/
		return clsSql::execute($strQuery);

	} 
}