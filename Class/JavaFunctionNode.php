<?php

class JavaFunctionNode extends FunctionNode{
	
	/* Define addInput, as inputType must be defined, but defaults are optional. */
	public function addInput( Safe $inputType, Safe $inputName, Safe $inputDefault = null ){
		parent::addInput( $inputType, $inputName, $inputDefault );
	}

	/* Define addOutput as java only has one ouput. */
	public function addOutput( Safe $outputType = null, int $position = null ){
		if( count( $this->_outputArray ) >= 1 ){
			throw new Exception( "Java can only handle one output at a time." );
		}
		parent::addOutput( $outputType, $position );
	}

	function makeFunction( ){
		/* Make sure only one output is defined.. void otherwise. */
		if( count( $this->_outputArray ) !== 1 ){
			$this->_outputArray[] = "void";
		}

		$returnString	= "{$this->_outputArray[0]} {$this->_title}( ";
		for( $x=0; $x<count( $this->_inputArray ); $x++ ){
			$returnString .= "{$this->_inputArray[$x]['inputType']} {$this->_inputArray[$x]['inputName']}";
			if( isset( $this->_inputArray[$x]['inputDefault'] ) ){
				$returnString .= " = {$this->_inputArray[$x]['inputDefault']}";
			}

			if( count( $this->_inputArray )-1 !== $x ){
				$returnString .= ", ";
			}
		}
		$returnString .= " ){ ";
		$returnString .= $this->_body;
		$returnString .= " }";

		return $returnString;
	}
};

?>
