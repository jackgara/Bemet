<?
/*----------------------------------
Author: Andrés Rabinovich
Last change: 5/25/2007

Description: Site configuration file.
-----------------------------------*/

/*-----------------------
Data base access globals.
-----------------------*/

/*------------
App. language.
------------*/
$gstrAppLanguage = "es";

/*-------------
Data base type.
-------------*/
$gstrDataBaseType = "data_base_specific/clsMySql.php";

/*----------------
Production server.
----------------*/
$gstrProdServerDNS	= array("|server|");
$gstrProdServerPort	= "";

/*-----------------------------------
Sets prod back office root directory.
-----------------------------------*/
define("strPRODBORD", "http://".$gstrProdServerDNS[0].$gstrProdServerPort."/1470_bemet/bo/");
define("strPRODFORD", "http://".$gstrProdServerDNS[0].$gstrProdServerPort."/1470_bemet/");

/*------------------
Developement server.
------------------*/
$gstrDevServerDNS	= "develserver.no-ip.biz";
$gstrDevServerPort	= "";

/*----------------------------------
Sets dev back office root directory.
----------------------------------*/
define("strDEVBORD", "http://".$gstrDevServerDNS.$gstrDevServerPort."/1470_bemet/bo/");
define("strDEVFORD", "http://".$gstrDevServerDNS.$gstrDevServerPort."/1470_bemet/");

/*--------------------
Finds out environment.
--------------------*/
if(in_array($_SERVER['SERVER_NAME'], $gstrProdServerDNS)){

	ini_set('display_errors','Off');

	/*-------------------------------
	We are in production environment.
	Sets database.
	-------------------------------*/
	$gstrDataBase		= "pampawor_1139";
	$gintPort			= "3306";
	$gstrUser			= "pampawor_1139";
	$gstrPassword		= "1139";
	$gstrHost			= "localhost";
	define("strBOARD", strPRODBORD); 
	define("strFOARD", strPRODFORD); 
	define("strENV", "PROD");

	/*----------------------------------------
	Sets back and front office root directory.
	----------------------------------------*/
	define("strBORD", "/bo/");


}else{

	ini_set('display_errors','On');

	/*---------------------------------
	We are in developement environment.
	Sets database.
	---------------------------------*/
	$gstrDataBase  		= "1470_bemet";
	$gintPort			= "3306";
	$gstrUser			= "root";
	$gstrPassword		= "8diaseneltibet";
	$gstrHost			= "localhost";
	define("strBOARD", strDEVBORD); 
	define("strFOARD", strDEVFORD); 
	define("strENV", "DEV");

	/*----------------------------------------
	Sets back and front office root directory.
	----------------------------------------*/
	define("strBORD", "/bo/");

}

/*---------------------------------
Amount of records shown by default.
---------------------------------*/
$gintRecordsPerPage = 20;

/*---------------
Application name.
---------------*/
$gstrApplicationName = "Bemet";

/*---------------------------
Application wellcome message.
---------------------------*/
$gstrApplicationWellcomeMessage = "Bienvenido a Bemet";

/*--------------------------------
Rolls images in Internet Explorer?
(Has problems with image caching.
--------------------------------*/
$bolRollImagesIE = false;
$gbolShowAllowedFileTypes = true;
/*------------------------
Includes language locales.
------------------------*/
switch ($gstrAppLanguage){

	case "es":
				require "locales/spanish.php";
				break;

	case "en":
				require "locales/english.php";
				break;

	default:
				require "locales/spanish.php";
				break;
}
?>