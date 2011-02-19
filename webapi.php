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
	case "addinput":
		/* Make sure all the required fields are set.. namely nodename and inputname */
		$nodename	= Safe( @$_REQUEST['nodename'] );
		$inputname	= Safe( @$_REQUEST['inputname'] );

		/* Exit if either is null. */
		if( $nodename->isNull() || $nodename->toString() == null || $inputname->isNull() || $inputname->toString() == null ){
			echo 'nodename and inputname must both be specified using addinput. ('.$nodename->toString().') ('.$inputname->toString().')';
			exit;
		}

		$inputtype	= Safe( @$_REQUEST['inputtype'] );
		$inputdefault	= Safe( @$_REQUEST['inputdefault'] );

		$found = false;

		/* Go through each $_SESSION['nodes'] to see if the title matches, if so add the input. */
		foreach( $_SESSION['nodes'] as $node ){
			if( $node->getTitle() == $nodename->toString() ){
				try{
					$node->addInput( $inputtype, $inputname, $inputdefault );
				}catch( Exception $e ){
					echo "Fatal error: {$e->getMessage()}";
					exit;
				}
				$found = true;
			}
		}

		if( !$found ){
			echo 'No node with that name.';
			exit;
		}

		echo 'okay';
		break;
	case "generate_code":

		if( !isset( $_SESSION['language'] ) ){
			echo "Language must be specified first.";
			exit;
		}

		/* Loop through to make sure the language is set correctly.. and all the blocks match */
		$bad	= false;
		foreach( $_SESSION['nodes'] as $node ){
			if( $node->getLang( ) !== $_SESSION['language'] ){
				$bad = true;
				echo "One or more of the blocks on the screen are not the same langauge. ( {$node->getTitle()} has language of '{$node->getLang()}' instead of '{$_SESSION['language']}' ).";
				exit;
			}
		}

		/* If the language specification is correct, show all the nodes. */
		if( !$bad ){
			foreach( $_SESSION['nodes'] as $node ){
				echo $node->makeNode( );
			}
		}

		break;
	case "debugNodes":
		echo var_dump( $_SESSION['nodes'] );
		break;
	default:
		echo "This is webapi.php for language-compositor. See the documentation for more information.";
		exit;
}
?>
