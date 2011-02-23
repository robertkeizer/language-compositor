<?php

class PHPFunctionNode extends FunctionNode{
	public function addOutput( Safe $outputType = null, $position = null ){
		if( count( $this->_outputArray ) > 0 ){
			throw new Exception( "In PHP you may only have one output" );
		}
		parent::addOutput( $outputType, $position );
	}
};

?>
