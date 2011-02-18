<?php

class FunctionNode extends Node{
	
	/* Define the class wide inputArray. This is to avoid problems with foreach. */
	protected $_inputArray = array( );
	/* Define the class wide outputArray. This is to avoid problems with foreach. */
	protected $_outputArray = array( );
	
	/* Add an input to a given function node. */
	public function addInput( Safe $inputType = null, Safe $inputName, Safe $inputDefault = null ){
		/* Allow for a blank inputType. */
		if( $inputType == null ){
			$inputType = Safe( "" );
		}

		/* Loop through the current inputs, make sure none have the exact same inputName. */
		foreach( $this->_inputArray as $currentInput ){
			if( $currentInput['inputName'] == $inputName->toString() ){
				throw new Exception( "Input with input name of '{$inputName->toString()}' already exists. Please specify another." );
			}
		}

		/* Setup the inputArray to be added to this->_inputArray */
		$tmpInputArray	= array(	'inputType'	=> $inputType->toString(),
						'inputName'	=> $inputName->toString() );
		
		/* Check to see if there is a default value for the input. */
		if( $inputDefault !== null ){
			$tmpInputArray['inputDefault']	= $inputDefault->toString();
		}
			
		$this->_inputArray[] = $tmpInputArray;
	}

	/* Loop through and look for the inputName, if it is found, don't add it. */
	public function delInput( Safe $inputName ){

		/* Create a temporary array that will replace this->_inputArray. Also create tmp var to check if removed. */
		$tmpClassInputArray	= array();
		$removed		= false;

		foreach( $this->_inputArray as $currentInputArray ){
			if( $currentInputArray['inputName'] !== $inputName->toString() ){
				$tmpClassInputArray[]	= $currentInputArray;
			}else{
				$removed = true;
			}
		}
		
		if( !$removed ){
			throw new Exception( "Could not find input with the input name of '{$inputName->toString()}'" );
		}

		$this->_inputArray	= $tmpClassInputArray;
	}

	/* Add an output. */
	public function addOutput( Safe $outputType = null, Int $position = null ){
		/* Allow for a null outputType. */
		if( $outputType == null ){
			$outputType = Safe( "" );
		}

		/* Check to make sure the output position is not already taken.. (if specified) */
		if( $position !== null && isset( $this->_outputArray[$position] ) ){
			throw new Exception( "The output position '$position' is already taken." );
		}

		if( $position == null ){
			$this->_outputArray[]	= $outputType->toString();
		}else{
			$this->_outputArray[$position]	= $outputType->toString();
		}
	}

	/* Remove an output. */
	public function delOutput( Safe $outputType = null, Int $position = null ){
		
		/* Allow delOutput to be called without any arguments.. if only one output is already defined. */
		if( $outputType == null && count( $this->_outputArray ) == 1 ){
			array_pop( $this->_outputArray );
			return;
		}elseif( $outputType == null ){
			throw new Exception( "delOutput cannot take a null outputType, count(outputArray) != 1." );
		}

		/* Check to see if position was specified.. and outputType and position match.. */
		if( $position !== null && $this->_outputArray[$position] !== $outputType->toString() ){
			throw new Exception( "The output type and output position you are trying to remove do not match." );
		}

		/* If no position was specified, simply pop the last output off of the this->_outputArray */
		if( $position == null ){
			array_pop( $this->_outputArray );
		}else{
			/* Create a temporary array to replace this->_outputArray.. */
			$tmpClassOutputArray	= array( );
			/* Loop through the current array, don't add the position specified. */
			for( $x=0; $x<count( $this->_outputArray ); $x++ ){
				if( $x !== $position ){
					$tmpClassOutput[] = $this->_outputArray[$x];
				}
			}
			
			$this->_outputArray	= $tmpClassOutput;
		}
	}

	/* Display a nice output of what the code will be.. */
	public function makeFunction( ){
		return parent::debugNode();
	}
};

?>
