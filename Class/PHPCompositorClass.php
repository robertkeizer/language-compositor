<?php

class PHPCompositorClass extends CompositorClass {
	
	public function makeClass( ){
		$returnString = "class {$this->_title}{\n";
		foreach( $this->_functionArray as $fn ){
			$returnString .= $fn->makeFunction();
		}
		$returnString .= "};\n";
		return $returnString;
	}

};

?>
