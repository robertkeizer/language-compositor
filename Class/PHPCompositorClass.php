<?php

class PHPCompositorClass extends CompositorClass {
	
	public function makeNode( ){
		$returnString = "class {$this->_title}{\n";

		/* Run through all the variables defined.. */
		foreach( $this->_variableArray as $tmpVarArray ){
			if( $tmpVarArray['varType'] !== null ){
				$returnString .= "{$tmpVarArray['varType']} ";
			}
			$returnString .= "\${$tmpVarArray['varName']}";
			if( $tmpVarArray['varDefault'] !== null ){
				$returnString .= " = {$tmpVarArray['varName']}";
			}
			$returnString .= ";\n";
		}

		foreach( $this->_functionArray as $fn ){
			$returnString .= $fn->makeFunction();
		}
		$returnString .= "};\n";
		return $returnString;
	}

};

?>
