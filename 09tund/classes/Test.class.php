<?php
	class Test{
		// muutujad ehk properties
		private $secretNumber;
		public $publicNumber;
		
		function __construct($sentValue){
			$this->secretNumber = 10;
			$this->publicNumber = $sentValue * $this->secretNumber;
			echo "Salajane: " .$this->secretNumber ." ja avalik: " .$this->publicNumber;
		}//constructor lõppeb
		
		function __destruct(){
			echo " Klass on valmis ja lõpetas!";
		}//Destructor lõppeb
		
		public function showValues(){
			echo "\n Väga salajane: " .$this->secretNumber;
			$this->tellSecret();
		}
		
		
		private function tellSecret(){
			echo " Näidisklass on peaaegu valmis.";
		}
	} //class lõppeb