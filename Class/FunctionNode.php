<?php

class FunctionNode extends Node{

	protected $_inputArray = array( );
	protected $_outputArray = array( );
	protected $_type;
	protected $_hash;

	public function __construct( Safe $title, Safe $type = null ){
		if( $type !== null ){
			$this->_type	= $type->toString();
		}else{
			$this->_type	= null;
		}
		parent::__construct( $title );
	}

	public function inputExists( Safe $inputType = null, Safe $inputName, Safe $inputDefault = null ){
		if( $inputType !== null ){
			$inputType = $inputType->toString();
		}
		if( $inputDefault !== null ){
			$inputDefault = $inputDefault->toString();
		}

		foreach( $this->_inputArray as $inputArray ){
			if( $inputArray['inputType'] == $inputType && $inputArray['inputName'] == $inputName->toString() && $inputArray['inputDefault'] == $inputDefault ){
				return true;
			}
		}
		return false;
	}
	
	public function addInput( Safe $inputType = null, Safe $inputName, Safe $inputDefault = null ){

		if( $this->inputExists( $inputType, $inputName, $inputDefault ) ){
			throw new Exception( "The input already exists." );
		}

		if( $inputType !== null ){
			$inputType = $inputType->toString();
		}
		if( $inputDefault !== null ){
			$inputDefault = $inputDefault->toString();
		}

		$tmpInputArray	= array( );
		$tmpInputArray['inputType']	= $inputType;
		$tmpInputArray['inputName']	= $inputName->toString();
		$tmpInputArray['inputDefault']	= $inputDefault;
		$this->_inputArray[] = $tmpInputArray;

		$this->updateHash( );
	}

	public function delInput( Safe $inputType = null, Safe $inputName, Safe $inputDefault = null ){
		if( !$this->inputExists( $inputType, $inputName, $inputDefault ) ){
			throw new Exception( "The specified input was not found." );
		}

		$tmpClassInputArray	= array( );
		foreach( $this->_inputArray as $inputArray ){
			if( $inputArray['inputName'] !== $inputName->toString() ){
				$tmpClassInputArray[]	= $inputArray;
			}
		}
		$this->_inputArray	= $tmpClassInputArray;

		$this->updateHash();
	}

	public function addOutput( Safe $outputType = null, Int $position = null ){
		if( $position !== null && $position < count( $this->_OutputArray ) ){
			throw new Exception( "Invalid position specified for add output." );
		}
		if( $position == null ){
			$position	= count( $this->_outputArray );
		}
		if( $outputType !== null ){
			$outputType = $outputType->toString();
		}
		$this->_outputArray[$position] = $outputType;

		$this->updateHash( );
	}

	public function delOutput( Safe $outputType = null, Int $position = null ){
		if( $position == null && $outputType == null ){
			array_pop( $this->_outputArray );
			return;
		}

		if( $outputType !== null ){
			$outputType = $outputType->toString();
		}

		if( $position !== null ){
			if( $this->_outputArray[$position] !== $outputType ){
				throw new Exception( "Output types given do not match." );
			}
		}else{
			if( count( $this->_outputArray ) !== 1 ){
				throw new Exception( "A position must be specified if there is more than one output." );
			}else{
				if( $this->_outputArray[0] !== $outputType ){
					throw new Exception( "Output type mismatch. In del output." );
				}
			}
		}

		$this->updatehash( );
	}

	public function getInputs( ){
		return $this->_inputArray;
	}

	public function getOutputs( ){
		return $this->_outputArray;
	}

	public function getHash( ){
		return $this->_hash;
	}

	public function getType( ){
		return $this->_type;
	}
};

?>
