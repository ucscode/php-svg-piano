<?php 

/***************************************************
	
	PHPSVGPiano;
	Render Piano Layout in SVG;
	
	Copyright (c) 2023
	Created By UCSCODE
	
	Author: Uchenna Ajah
	URL: https://ucscode.me
	
****************************************************/

class PHPSVGPiano {
	
	/************* Public Properties ***********/
	
	// width of 1 octave
	public $octave_width = 400;
		
	// height of piano
	public $piano_height = 120;
		
	// number of octaves
	public $octaves = 1;
	
	
	/************* Private Properties ***********/
	
	private $white_key_width;
	private $black_key_width;
	
	private $white_key_height;
	private $black_key_height;
	
	private $piano_width;
	
	private $music_notes = array( "C", "D", "E", "F", "G", "A", "B" );
	
	private $sharp_notes = array( "C+", "D+", "F+", "G+", "A+" );
	private $flat_notes = array( "D-", "E-", "G-", "A-", "B-" );
	
	private $replacement = array(
		"E+" => "F",
		"F-" => "E",
		"B+" => "C",
		"C-" => "B"
	);
	
	private $play;
	
	private $octave_range = [];
	
	private $notes_in_octave = array();
	
	// The Y position of the element;
	
	private $y = 0;
	
	// Arrange title 
	
	private $title_size = 34;
	private $margin_bottom = 20;
	
	/*********** Methods ****************/
	
	private $canvas;
	private $svgname;
	
	public function __construct( ?string $name = null ) {
		$this->svgname = $name;
	}
	
	private function configure() {
		
		// prepare piano for drawing;
		
		$this->white_key_width = $this->octave_width / count($this->music_notes);
		$this->black_key_width = $this->octave_width / (count($this->music_notes) + count($this->sharp_notes));
		
		$this->white_key_height = $this->piano_height;
		$this->black_key_height = $this->white_key_height * ( 60 / 100 );
		
		$this->octaves = (int)$this->octaves;
		$this->piano_width = $this->octave_width * $this->octaves;
		
		if( empty($this->octave_range) ) $this->octave_range[] = 4;
		
	}
	
	
	/****** Draw the black keys ******/
	
	private function set_black_keys( $octave, $position, $group ) {
		
		// get the notes played in the octave;
		$octave_notes = $this->notes_in_octave[ $octave - 1 ] ?? [];
		
		$middle = $this->black_key_width / 2;
		
		$index = 0; // the index of accidental note;
		
		foreach( $position as $key => $white_key_axis ) {
			
			if( in_array($key, ['C', 'F']) ) continue;
			
			$note_color = 'black';
			
			$black_key_axis = $white_key_axis - $middle; // align black note between white keys;
			
			$note = null;
			$sharp = $this->sharp_notes[ $index ];
			$flat = $this->flat_notes[ $index ];
			
			if( !empty($octave_notes) ) {
				// check if the octave contains sharp or flat note;
				if( in_array($sharp, $octave_notes['notes']) ) $note = $sharp;
				elseif( in_array($flat, $octave_notes['notes']) ) $note = $flat;
				if( $note ) {
					$touch = !!($note_color = '#efd235');
				} else $touch = false;
			} else $touch = false;
			
			if( empty($note) ) $note = $sharp;
			
			// replace + with sharp sign; replace - with flat sign;
			
			$note = str_replace(
				["+", "-"],
				["#", "b"],
				$note
			);
			
			$class = null;
			
			$text_x_axis = $black_key_axis + ( $this->black_key_width * (20 / 100) );
			$text_y_axis = ( $this->black_key_height - ( $this->black_key_height * (25 / 100) ) ) + $this->y;
			
			if( $touch ) {
				$text_color = 'white';
				$class = 'touched';
			} else $text_color = 'transparent';
			
			$index++;

			$this->canvas .= "<rect fill='{$note_color}' stroke='black' x='{$black_key_axis}' y='{$this->y}' width='{$this->black_key_width}' height='{$this->black_key_height}' class='{$class}' /> <text x='{$text_x_axis}' y='{$text_y_axis}' fill='{$text_color}' class='{$class}'>{$note}</text> ";
			
		}
		
	}
	
	
	/****** Draw the white keys ******/
	
	private function set_white_keys( $octave, $group ) {
		
		// get the x-axis of the octave;
		$octave_point = $this->octave_width * ($octave - 1);
		
		// get the notes played in the octave;
		$octave_notes = $this->notes_in_octave[ $octave - 1 ] ?? [];
		
		$position = array();
		
		for( $x = 0; $x < count($this->music_notes); $x++ ) {
			
			$note_color = "white";
			
			$note = $this->music_notes[ $x ]; // name of music note;
			
			$x_point = $x * $this->white_key_width; // the x-axis of the white key;
			
			$white_key_axis = $octave_point + $x_point; // shift the x-axis position to align with it's octave;
			
			$position[ $note ] = $white_key_axis;
			
			if( !empty($octave_notes) ) {
				// check if the current note is played
				$touch = ( in_array($note, $octave_notes['notes']) ) ? !!($note_color = "bisque") : false;
			} else $touch = false;
			
			$text_x_axis = $white_key_axis + ( $this->white_key_width * (30 / 100) );
			$text_y_axis = ( $this->white_key_height - ( $this->white_key_height * (15 / 100) ) ) + $this->y;
			
			$class = null;
			
			if( !$touch ) {
				$text_color = ( $note == 'C' ) ? '#d5d4d4' : 'transparent';
			} else {
				$text_color = '#4e4b4b';
				$class = 'touched';
			}
			
			if( $note == 'C' ) $note .= $group;
			
			$this->canvas .= "<rect fill='{$note_color}' stroke='black' x='{$white_key_axis}' y='{$this->y}' width='{$this->white_key_width}' height='{$this->white_key_height}' class='{$class}' /> <text x='{$text_x_axis}' y='{$text_y_axis}' fill='{$text_color}' class='{$class}'>{$note}</text> ";
			
		}
		
		return $position;
		
	}
	
	
	/******** The notes to touch on the piano ***********/
	
	private function play( ?string $notes ) {
		
		$this->reset();
		
		// validate notes;
		$notes = array_map('strtoupper', array_map("trim", explode(",", $notes ?? '')));
		$regex = '/^[A-G](?:\-|\+)?(?:\d{1,2})?$/';
		$notes = preg_grep($regex, $notes);
		
		$octave_notes = array(); // prepare notes that should be in a set of octave;
		
		foreach( $notes as $key => $note ) {
			
			// set default octave to 4;
			if( !is_numeric(substr($note, -1)) ) $notes[$key] = $note = ( $note . "4" );
			
			// split notes into "note => octave";
			$interval = preg_split('/(?<=[A-G\-\+])(?=[0-9]+)/i', $note);
			$octave = $interval[1] = (int)$interval[1];
			
			if( in_array($interval[0], array_keys($this->replacement)) ) {
				$interval[0] = $this->replacement[ $interval[0] ];
				if( $interval[0] == "C" ) $interval[1]++;
				elseif( $interval[0] == "B" ) $interval[1]--;
				$notes[$key] = $note = implode("", $interval);
				$octave = $interval[1];
			};
			
			// capture the octave;
			$this->octave_range[] = $octave;
			
			// add to notes in octave;
			if( !isset($octave_notes[$octave]) ) $octave_notes[$octave] = array();
			$octave_notes[$octave][] = $interval[0];
			
		};
		
		// get the range of octaves;
		if( !empty($this->octave_range) ) {
			$range = $this->octave_range;
			$this->octave_range = range( min($range), max($range) );
		};
		
		// save the notes;
		$this->play = $notes;
		
		ksort($octave_notes);
		
		foreach( $octave_notes as $octave => $notename ) {
			$this->notes_in_octave[] = array(
				"octave" => $octave,
				"notes" => $notename
			);
		};
		
		$octaves = count( $this->notes_in_octave );
		
		if( $this->octaves < $octaves ) $this->octaves = $octaves;
		
	}
	
	/*****************************************
		Reset Properties;
	******************************************/
	
	public function reset() {
		
		// reset touched values;
		$this->octave_range = $this->notes_in_octave = array();
		
		$this->octaves = 1;
		
		$this->y = 0;
		
	}
	
	/********* Draw The Piano ************/
	
	public function draw( ?string $music_notes = null, ?string $title = null, $print = true ) {
		
		$this->play( $music_notes );
		
		$this->configure();
		
		if( !empty($title) ) $this->y = (int)$this->title_size + $this->margin_bottom;

		if( empty($this->y) || $this->y <= $this->margin_bottom ) {
			$title = null;
			$this->y = 0;
		};
		
		$height = $this->piano_height + $this->y;
		
		$this->canvas = "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewbox='0 0 {$this->piano_width} {$height}' data-psvgp='{$this->svgname}'> ";
		
		if( !empty($title) ) {
			$this->canvas .= "<text x='0' y='{$this->title_size}' fill='black' font-size='{$this->title_size}px' font-family='Garamond' height='{$this->title_size}'>{$title}</text> ";
		}
			
		for( $x = 1; $x <= $this->octaves; $x++ ) {
			$octave = $this->octave_range[ $x - 1 ] ?? null;
			$position = $this->set_white_keys( $x, $octave );
			$this->set_black_keys( $x, $position, $octave );
		};

		$this->canvas .= "</svg>";
		
		$svg = $this->canvas;
		$this->canvas = null;
		
		return print_r( $svg, !$print );
	
	}
	
}



