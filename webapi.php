<?php
include './config.php';

/* Define the function variable. */
$function	= Safe( @$_REQUEST['function'] );

switch( $function->toString() ){
	case "setlanguage":
		$language		= Safe( @$_REQUEST['language'] );
		if( $language->isNull() || $language->toString() == null ){
			echo "You need to specify a language";
			exit;
		}

		$_SESSION['language']	= $language->toString();
		echo "okay";
		break;
	case "reset":
		session_destroy( );
		echo "okay";
		break;
	case "addnode":
		$nodeType = Safe( @$_REQUEST['nodetype'] );
		/* Very nodetype is specified. */
		if( $nodeType->isNull() || $nodeType->toString() == "" ){
			echo "A node type must be specified.";
			exit;
		}
		/* Verify nodetype is valid. */
		if( !in_array( $nodeType->toString(), $validNodeTypes ) ){
			echo "Invalid node type specified. ( {$nodeType->toString()} ).";
			exit;
		}
		/* Verify nodetitle exists. */
		$nodeTitle = Safe( @$_REQUEST['nodetitle'] );
		if( $nodeTitle->isNull() || $nodeTitle->toString() == null ){
			echo "Node title must be specified if function is addnode.";
			exit;
		}
		/* Create tmpNodeType as a string so that it can be used as a class name. */
		$tmpNodeType	= $nodeType->toString();
		/* Create the object.. */
		$tmpNodeObj	= new $tmpNodeType( $nodeTitle );
		/* Append it to _SESSION['nodes'] */
		$_SESSION['nodes'][]	= $tmpNodeObj;
		echo "okay";
		break;
	case "delnode":
		$nodeTitle = Safe( @$_REQUEST['nodehash'] );
		if( $nodeHash->isNull() || $nodeHash->toString() == null ){
			echo "You must specify the node hash when trying to delete a node.";
			exit;
		}
		/* Define a temporary array to house nodes */
		$tmpNodeArray	= array( );
		/* Define a boolean to check if we found it */
		$found = false;
		/* Check to make sure that node is actually defined in _session['nodes'] */
		foreach( $this->_SESSION['nodes'] as $node ){
			if( $node->getHash() == $nodeHash->toString() ){
				$found	= true;
				break;
			}else{
				$tmpNodeArray[]	= $node;
			}
		}
		/* Make sure the node was found.. if not exit with an error. */
		if( !$found ){
			echo "Could not find node with hash '{$nodeHash->toString()}'";
			exit;
		}

		/* Overwrite the $_SESSION['nodes'] with our temporary variable */
		$_SESSION['nodes']	= $tmpNodeArray;
		echo "okay";
		break;
	case "debugNodes":
		echo var_dump( $_SESSION['nodes'] );
		break;
	default:
		echo "This is webapi.php for language-compositor. See the documentation for more information.";
		exit;
}
?>
