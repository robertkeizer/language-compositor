<?php
include './config.php';

/* Create a new instance of PHPCompositorClass, with the title of Person. Define a few variables. */
$phpPersonClass	= new PHPCompositorClass( Safe( "Person" ) );
$phpPersonClass->addVariable( Safe( "protected" ), Safe( "_firstName" ), null );
$phpPersonClass->addVariable( Safe( "protected" ), Safe( "_lastName" ), null );

/* Create the constructor function.. */
$phpPersonConstructorFN	= new PHPFunctionNode( Safe( "__constructor" ), Safe( "public" ) );
$phpPersonConstructorFN->addInput( null, Safe( "firstName" ), null );
$phpPersonConstructorFN->addInput( null, Safe( "lastName" ), null );
$phpPersonConstructorFN->setBody( Safe( "\$this->_firstName = \$firstName; \$this->_lastName = \$lastName;" ) );

/* Create a 'hello' function.. */
$phpPersonHelloFN	= new PHPFunctionNode( Safe( "hello" ), Safe( "public" ) );
$phpPersonHelloFN->addOutput( );
$phpPersonHelloFN->setBody( Safe( "echo \"Hello {\$this->_firstName} {\$this->_lastName}\";" ) );

/* Add both the functions to the class. */
$phpPersonClass->addFunction( $phpPersonConstructorFN );
$phpPersonClass->addFunction( $phpPersonHelloFN );

/* Debug and display the class. */

echo $phpPersonClass->debugNode();
echo $phpPersonClass->makeClass();
?>
