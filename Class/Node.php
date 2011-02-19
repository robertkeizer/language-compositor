<?php

abstract class Node{

	protected $_title;
	
	public function __construct( Safe $title ){
		$this->_title	= $title->toString();
	}
		
	public function getTitle( ){
		return $this->_title;
	}

	public function makeNode( ){ }

	public function debugNode( ){
		var_dump( $this );
	}
};

?>
