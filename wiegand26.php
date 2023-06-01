<?php

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
	date_default_timezone_set('Europe/Moscow');
	setlocale(LC_ALL, "ru_RU".$DOC_CHAR_SET);
	header("Content-type: text/html; charset=".$DOC_CHAR_SET);
	echo "exit";

} else {

	if(isset($_GET['q']) && ($_GET['q'] != "")) {
		$q = securetext($_GET['q']);
		$w1 = new Weigand($q);
		echo $w1.PHP_EOL;
	}
}

?>
