<?php
include './config.php';

$phpPersonConstructorFN	= new PHPFunctionNode( Safe( "__constructor" ), Safe( "public" ) );
$phpPersonConstructorFN->addInput( null, Safe( "firstName" ), null );
$phpPersonConstructorFN->addInput( null, Safe( "lastName" ), null );
$phpPersonConstructorFN->setBody( Safe( "\$this->_firstName = \$firstName; \$this->_lastName = \$lastName;" ) );

$phpPersonHelloFN	= new PHPFunctionNode( Safe( "hello" ), Safe( "public" ) );
$phpPersonHelloFN->addOutput( );
$phpPersonHelloFN->setBody( Safe( "echo \"Hello {\$this->_firstName} {\$this->_lastName}\";" ) );

echo $phpPersonConstructorFN->debugNode();
echo $phpPersonHelloFN->debugNode();
?>
