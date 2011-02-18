<?php

class CompositorClass extends Node{
	
	/* Define the internal function array. */
	protected $_functionArray = array( );
	
	/* Define the internal connector array.. */
	protected $_connectorArray = array( );
	
	public function addFunction( FunctionNode $fn ){
		if( in_array( $fn, $this->_functionArray ) ){
			throw new Exception( "Function '{$fn->getTitle()}' already exists in '{$this->_title}'" );
		}

		$this->_functionArray[]	= $fn;
	}

	public function delFunction( FunctionNode $fn ){
		if( !in_array( $fn, $this->_functionArray ) ){
			throw new Exception( "Function '{$fn->getTitle()}' doesn't exist in this class." );
		}

		/* Define a temporary array to hold this->_functionArray */
		$tmpFunctionArray	= array( );

		/* Loop through each functionArray and compare it to $fn */
		foreach( $this->_functionArray as $tmpFn ){
			if( $fn !== $tmpFn ){
				$tmpFunctionArray[]	= $tmpFn;
			}
		}
	
		/* Replace this->_functionArray with tmpFunctionArray.. now that $fn is not included. */
		$this->_functionArray	= $tmpFunctionArray;
	}

	public function addConnector( Connector $con ){
		if( in_array( $con, $this->_connectorArray ) ){
			throw new Exception( "The connector already exists." );
		}
		$this->_connectorArray[]	= $con;
	}

	public function delConnector( Connector $con ){
		if( !in_array( $con, $this->_connectorArray ) ){
			throw new Exception( "The connector doesn't exist in this class." );
		}
		
		/* Define a temporary connector array. */
		$tmpConnectorArray	= array( );

		/* Loop through all the connectors and append all of them except 'con' */
		foreach( $this->_connectorArray as $tmpConnector ){
			if( $tmpConnector !== $con ){
				$tmpConnectorArray[]	= $tmpConnector;
			}
		}

		/* Replace the this->_connectoArray with the temporary one built above. */
		$this->_connectorArray	= $tmpConnectorArray;
	}
};

?>
