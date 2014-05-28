<?php
/*---------------------------------------------------
Author: Andrés Rabinovich
Last change: 08/30/2007

Description: Class to encrypt and decrypt plain text.
---------------------------------------------------*/
class clsCipher {

	/*-----------------------------------------
	String that contains the secure hashed key.
	-----------------------------------------*/
	var $strSecureKey;

	/*------------------------------------------
	Var with the initialization vector (or salt,
	whatever suits your mood).
	------------------------------------------*/
	var	$varIV;

	/*----------------
	Class constructor.
	----------------*/
    function clsCipher() {

		/*--------------------------
		Generates secure hashed key.
		--------------------------*/
		//$this->strSecureKey = hash('sha256', "'asdko13'djkd97979732kjdfaS_dfÄWas35d4c8•¦13sfjmzxcASD[1231asdx]", TRUE);
		$this->strSecureKey = "¼ÈöÉŠd^¨¥ìßÿÍ—ÉSUuè‘nÜfL«:·R‰";

		/*------------------------------
		Generates Initialization vector.
		------------------------------*/
		$this->varIV = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB), MCRYPT_RAND);
    }

	/*--------------------------------
	Function that encrypts plain text.
	--------------------------------*/
    function encrypt($strPlainInput) {
		if(strlen($strPlainInput)){
			return rawurlencode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->strSecureKey, $strPlainInput, MCRYPT_MODE_ECB, $this->varIV));
			//return rawurlencode($strPlainInput);
		}else{
			return $strPlainInput;
		}
    }

	/*------------------------------------
	Function that decrypts encrypted text.
	------------------------------------*/
    function decrypt($strEncryptedInput) {
		if(strlen($strEncryptedInput)){
	        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->strSecureKey, rawurldecode($strEncryptedInput), MCRYPT_MODE_ECB, $this->varIV), "\0");
			//return rtrim(rawurldecode($strEncryptedInput), "\0");
		}else{
			return $strEncryptedInput;
		}
    }

	/*--------------------------------------------
	Function that encrypts plain text on an array.
	--------------------------------------------*/
    function encryptArr(&$arrPlainInput) {
		$intArrays = count($arrPlainInput);
		$arrKeys   = array_keys($arrPlainInput);
		for($intArray = 0; $intArray < $intArrays; $intArray++){
			$arrPlainInput[$arrKeys[$intArray]] = $this->encrypt($arrPlainInput[$arrKeys[$intArray]]);
		}
    }

	/*------------------------------------------------
	Function that decrypts encrypted text on an array.
	------------------------------------------------*/
    function decryptArr(&$arrEncryptedInput) {
		$intArrays = count($arrEncryptedInput);
		$arrKeys   = array_keys($arrEncryptedInput);
		for($intArray = 0; $intArray < $intArrays; $intArray++){
			$arrEncryptedInput[$arrKeys[$intArray]] = $this->decrypt($arrEncryptedInput[$arrKeys[$intArray]]);
		}
    }
}
?>