<?php
	
	header('Content-type: image/png');
	
	$width = 180;
	$height = 60;
	
	// Creating image identifier of size width by height
	$image = @imagecreatetruecolor($width, $height) or die('Cannot Initialize new GD image stream');		
		
	if($image != false){
		// Setting up a white background colour for captcha
		
		// imagecolorallocate allocates a colour for an image
		$background_colour = imagecolorallocate($image,255,255,255);
		
		// applying white colour to image background. imagefill performs a flood fill on an image with specified starting x and y coordinates and the colour to be applied
		imagefill($image,0,0,$background_colour);
		
		// Setting colours for lines to be used for distortion and text displayed
		$line_colour = imagecolorallocate($image,128,128,128);								// gray
		$text_colour_black = imagecolorallocate($image,0,0,0);									
		$text_colour_red = imagecolorallocate($image,255,0,0);
		$text_colour_blue = imagecolorallocate($image,0,0,255);
		$text_colour_green = imagecolorallocate($image,0,128,0);
		
		
		// draw lines of various randomly generated thickness on image
		$num_lines = 6;
		
		for($x=1;$x<=$num_lines;$x++){
			
			imagesetthickness($image, mt_rand(1,3));
			
			$line_choice = mt_rand(1,2);
			
			if($line_choice == 1){
				// line from top to bottom
				imageline($image, mt_rand(0,$width), 0, mt_rand(0,$width), $height, $line_colour);
			}
			else{
				// line from left to right
				imageline($image, 0, mt_rand(0,$height), $width, mt_rand(0,$height), $line_colour);
			}
		}
	
		// adding random text to image
		$pot = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyz";					// all possible characters to display
		$answer = "";																			// holds the correct captcha display to be stored in session
		
		
		for($x=20;$x<=150;$x=$x+30){
			$chosen_one = $pot[mt_rand(0,strlen($pot)-1)];
			$answer .= $chosen_one;
			
			// generate a random font size
			$font_size = mt_rand(16,20);
			
			// store various fonts to be used
			$fonts = array("fonts/arial.ttf","fonts/ariali.ttf","fonts/arialbi.ttf","fonts/times.ttf","fonts/timesi.ttf","fonts/timesbi.ttf","fonts/verdana.ttf","fonts/verdanai.ttf","fonts/verdanaz.ttf");
				
			// generate a random colour
			$text_colour_choice = mt_rand(1,4);
			if($text_colour_choice == 1){
				$text_colour = $text_colour_black;
			}
			
			else if($text_colour_choice == 2){
				$text_colour = $text_colour_blue;
			}
			
			else if($text_colour_choice == 3){
				$text_colour = $text_colour_red;
			}
			
			else{
				$text_colour = $text_colour_green;
			}
			
			$yPos = mt_rand(18,55);
			
			imagettftext($image,$font_size,mt_rand(-30,30),$x,$yPos,$text_colour,$fonts[array_rand($fonts)],$chosen_one);		
		}
		
		session_start();
		
		$_SESSION["captcha"] = crypt($answer);
		
		
		imagepng($image);						
		imagedestroy($image);
	}
	
	else{
		$_SESSION["errors"] = "Error loading captcha\n";
	}	
?>