<!doctype html>
<html>
<head>
	<meta name='viewport' content='width=device-width,initial-scale=1'>
</head>
<body>
	<?php 
	
		// require the PHPSVGPiano File;
		
		require_once "PHPSVGPiano.php";
		
		// Create a new instance of the piano;
		
		$piano = new PHPSVGPiano();
		
		/**************************************
			write the musical notes that should be pressed on the piano;
			
			+ represents sharp sign E.g "G+ means G-sharp"
			
			- represents flat sign; E.g A- means A-flat;
			
			You can also append a number after each not to indicate octave.
			
			Example:
			
				C4, C5, D-5, G+6 
				
		**************************************/
		
		// Draw a piano with C Major Chord;
		
		$C_Major = "C, E, G";
		
		$piano->draw( $C_Major );
		
		echo "<hr>";
		
		// Draw a piano G Major 7th Chord;
		
		$D_Major7 = "D, F+, A, C+5";
		
		$piano->draw( $D_Major7 );
		
		/*******************************************
		
			You can also add a title to the piano diagram.
			
			Just pass the title to the 2nd parameter
			
		*******************************************/
		
		echo "<hr>";
		
		// Draw an F-Sus2 Chord with title above the piano;
		
		$F_Sus2 = "F, B-, C";
		
		$piano->draw( $F_Sus2, "F Sus2" );
	
	?>
</body>
</head>