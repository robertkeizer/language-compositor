<?php

class Safe{

	private $_unsafe;
	
	public function __construct( $unsafe ){
		$this->_unsafe	= $unsafe;
	}
	
	public function toDir( ){
		return $this->_unsafe;
	}

	public function toException( ){
		return $this->_unsafe;
	}

	public function toString( ){
		return $this->_unsafe;
	}

};

?>
