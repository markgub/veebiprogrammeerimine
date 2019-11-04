<?php
	class Test{
		// muutujad ehk properties
		private $secretNumber;
		public $publicNumber;
		
		function __construct(){
			$this->secretNumber = 10;
			$this->publicNumber = 5;
			echo "Salajane: " .$this->secretNumbe ." ja avalik: " .$this->publicNumber;
		}//constructor lõppeb
	} //class lõppeb