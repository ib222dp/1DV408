<?php

class FooterHtml {

	public function __construct() {
		
	}

	public function getHtml() {
		//Sätter datum och tid
		$day = utf8_encode(ucfirst(strftime("%A")));
		$month = ucfirst(strftime("%B"));
		$time = strftime("<p> " . $day . ", den %e " . $month . " år %Y. Klockan är [%T].</p>");

		return	'<footer>'
			. $time .
			'</footer>
			</body>
			</html>';
	}
}
