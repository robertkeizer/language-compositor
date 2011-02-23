<?php

abstract class Node{

	protected $_title;
	protected $_body = null;
	protected $_hash;
	
	public function __construct( Safe $title ){
		if( $title->isEmpty( ) ){
			throw new Exception( "title for a node must not be empty." );
		}
		$this->_title	= $title->toString();
	}
		
	public function getTitle( ){
		return $this->_title;
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

	public function updateHash( ){
		$runningHash = "";
		foreach( $this as $var => $value ){
			$runningHash .= md5( $var.$value );
		}
		$this->_hash	= md5( $runningHash );
	}
};

?>
