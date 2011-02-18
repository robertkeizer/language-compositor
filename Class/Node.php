<?php

abstract class Node{

	protected $_title;
	protected $_body;
	
	public function __construct( Safe $title ){
		$this->_title	= $title->toString();
	}

	public function setBody( Safe $body ){
		$this->_body	= $body->toString();
	}
	
	public function getBody( ){
		return $this->_body;
	}

	public function debugNode( ){
		var_dump( $this );
	}
};

?>
