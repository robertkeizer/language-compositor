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
		<script type='text/javascript' src='include/jquery-corner.js'></script>
		<script type='text/javascript'>
			$(document).ready( function( ){
				// Set the compositor HTML to be null, since otherwise it displays an error message about javascript.
				$('#compositor').html( "" );
				// Setup the accordion inside the right hand text block.
				$('#accordion').accordion({ header: "div.accordion_head" });
				// Round the corner of the accordion, and all the children in it.
				$('#accordion').corner( );
				$('#accordion').children( ).children( ).each( function( child ){
					$(this).corner( );
				} );
			} );
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
								PHP Class<br />
								PHP Function
							</div>
						</div>
						<div>
							<div class='accordion_head'>Editing</div>
							<div>
								Remove node<br />
								Connector<br />
								Remove Connector
							</div>
						</div>
					</div>
				</p>
			</div>
			<div id='compositor'>
				You do not appear to have javascript enabled. Please enable it to utilize language-compositor.
			</div>
		</div>
	</body>
</html>
