<?php
class Image
{
	/**
	 * @param string form_field - The HTML form field name to check
	 * @param string upload_path - Image uploading path
	 * @param string image_name - Name for the saving image file
	 * @param string width - width for the resizing image
	 * @param string height - height for the resizing image
	 */
	function upload_image($form_field, $upload_path, $image_name, $width, $height)
	{
		//image upload
		if(isset($_FILES[$form_field]))
		{
			//get uploading file's extention
			$extention=strtolower($_FILES[$form_field]["type"]);
			
			$exp_del = "."; //end delimiter
			$file_name = $_FILES[$form_field]["name"];
			$file_name = explode($exp_del, $file_name);
			$extention = strtolower(end($file_name));
			
			//validate uploading file
			$validate=$this->validate_uploading_file($form_field, $extention);
			
			if($validate)
			{
				//build path if does not exists
				if(!is_dir($upload_path)){ mkdir($upload_path, 0755); }
				
				//here you can use two types of methods to resize image
				//first one is resize image to the aspect ratio
				//second one is crop image to the provided width and height
				//you can use one of the following two methods to perform above operations
				
				//resize image and save
				$this->create_thumb($_FILES[$form_field]["tmp_name"], $upload_path.$image_name, $width, $height, $extention);
				
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param string path_to_image - Path for the source image
	 * @param string path_to_thumb - Path for the saving image
	 * @param string thumb_width - New width for the saving image
	 * @param string thumb_height - New height for the saving image
	 * @param string extension - image file's extension
	 */
	function create_thumb($path_to_image, $path_to_thumb, $thumb_width, $thumb_height, $extention)
	{
		$thumb_width=intval($thumb_width);
		$thumb_height=intval($thumb_height);
		
		$x1_source=0;
		$y1_source=0;
		
		//get uploading image's width and height
		list($width, $height, $img) = $this->get_image_width_height($extention, $path_to_image);
		
		//resize image for the aspect ratio
		if($width > $height)
		{
			if($thumb_height>$thumb_width)
			{
				$new_width=$width;
				$new_height=floor($new_width*($thumb_height/$thumb_width));
				
				$y1_source=floor(($height-$new_height)/2);
			}
			else
			{
				$new_height=$height;
				$new_width=floor($new_height*($thumb_width/$thumb_height));
				
				$x1_source=floor(($width-$new_width)/2);
			}
		}
		else
		{
			if($thumb_height>$thumb_width)
			{
				$new_height=$height;
				$new_width=floor($new_height*($thumb_width/$thumb_height));
				
				$x1_source=floor(($width-$new_width)/2);
			}
			else
			{
				$new_width=$width;
				$new_height=floor($new_width*($thumb_height/$thumb_width));
				
				$y1_source=floor(($height-$new_height)/2);
			}
		}
		
		if($thumb_width > $width)
		{
			$thumb_width=$width;
			$new_width=$width;
			
			$x1_source=0;
		}
		else
		{
			$x1_source=floor(($width-$new_width)/2);
		}
		
		if($thumb_height > $height)
		{
			$thumb_height=$height;
			$new_height=$height;
			
			$y1_source=0;
		}
		else
		{
			$y1_source=floor(($height-$new_height)/2);
		}
		
		$tmp_img=$this->create_temp_image($thumb_width, $thumb_height);
		
		// copy and resize old image into new image
		imagecopyresampled($tmp_img, $img, 0, 0, $x1_source, $y1_source, $thumb_width, $thumb_height, $new_width, $new_height);
		
		$this->save_image($extention, $path_to_thumb, $tmp_img);
	}
	
	/**
	 * @param string extension - Width for the temporary image
	 * @param string height - Height for the temporary image
	 */
	function get_image_width_height($extension, $path_to_image)
	{
		$extension=strtolower($extension);
		
		// load image and get image size
		if($extension == "jpg" || $extension == "jpeg")
		{
			$img = imagecreatefromjpeg($path_to_image);
		}
		else if( $extension == "gif")
		{
			$img = imagecreatefromgif($path_to_image);
		}
		else if( $extension == "png")
		{
			$img = imagecreatefrompng($path_to_image);
		}
		
		$width = imagesx($img);
		$height= imagesy($img);
		
		return array($width, $height, $img);
	}
	
	/**
	 * @param string width - Width for the temporary image
	 * @param string height - Height for the temporary image
	 */
	function create_temp_image($width, $height)
	{
		// create a new temporary image
		$tmp_img = imagecreatetruecolor($width, $height);
		
		//making a transparent background for image
		imagealphablending($tmp_img, false);
		$color_transparent = imagecolorallocatealpha($tmp_img, 0, 0, 0, 127);
		imagefill($tmp_img, 0, 0, $color_transparent);
		imagesavealpha($tmp_img, true);
		
		return $tmp_img;
	}
	
	/**
	 * @param string extension - image file's extension
	 * @param string path - Path for the image which should be uploaded
	 * @param string tmp_img - Temporary image which was created using GD libarary
	 */
	function save_image($extension, $path, $tmp_img)
	{
		$extension=strtolower($extension) ;
		
		// save thumbnail into a file
		if( $extension == "jpg" || $extension == "jpeg" )
		{
			imagejpeg( $tmp_img, $path, 100 );
		}
		else if( $extension == "gif")
		{
			imagegif( $tmp_img, $path, 100 );
		}
		else if( $extension == "png")
		{
			imagepng( $tmp_img, $path, 9 );
		}
	}
	
	/**
	 * @param string $field - The HTML form field name to check.
	 * @param string extension - image file's extension
	 */
	function validate_uploading_file($field, $extension)
	{
		//assume uploading file is not a valid image
		$match_found=false;
		
		//set valid file types and extensions for image upload
		$file_types=array();

		$file_types[]=array("type" => "image/jpeg", "ext" => "jpg");
		$file_types[]=array("type" => "image/png", "ext" => "png");
		$file_types[]=array("type" => "image/jpg", "ext" => "jpg");
		$file_types[]=array("type" => "image/gif", "ext" => "gif");

		foreach($file_types as $file_type)
		{
			$this_file_type=strtolower($_FILES[$field]["type"]);
			
			if($this_file_type == strtolower($file_type["type"]) && $extension == strtolower($file_type["ext"]))
			{
				$match_found=true;
				break;
			}
		}
		
		return $match_found;
	}
	
	/**
	 * @param string path_to_image - Path for the source image
	 */
	function is_valid_image($path_to_image)
	{
		//assume uploading file is not a valid image
		$valid = false;
		
		//check if file exists
		if(@file_exists($path_to_image))
		{
			try{
				//validate uploading file
				$image_size = getimagesize($path_to_image);
				
				if(isset($image_size[2]) && in_array($image_size[2], array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
				{
					$valid = true;
				}
			}
			catch(Exception $e)
			{
			}
		}
		
		return $valid;
	}
}
?>