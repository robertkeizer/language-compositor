<?php

class CompositorClass extends Node{

	/* Define the internal variable array. */
	protected $_variableArray = array( );
	
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
	
	/* Allow the addition of class wide variables. */
	public function addVariable( Safe $varType = null, Safe $varName, Safe $varDefault = null ){
		
		/* Define a temporary array.. */
		$temporaryVariableArray	= array( );

		/* If the variable type is set, make sure it doesn't pass the Safe class into the array. */
		if( $varType !== null ){
			$varType	= $varType->toString();
		}

		/* Likewise the save with the default variable, if set. */
		if( $varDefault !== null ){
			$varDefault	= $varDefault->toString();
		}

		/* Fill the temporary array. */
		$temporaryVariableArray['varName']	= $varName->toString();
		$temporaryVariableArray['varType']	= $varType;
		$temporaryVariableArray['varDefault']	= $varDefault;

		/* Check to make sure the variable doesn't already exist. Throw an error if it does. */
		if( in_array( $temporaryVariableArray, $this->_variableArray ) ){
			throw new Exception( "That variable is already defined in this array." );
		}

		/* Append the temporary variable array to the class wide one. */
		$this->_variableArray[]	= $temporaryVariableArray;
	}

	/* Allow the deletion of class wide variables */
	public function delVariable( Safe $varName ){
		/* Define a temporary boolean variable to see if we found it and removed from our temporary array. */
		$found	= false;
		
		/* Define a temporary array to be used to replace this->_variableArray.. */
		$temporaryVariableArray	= array( );
		
		/* Loop through each this->_variableArray and see if ['varName'] matches.. if it doesn't append it to temporaryVariableArray. */
		foreach( $this->_variableArray as $tmpVariableArray ){
			if( $tmpVariableArray['varName'] !== $varName->toString() ){
				$temporaryVariableArray[]	= $tmpVariableArray;
			}else{
				$found = true;
			}
		}
		
		/* If not found, throw an error. */
		if( !$found ){
			throw new Exception( "Could not delete variable with name '{$varName->toString()}' since it doesn't exist in the class." );
		}

		/* Replace this->_variableArray with the temporaryVariableArray created above. */
		$this->_variableArray	= $temporaryVariableArray;
	}

	public function makeNode( ){
		parent::debugNode();
	}
};

?>
