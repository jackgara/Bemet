<?php
/*---------------------------------------------
Author: Andrés Rabinovich
Last change: 10/18/2007

Description: Date Class.
---------------------------------------------*/

/*--------------------
Class to manage dates.
--------------------*/
class clsDate{

	/*-------------------------------------
	String that contains the possible date.
	-------------------------------------*/
	var $strDate;

	/*--------------------------------
	String that contains the language.
	--------------------------------*/
	var $strLanguage;

	/*----------------------------
	String that contains the year.
	----------------------------*/
	var $strYear;

	/*-----------------------------
	String that contains the month.
	-----------------------------*/
	var $strMonth;

	/*---------------------------
	String that contains the day.
	---------------------------*/
	var $strDay;

	/*----------------------------------
	Boolean that contains date validity.
	----------------------------------*/
	var $bolIsDate;

	/*--------------------------
	Booleans with date location.
	--------------------------*/
	var $bolIsPastDate;
	var $bolIsFutureDate;
	var $bolIsToday;

	/*-------------------------------------------------------------
	Class constructor.
	Requieres a string containing a possible date and the language.
	-------------------------------------------------------------*/
	function clsDate($strDate = NULL, $strLanguage = NULL) {
		if(!is_null($strDate)){
			$this->newDate($strDate, $strLanguage);
		}
	}

	/*----------------------------------
	Function that returns date validity.
	----------------------------------*/
	function isDate(){

		/*--------------------
		returns date validity.
		--------------------*/
		return $this->bolIsDate;

	}

	/*------------------------------------
	Function that checks if date is today.
	------------------------------------*/
	function isToday(){

		/*--------------------
		returns date validity.
		--------------------*/
		return $this->bolIsToday;

	}

	/*--------------------------------------------
	Function that checks if date is in the future.
	--------------------------------------------*/
	function isFutureDate(){

		/*--------------------
		returns date validity.
		--------------------*/
		return $this->bolIsFutureDate;

	}

	/*------------------------------------------
	Function that checks if date is in the past.
	------------------------------------------*/
	function isPastDate(){

		/*--------------------
		returns date validity.
		--------------------*/
		return 	$this->bolIsPastDate;

	}

	/*---------------------------------
	Function that validates a new date.
	---------------------------------*/
	function newDate($strDate, $strLanguage){

		/*-----------------------
		Checks for date validity.
		Initialy false.
		-----------------------*/
		$this->bolIsDate = false;

		/*-------------------------------------------------
		First checks if strDate is shorter or equal to 10
		and larger or equal to 6. If not bolIsDate = false.
		-------------------------------------------------*/
		$intDateLenght = strlen($strDate);
		if($intDateLenght <= 10 && $intDateLenght >= 6){
			
			/*--------------------------------------------------
			May be a valid date.
			Splits the string using any character as separator.
			Depending on the language checks the order.
			--------------------------------------------------*/
			switch ($strLanguage){
			
				case "English":
						
						list($this->strMonth, $this->strDay, $this->strYear) = split("[^0-9]", $strDate);
						break;
				
				case "Spanish":

						list($this->strDay, $this->strMonth, $this->strYear) = split("[^0-9]", $strDate);
						break;

				case "DataBase":

						list($this->strYear, $this->strMonth, $this->strDay) = split("[^0-9]", $strDate);
						break;
			}

			/*-----------------------------
			Checks to see if date is valid.
			If not bolIsDate = false.
			If valid bolIsDate = true.
			-----------------------------*/
			if(@checkdate($this->strMonth, $this->strDay, $this->strYear)) {
				$this->bolIsDate = true;

				/*------------------------------------------------------
				Calculates if date is now, in the future or in the past.
				------------------------------------------------------*/
				list($year, $month, $day) = explode("-", date("Y-m-d"));
				
				/*------------
				Date is today.
				------------*/
				if(mktime(0, 0, 0, $this->strMonth, $this->strDay, $this->strYear) == mktime(0, 0, 0, $month, $day, $year)){
					
					$this->bolIsPastDate = false;
					$this->bolIsFutureDate = false;
					$this->bolIsToday = true;

				/*--------------------
				Date is in the future.
				--------------------*/
				}elseif(mktime(0, 0, 0, $this->strMonth, $this->strDay, $this->strYear) > mktime(0, 0, 0, $month, $day, $year)){

					$this->bolIsPastDate = false;
					$this->bolIsFutureDate = true;
					$this->bolIsToday = false;


				/*------------------
				Date is in the past.
				------------------*/		
				}else{

					$this->bolIsPastDate = true;
					$this->bolIsFutureDate = false;
					$this->bolIsToday = false;

				}
			}else{
				
				/*---------------
				Not a valid date.
				---------------*/
				$this->bolIsPastDate = false;
				$this->bolIsFutureDate = false;
				$this->bolIsToday = false;
			}

		}

		/*----------------------------
		Perpetuates date and language.
		----------------------------*/
		$this->strDate		= $strDate;
		$this->strLanguage	= $strLanguage;

	}

	/*----------------------------
	Function that prints the date.
	Recives any valid format.
	----------------------------*/
	function formatDate($strFormat){

		/*-------------------
		Checks date validity.
		-------------------*/
		if($this->bolIsDate){

			/*------------------------
			Returns the formated date.
			------------------------*/
			return date($strFormat, mktime(0, 0, 0, $this->strMonth, $this->strDay, $this->strYear));

		}else{

			/*---------------------
			$strDate is not a date.
			Returns 00/00/0000.
			---------------------*/
			return "00/00/0000";
		}
	}

	/*-----------------------------------------------------------
	Function that returns difference beetwen date and input date.
	-----------------------------------------------------------*/
	function dateDiff($strDate){

		/*-------------------
		Checks date validity.
		-------------------*/
		if($this->bolIsDate){

			/*------------------------
			Returns the formated date.
			86400 seconds = one day.
			------------------------*/
			list($strYear, $strMonth, $strDay) = split("[^0-9]", $strDate);
			return((mktime(0, 0, 0, $this->strMonth, $this->strDay, $this->strYear) - mktime(0, 0, 0, $strMonth, $strDay, $strYear)) / 86400);

		}else{

			/*---------------------
			$strDate is not a date.
			Returns NULL.
			---------------------*/
			return NULL;
		}
	}

	/*--------------------------------
	Function that adds days to a date.
	(negative days substract).
	--------------------------------*/
	function dateAdd($intAmountOfDays){

		/*-------------------
		Checks date validity.
		-------------------*/
		if($this->bolIsDate){

			/*----------------------------
			Perpetuates the formated date.
			----------------------------*/
			$this->newDate(date("Y-m-d", (mktime(0, 0, 0, $this->strMonth, $this->strDay + $intAmountOfDays, $this->strYear))), "DataBase");

		}else{

			/*---------------------
			$strDate is not a date.
			Returns NULL.
			---------------------*/
			return NULL;
		}
	}

	/*--------------------------------------
	Function that substracts days to a date.
	(positive days add).
	--------------------------------------*/
	function dateSub($intAmountOfDays){
		$this->dateAdd(-$intAmountOfDays);
	}

	/*------------------------------------
	Function that returns the current day.
	1 for domingo, 7 for sabado.
	------------------------------------*/
	function currentDay(){
		return($this->formatDate("w") + 1);
	}

	/*------------------------------------
	Function that returns the current month.
	1 for enero, 12 for diciembre.
	------------------------------------*/
	function currentMonth(){
		return($this->formatDate("n"));
	}
	/*---------------------------------------
	This function returns the name of the day
	in the selected language.
	---------------------------------------*/
	function nameDay($strLanguage){

		/*---------------
		Returns the name.
		---------------*/
		if($strLanguage == "Spanish"){

			switch ($this->currentDay()){

				case 1:

							return "domingo";
							break;
				case 2:
							return "lunes";
							break;
				case 3:
							return "martes";
							break;
				case 4:
							return "miercoles";
							break;
				case 5:
							return "jueves";
							break;
				case 6:
							return "viernes";
							break;
				case 7:
							return "sabado";
							break;
			}

		}else{

			switch ($this->currentDay()){

				case 1:

							return "Sunday";
							break;
				case 2:
							return "Monday";
							break;
				case 3:
							return "Thursday";
							break;
				case 4:
							return "Wednesday";
							break;
				case 5:
							return "Thuesday";
							break;
				case 6:
							return "Friday";
							break;
				case 7:
							return "Saturday";
							break;
			}
		}
	}
	/*---------------------------------------
	This function returns the name of the day
	in the selected language.
	---------------------------------------*/
	function nameMonth($strLanguage){

		/*---------------
		Returns the name.
		---------------*/
		if($strLanguage == "Spanish"){

			switch ($this->currentMonth()){

				case 1:

							return "enero";
							break;
				case 2:
							return "febrero";
							break;
				case 3:
							return "marzo";
							break;
				case 4:
							return "abril";
							break;
				case 5:
							return "mayo";
							break;
				case 6:
							return "junio";
							break;
				case 7:
							return "julio";
							break;
				case 8:
							return "agosto";
							break;
				case 9:
							return "septiembre";
							break;
				case 10:
							return "octubre";
							break;
				case 11:
							return "noviembre";
							break;
				case 12:
							return "diciembre";
							break;
			}

		}else{

			switch ($this->currentMonth()){

				case 1:

							return "january";
							break;
				case 2:
							return "febrary";
							break;
				case 3:
							return "march";
							break;
				case 4:
							return "april";
							break;
				case 5:
							return "may";
							break;
				case 6:
							return "june";
							break;
				case 7:
							return "july";
							break;
				case 8:
							return "august";
							break;
				case 9:
							return "september";
							break;
				case 10:
							return "october";
							break;
				case 11:
							return "november";
							break;
				case 12:
							return "december";
							break;
			}
		}
	}
}
?>