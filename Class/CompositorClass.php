<?php

class CompositorClass extends Node{

	protected $_variableArray = array( );
	protected $_functionArray = array( );
	protected $_connectorArray = array( );
	protected $_hash;
	
	public function addFunction( FunctionNode $fn ){
		if( in_array( $fn, $this->_functionArray ) ){
			throw new Exception( "Function '{$fn->getTitle()}' already exists in '{$this->_title}'" );
		}

		$this->_functionArray[]	= $fn;

		$this->updateHash( );
	}

	public function delFunction( FunctionNode $fn ){
		if( !in_array( $fn, $this->_functionArray ) ){
			throw new Exception( "Function '{$fn->getTitle()}' doesn't exist in this class." );
		}

		$tmpFunctionArray	= array( );
		foreach( $this->_functionArray as $tmpFn ){
			if( $fn !== $tmpFn ){
				$tmpFunctionArray[]	= $tmpFn;
			}
		}
		$this->_functionArray	= $tmpFunctionArray;

		$this->updateHash( );
	}

	public function addConnector( Connector $con ){
		if( in_array( $con, $this->_connectorArray ) ){
			throw new Exception( "The connector already exists." );
		}
		$this->_connectorArray[]	= $con;

		$this->updateHash( );
	}

	public function delConnector( Connector $con ){
		if( !in_array( $con, $this->_connectorArray ) ){
			throw new Exception( "The connector doesn't exist in this class." );
		}
		
		$tmpConnectorArray	= array( );

		foreach( $this->_connectorArray as $tmpConnector ){
			if( $tmpConnector !== $con ){
				$tmpConnectorArray[]	= $tmpConnector;
			}
		}

		$this->_connectorArray	= $tmpConnectorArray;

		$this->updateHash( );
	}

	public function makeVarArray( Safe $varType = null, Safe $varName, Safe $varDefault = null ){
		if( $varType !== null ){
			$varType	= $varType->toString();
		}
		if( $varDefault !== null ){
			$varDefault	= $varDefault->toString();
		}
		$tmpVarArray			= array( );
		$tmpVarArray['varType']		= $varType;
		$tmpVarArray['varName']		= $varName->toString();
		$tmpVarArray['varDefault']	= $varDefault;

		return $tmpVarArray;
	}

	public function varExists( Safe $varType = null, Safe $varName, Safe $varDefault = null ){
		$tmpVarArray	= $this->makeVarArray( $varType, $varName, $varDefault );
		if( in_array( $tmpVarArray, $this->_variableArray ) ){
			return true;
		}else{
			return false;
		}
	}

	public function addVariable( Safe $varType = null, Safe $varName, Safe $varDefault = null ){
		if( $this->varExists( $varType, $varName, $varDefault ) ){
			throw new Exception( "That variable is already defined in this array." );
		}
		$tmpVarArray	= $this->makeVarArray( $varType, $varName, $varDefault );
		$this->_variableArray[]	= $temporaryVariableArray;
	}

	public function delVariable( Safe $varType = null, Safe $varName, Safe $varDefault = null ){
		if( !$this->varExists( $varType, $varName, $varDefault ){
			throw new Exception( "Could not delete variable with name '{$varName->toString()}' since it doesn't exist in the class." );
		}

		$tmpVarArray	= $this->makeVarArray( $varType, $varName, $varDefault );

		$fillerArray	= array( );
		foreach( $this->_variableArray as $varArray ){
			if( $varArray !== $tmpVarArray ){
				$fillerArray[]	= $varArray;
			}
		}

		$this->_variableArray	= $fillerArray;

		$this->updateHash( );
	}
};

?>
