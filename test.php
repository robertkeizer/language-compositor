<?php
include './config.php';

$addTwoFunctionNode	= new FunctionNode( Safe( "addTwo" ) );
$addTwoFunctionNode->addInput( Safe( "int" ), Safe( "x" ), Safe( "5" ) );
$addTwoFunctionNode->addOutput( Safe( "int" ) );
$addTwoFunctionNode->addOutput( Safe( "char" ) );
$addTwoFunctionNode->setBody( Safe( "return \$x+2, 'c';" ) );

echo "\n".$addTwoFunctionNode->makeFunction( )."\n";

$randomPHPFN	= new PHPFunctionNode( Safe( "foobar" ) );
$randomPHPFN->addInput( Safe( "int" ), Safe( "x" ), null );
$randomPHPFN->addInput( null, Safe( "y" ), null );
$randomPHPFN->setBody( Safe( "return (\$x^\$y)*\$x;" ) );
$randomPHPFN->addOutput( );

echo $randomPHPFN->makeFunction( )."\n\n";

$someJavaFN	= new JavaFunctionNode( Safe( "sayhi" ) );
$someJavaFN->addInput( Safe( "String" ), Safe( "title" ), Safe( "null" ) );
$someJavaFN->addInput( Safe( "String" ), Safe( "name" ), Safe( "Anonymous" ) );
$someJavaFN->setBody( Safe( "return 'Hello, ' + title + \" \" + name;" ) );
$someJavaFN->addOutput( Safe( "String" ) );

echo $someJavaFN->makeFunction( )."\n";
?>
