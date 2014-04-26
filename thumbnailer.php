<?php

class ThumbNailer
{
    public $save_dir;
    public $max_dims;
    public $type;

    public function __construct($save_dir, $max_dims=array(30, 30))
    {
        $this->save_dir = $save_dir;
        $this->max_dims = $max_dims;
    }

	public function makeThumb( $src )
	{
		$src = $_SERVER['DOCUMENT_ROOT'] . $src;
		$saveDirectory = $_SERVER['DOCUMENT_ROOT'] . $this->save_dir; 
	
		list($src_w, $src_h) = getimagesize($src);
		list($max_w, $max_h) = array(35, 35);
	
		if($src_w > $max_w || $src_h > $src_h)
		{	$s = ($src_w > $src_h) ? $max_w/$src_w : $max_h/$src_h;	}
		else
		{	$s = 1;	}
	
		$new_w = round($src_w * $s);
		$new_h = round($src_h * $s);
	
		$newDims = array($new_w, $new_h, $src_w, $src_h);
	
		$info = getimagesize($src);
		
		$int = 0;
		$img_ext = "";
		switch($info['mime'])
		{
			case 'image/jpeg':
			case 'image/pjpeg':
				$img_ext = '.jpg';
				$int = 1;
				break;
			case 'image/gif':
				$img_ext = '.gif';
				$int = 2;
				break;
			case 'image/png':
				$img_ext = '.png';
				$int = 3;
				break;
			default:
				$funcs = null;
				break;
		}
		
		$src_img = "";
		switch($int)
		{
			case 1:
				$src_img = imagecreatefromjpeg($src);
				break;
			case 2:
				$src_img = imagecreatefromgif($src);
				break;
			case 3:
				$src_img = imagecreatefrompng($src);
				break;
			default:
				$funcs = null;
				break;
		}
		//echo $src_img;
			//$src_img = $funcs[0]($src);
	
		$new_img = imagecreatetruecolor($new_w, $new_h);
	
		if(imagecopyresampled($new_img, $src_img, 0, 0, 0, 0, $newDims[0], $newDims[1], $newDims[2], $newDims[3]))
		{
			//imagecopy($new_img, $src_img, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
		
			$name = time() . '_' . mt_rand(1000,9999) . $img_ext;
	
			$path = $saveDirectory;
			//echo $path;

        	// Checks if the directory exists
        	if(!is_dir($path))
        	{
            	// Creates the directory
            	if(!mkdir($path, 0777, TRUE))
            	{
                	// On failure, throws an error
                	throw new Exception("Can't create the directory!");
            	}
        	}
    		//$absolute = $saveDirectory;
			// Create the full path to the image for saving
			$filepath = $saveDirectory . $name;
	
	
			if($int == 1)
			{
				if($new_img && imagejpeg($new_img, $filepath))
				{
					imagedestroy($new_img);
				}
				else
				{
					throw new Exception('Failed to save the new image!');
				}
			}
			if($int == 2)
			{
				if($new_img && imagegif($new_img, $filepath))
				{
					imagedestroy($new_img);
				}
				else
				{
					throw new Exception('Failed to save the new image!');
				}
			}
			if($int == 3)
			{
				if($new_img && imagepng($new_img, $filepath))
				{
					imagedestroy($new_img);
				}
				else
				{
					throw new Exception('Failed to save the new image!');
				}
			}
		}
		else
			throw new Exception('Could not resample the image!');
		/*switch($int)
		{
			case 1:
				imagejpeg($new_img, $filepath);
				break;
			case 2:
				imagegif($new_img, $filepath);
				break;
			case 3:
				imagepng($new_img, $filepath);
				break;
			default:
				$int = 4;
				break;
		}*/
		
		//$funcs[1]($new_img, $filepath);
	
        //copy($new_img, '/quasar/thumbNails/');
	
		//imagedestroy($new_img);
	
		// Store the absolute path to move the image
		//$pic = formatImage($filepath, $imageName);
	
		return $this->save_dir . $name;
	
	
	
	}

}

?>