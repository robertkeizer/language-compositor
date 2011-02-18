<?php

class Connector {
	
	protected $_startingFunction;
	protected $_startingFunctionOutputType;
	protected $_startingFunctionOututPosition;

	protected $_endingFunction;
	protected $_endingFunctionOutputType;
	protected $_endingFunctionOutputPosition;
	
	public function __construct( FunctionNode $startingFunction, Safe $startingFunctionOutputType, $startingFunctionOutputPosition, FunctionNode $endingFunction, Safe $endingFunctionInputType, $endingFunctionInputPosition ){
		$this->_startingFunction		= $startingFunction;
		$this->_startingFunctionOutputType	= $startingFunctionOutputType;
		$this->_startingFunctionOutputPosition	= $startingFunctionOutputPosition;

		$this->_endingFunction			= $endingFunction;
		$this->_endingFunctionInputType		= $endingFunctionInputType;
		$this->_endingFunctionInputPosition	= $endingFunctionInputPosition;
	}

};

?>
