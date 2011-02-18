<?php

class FunctionNode extends Node{
	
	/* Define the class wide inputArray. This is to avoid problems with foreach. */
	protected $_inputArray = array( );
	/* Define the class wide outputArray. This is to avoid problems with foreach. */
	protected $_outputArray = array( );

	/* Define the type of function.. ie public/private/protected.. */
	protected $_type;

	/* Overload the construct, to allow for type specification. */
	public function __construct( Safe $title, Safe $type = null ){
		if( $type !== null ){
			$this->_type	= $type->toString();
		}
		parent::__construct( $title );
	}
	
	/* Add an input to a given function node. */
	public function addInput( Safe $inputType = null, Safe $inputName, Safe $inputDefault = null ){

		/* Loop through the current inputs, make sure none have the exact same inputName. */
		foreach( $this->_inputArray as $currentInput ){
			if( $currentInput['inputName'] == $inputName->toString() ){
				throw new Exception( "Input with input name of '{$inputName->toString()}' already exists. Please specify another." );
			}
		}

		/* Check if the inputType is null or not.. append to the tmpInputArray either way. */
		if( $inputType !== null ){
			$inputType = $inputType->toString();
		}

		/* Check to see if there is a default value for the input. */
		if( $inputDefault !== null ){
			$inputDefault	= $inputDefault->toString();
		}

		/* Setup the inputArray to be added to this->_inputArray */
		$tmpInputArray	= array( );
		
		/* Set the temporary input array.. */
		$tmpInputArray['inputType']	= $inputType;
		$tmpInputArray['inputName']	= $inputName->toString();
		$tmpInputArray['inputDefault']	= $inputDefault;

		/* Append the temporary array to the class wide inputArray */
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
		if( $position == null ){
			$this->_outputArray[]	= $outputType->toString();
		}else{
			if( isset( $this->_outputArray[$position] ) ){
				throw new Exception( "The output position '$position' is already taken." );
			};
			$this->_outputArray[$position]	= $outputType->toString();
		}
	}

	/* Remove an output. */
	public function delOutput( Safe $outputType = null, Int $position = null ){
		if( $outputType !== null ){
			/* Make sure the position is specified also. */
			if( $position == null ){
				throw new Exception( "You must specify the outputType and position of that output in order to delete it." );
			}
			/* Make sure the position is valid, and the outputType matches */
			if( $this->_outputArray[$position] == $outputType->toString() ){
				/* Got through and make a new this->_outputArray without the position $position. */
				$tmpClassOutputArray	= array( );
				for( $x=0; $x<count($this->_outputArray); $x++ ){
					if( $x !== $position ){
						$tmpClassOutputArray[]	= $this->_outputArray[$x];
					}
				}
				$this->_outputArray	= $tmpClassOutputArray;
			}else{
				throw new Exception( "Either an invalid position was specified, or the outputTypes do not match." );
			}

		}else{
			if( count( $this->_outputArray ) !== 1 ){
				throw new Exception( "You must specify an outputType unless there is only 1 output specified." );
			}

			array_pop( $this->_outputArray );
			return;
		}
	}

	/* Display a nice output of what the code will be.. */
	public function makeFunction( ){
		/* This is the abstract function.. although not actually abstract. Do not do anything language specific. */
		return parent::debugNode();
	}
};

?>
