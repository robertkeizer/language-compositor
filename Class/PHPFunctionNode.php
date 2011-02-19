<?php

class PHPFunctionNode extends FunctionNode{

	/* Make sure addOutput functions correctly for PHP spec.. ie only one output. */
	public function addOutput( Safe $outputType = null, $position = null ){
		if( $outputType == null ){
			$outputType = Safe( '' );
		}

		if( $position !== null && $position !== 0 ){
			throw new Exception( "You may not specify a position for an output in PHP. Either do not pass one, or use '0'." );
		}

		if( count( $this->_outputArray ) > 0 ){
			throw new Exception( "In PHP, you can only have one output." );
		}
		
		parent::addOutput( $outputType, null );
	}

	/* makeNode should have $'s in input vars..PHP also cant do return type hinting..  */
	public function makeNode( ){

		/* Start the returnString */
		$returnString	= "";
	
		/* Check if the type is defined - ie public/private/protected */
		if( isset( $this->_type ) ){
			$returnString .= "{$this->_type} ";
		}

		/* Append the function functionName( */
		$returnString	.= "function {$this->_title}( ";

		/* Loop through the this->_inputArray and produce the input args.. */
		for( $x=0; $x<count( $this->_inputArray ); $x++ ){

			/* Show the variable type if specified.. */
			if( $this->_inputArray[$x]['inputType'] !== "" ){
				$returnString .= "{$this->_inputArray[$x]['inputType']} ";
			}
			
			/* Show the variable name. Include a $ infront since this is PHP */
			$returnString .= "\${$this->_inputArray[$x]['inputName']}";

			/* If there is a default set, set it now. */
			if( isset( $this->_inputArray[$x]['inputDefault'] ) && $this->_inputArray[$x]['inputDefault'] !== "" ){
				$returnString .= " = {$this->_inputArray[$x]['inputDefault']}";
			}
			
			/* Append a comma to the end of each iteration of this->_inputArray, if it isn't the last one. */
			if( count( $this->_inputArray )-1 !== $x ){
				$returnString .= ", ";
			}
		}
		
		/* Close the function argument list. Append the body, and the end. */
		$returnString .= " ){ ";
		$returnString .= $this->_body;
		$returnString .= " };\n";
		
		return $returnString;	
	}

	public function getLang( ){
		return "PHP";
	}
};

?>
