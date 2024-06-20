<?php

$DOC_CHAR_SET = "UTF-8";
date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, "ru_RU".$DOC_CHAR_SET);

class Weigand
{
	public function __construct($x) {
		$bs = pack('L', $x);
		$this->x = ord($bs[2]);
		$this->ts = unpack('v', $bs)[1];
	}

	public $x;
	public $ts;

	public function __toString() {
		return $this->x.'/'.$this->ts;
	}
}

function Weigand2($val)
{
	$res = decbin($val);
	$res1 = substr($res, -16,16 );//2Byte = 8bit+8bit
	$res2 = substr($res, -24,8 );//3Byte <--_8bit_8bit+8bit
	printf("%s = '%s' </br>\n",$val, decbin($val));
	printf("%s = '%s' </br>\n",bindec( $res1 ), $res1);
	printf("%s = '%s' </br>\n",bindec( $res2 ), $res2);
	printf("%s/%s </br>\n",bindec( $res2 ),bindec( $res1 ));
	$res3 = substr($res,-24,24);
	printf("%s = %s </br>\n",$val, bindec( $res3 ));

	$res = "END";
	return $res;
}

function securetext($text) {
	return sprintf("%s", preg_replace('/([?!:^~|@$=*&%.,;\[\]<>()#\/\"\']+)/', '', trim($text) ));
}

if (empty($_GET)) {
	$errox = 418;
	$text = "I'm a teapot";
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	http_response_code($errox);
	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	header($protocol . ' ' . $errox . ' ' . $text);
	echo "<h2 style=\"background-color:orangered;padding:10px;\">HTTP error: {$errox} - {$text}</h2>";
	die();
} else {

	if(isset($_GET['q']) && ($_GET['q'] != "")) {
		$q = securetext($_GET['q']);
		$q1 = new Weigand($q);
		echo $q1.PHP_EOL;
	}

	if(isset($_GET['e']) && ($_GET['e'] != "")) {
		$e = securetext($_GET['e']);
		echo Weigand2($e).PHP_EOL;
	}

}

?>
