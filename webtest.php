<?php
include './config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
	<head>
		<title>Language-Compositor</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel='stylesheet' href='include/style.css'>
		<script type='text/javascript' src='include/jquery.js'></script>
		<script type='text/javascript' src='include/jquery-ui.js'></script>
		<script type='text/javascript' src='include/jquery-widget.js'></script>
		<script type='text/javascript' src='include/jquery-mouse.js'></script>
		<script type='text/javascript' src='include/jquery-draggable.js'></script>
		<script type='text/javascript' src='include/jquery-corner.js'></script>
		<script type='text/javascript' src='include/jquery-impromptu.js'></script>
		<script type='text/javascript'>
			$(document).ready( function( ){
				// Set the compositor HTML to be null, since otherwise it displays an error message about javascript.
				$('#compositor #errormsg').html( "" );

				// Setup the accordion inside the right hand text block.
				$('#accordion').accordion({ header: "div.accordion_head", autoHeight: false });

				// Round the corner of the accordion, and all the children in it.
				$('#accordion').corner( );

				$('#accordion').children( ).children( ).each( function( child ){
					$(this).corner( );
				} );

				// Apply the mouseover feature of the hand for clickable accordion elements.
				$('#accordion .accordion_head').mouseover( function( ){
					$(this).css( 'cursor', 'pointer' );
				} );

				$('#accordion .option').mouseover( function( ){
					$(this).css( 'cursor', 'pointer' );
				} );

				// Round the current status block
				$('#current_status').corner( );
				
				// Make sure that nodes are draggable, also corner it.
				$('.node').draggable({ containment: "#canvas" }).corner( );
			} );

			function createNewNode( v, m, f ){
				$.get( 'webapi.php?function=addnode&nodetype=' + f.nodetype + '&nodetitle=' + f.title, function( data ){
					if( data !== 'okay' ){
						$.prompt( data );
					}else{
						window.location.reload();
					}
				} );
			}

			function specifyLanguage( v, m, f ){
				$.get( 'webapi.php?function=setlanguage&language=' + f.language, function( data ){
					if( data !== 'okay' ){
						$.prompt( data );
					}else{
						window.location.reload();
					}
				} );
			}

			function api( fnc, args ){
				switch( fnc ){
					case "reset":
						$.get( 'webapi.php?function=reset', function( data ){
							if( data !== 'okay' ){
								$.prompt( data );
							}else{
								window.location.reload();
							}
						} );
						break;
					case "connector":
						$.prompt( 'Add a connector..' );
						break;
					case "newnode":
						var tmpString		= '<table>'
									+ '<tr><td>Title/Name</td><td><input name="title"></td></tr>'
									+ '<tr><td>Node Type</td><td><input name="nodetype" value="' + args + '"></td></tr>'
									+ '</table>';
						$.prompt( tmpString, { callback: createNewNode } );
						break;
					case "delnode":
						$.prompt( 'Not implemented yet.' );
						break;
					case "save":
						$.prompt( 'Save the diagram..' );
						break;
					case "load":
						$.prompt( 'Load a diagram' );
						break;
					case "specify_language":
						var tmpString = "Language <input name='language' value='<?php echo $_SESSION['language']; ?>'>";
						$.prompt( tmpString, { callback: specifyLanguage } );
						break;
					case "generate_code":
						$.get( 'webapi.php?function=generate_code', function( data ){
							$('#canvas').children( 'pre' ).html( data );
						} );
						break;
					default:
						$.prompt( 'Unkown function passed' );
				}
			}
		</script>
	</head>
	<body>
		<div class='main'>
			<div id='text'>
				<p>
					This is language-compositor. Code can be found <a href='http://github.com/robertkeizer/language-compositor'>here</a>.
					A readme is available <a href='http://github.com/robertkeizer/language-compositor/blob/master/README'>here</a>.
				</p>
				<p>
					<div id='accordion'>
						<div>
							<div class='accordion_head'>Nodes</div>
							<div>
								<?php foreach( $validNodeTypes as $nodeType ){ ?>
								<span class='option' onclick="api('newnode', '<?php echo $nodeType; ?>');">Add a <?php echo $nodeType; ?></span><br />
								<?php } ?>
							</div>
						</div>
						<div>
							<div class='accordion_head'>Connectors</div>
							<div>
								<span class='option' onclick="api('connector');">Add a connector</span><br />
							</div>
						</div>
						<div>
							<div class='accordion_head'>Options</div>
							<div>
								<div class='option' onclick="api('save');">Save current diagram</div>
								<div class='option' onclick="api('load');">Load a saved diagram</div>
								<div class='option' onClick="api('reset');">Clear current diagram</div>
							</div>
						</div>
						<div>
							<div class='accordion_head'>Generate Code</div>
							<div>
								<div class='option' onclick="api('specify_language');">Specify programming langauge</div>
								<div class='option' onclick="api('generate_code');">Generate code</div>
							</div>
						</div>
					</div>
				</p>
				<p>
					<div id='current_status'>
						<div class='current_status head'>
							Current Status
						</div>
						Node Count: <?php echo count($_SESSION['nodes']); ?><br />
						Language: <?php echo $_SESSION['language']; ?><br />
					</div>
				</p>
			</div>
			<div id='compositor'>
				<div id='errormsg'>
					You do not appear to have javascript enabled. Please enable it to utilize language-compositor.
				</div>
				<div id='canvas'>
					<?php
					foreach( $_SESSION['nodes'] as $node ){
						echo "<div class='node'>";
						echo "<b>{$node->getTitle()}</b><br /><span style='font-size: 60%; font-style: italics;'>".get_class( $node )."</span><br />\n";
						echo "<hr style='width: 100%; border-color: #cccccc;' />";
						echo "<span style='font-size: 70%;'>";
						if( method_exists( $node, "getInputs" ) ){
							echo "Inputs:<br />\n";
							foreach( $node->getInputs( ) as $inputArray ){
								echo "{$inputArray['inputName']}<br />\n";
							}
						}
						if( method_exists( $node, "getOutputs" ) ){
							echo "Outputs:\n";
							foreach( $node->getOutputs( ) as $outputArray ){
								echo "{$outputArray['outputName']}<br />\n";
							}
						}
						echo "</span>";
						echo "</div>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
