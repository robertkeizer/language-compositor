<?php
include './config.php';

$randomPHPFN	= new PHPFunctionNode( Safe( "foobar" ), Safe( "public" ) );
$randomPHPFN->addInput( Safe( "int" ), Safe( "x" ), null );
$randomPHPFN->addInput( null, Safe( "y" ), null );
$randomPHPFN->setBody( Safe( "return (\$x^\$y)*\$x;" ) );
$randomPHPFN->addOutput( );

echo $randomPHPFN->debugNode( )."\n";
echo $randomPHPFN->makeFunction( )."\n\n";
?>
