<?php

$DOC_CHAR_SET = "UTF-8";
date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, "ru_RU".$DOC_CHAR_SET);
header("Content-type: text/html; charset=".$DOC_CHAR_SET);

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

function securetext($text) {
	return sprintf("%s", preg_replace('/([?!:^~|@$=*&%.,;\[\]<>()#\/\"\']+)/', '', trim($text) ));
}

if (empty($_GET)) {
        $errox = 403;
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        http_response_code($errox);
        echo "<h2 style=\"background-color:orangered;padding:10px;\">Error: {$errox}</h2>";
        die();
} else {

        if(isset($_GET['q']) && ($_GET['q'] != "")) {
                $q = securetext($_GET['q']);
                $q1 = new Weigand($q);
                echo "Weigand format: " . $q . " --> " . $q1.PHP_EOL;
        }

}

?>
