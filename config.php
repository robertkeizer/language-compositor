<?php

$classPath	= "Class/";

/* Load classes when they are needed, don't require them all. */
function __autoload( $className ){
	global $classPath;
	if( $className !== 'Safe' ){
		$safeClassName	= Safe( $className );
		if( file_exists( $classPath.$safeClassName->toDir().'.php' ) ){
			include $classPath.$safeClassName->toDir().'.php';
		}else{
			throw new Exception( "Could not find class '{$safeClassName->toException()}' will most likely die horribly." );
		}
	}else{
		include $classPath.'Safe.php';
	}
};

/* Wrapper for the Safe class. */
function Safe( $unsafe ){
	return new Safe( $unsafe );
};

?>
