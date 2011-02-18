<?php
include './config.php';

$randomPHPFN	= new PHPFunctionNode( Safe( "foobar" ), Safe( "public" ) );
$randomPHPFN->addInput( Safe( "int" ), Safe( "x" ), null );
$randomPHPFN->addInput( null, Safe( "y" ), null );
$randomPHPFN->setBody( Safe( "return (\$x^\$y)*\$x;" ) );
$randomPHPFN->addOutput( );

$anotherPHPFN	= new PHPFunctionNode( Safe( "barfoo" ), Safe( "public" ) );
$anotherPHPFN->addInput( Safe( "int" ), Safe( "a" ), null );
$anotherPHPFN->addInput( Safe( "int" ), Safe( "b" ), null );
$anotherPHPFN->setBody( Safe( "return \$a+\$b;" ) );
$anotherPHPFN->addOutput( );

$myConnector	= new Connector( $randomPHPFN, Safe( "int" ), 0, $anotherPHPFN, Safe( "int" ), 0 );

$myCompositorClass	= new PHPCompositorClass( Safe( "EncompassingClass" ) );
$myCompositorClass->addFunction( $randomPHPFN );
$myCompositorClass->addFunction( $anotherPHPFN );
$myCompositorClass->addConnector( $myConnector );

echo $myCompositorClass->debugNode();
echo $myCompositorClass->makeClass();

?>
