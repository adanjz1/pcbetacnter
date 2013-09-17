<?php
function maintainAspectRatio($FLASH_WIDTH,$image_url)
		{
		$arrImageSize = @getimagesize(trim($image_url),$arrImageSize);
		$width = $arrImageSize[0];
		$height = $arrImageSize[1];
		if($width > $FLASH_WIDTH )
			{
			$target_width = $FLASH_WIDTH;
			$target_height = round($height * ($FLASH_WIDTH/$width));
			if($target_height > 150)
				{
				$target_width = round($FLASH_WIDTH * (150/$target_height));
				$target_height = 150;
				}
				
			}
		else
			{
			$target_width = $width;
			if($height > 150)
				{
				$target_height = 150;
				$target_width = round($width * (150/$height));
				}
				else
				{
				$target_height = $height;
				}
			}
		return array("width"=>$target_width,"height"=>$target_height,"image_url"=>$image_url);
		}
		########## END method maintainAspectRatio() ##############
		
	
		##############  New Thumbnail Function   ##################
		function MakeThumbnailNewNext($file_path,$file_name,$new_width, $new_height, $orginal="")
		{
			$original_image_path=$file_path.$file_name; // the path with the file name where the file will be stored, upload is the directory name.
			$file_path=$file_path."thumbnail_next/thumb_".$file_name;
			
			$ImageArray = maintainAspectRatio($new_width, $original_image_path);
			$new_width=$ImageArray['width'];
			$new_height=$ImageArray['height'];
			
			$len = strlen($file_name); 
			$pos =strpos($file_name,"."); 
			$type = substr($file_name,$pos + 1,$len); 
			$file_type = strtolower($type);
		
			///////// Start the thumbnail generation//////////////
			if (!($file_type =="jpeg" OR $file_type=="jpg" OR $file_type=="gif" OR $file_type=="png"))
			{
				echo "Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
				exit;
			}
			/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
			if (@$file_type=="gif")
			{
				$im=ImageCreateFromGIF($original_image_path);
				$width=ImageSx($im);              // Original picture width is stored
				$height=ImageSy($im);                  // Original picture height is stored
				$newimage=imagecreatetruecolor($new_width,$new_height);
				imageCopyResized($newimage,$im,0,0,0,0,$new_width,$new_height,$width,$height);
				if (function_exists("imagegif")) 
				{
					header("Content-type: image/gif");
					ImageGIF($newimage,$file_path);
				}
				elseif (function_exists("imagejpeg")) 
				{
					header("Content-type: image/jpeg");
					ImageJPEG($newimage,$file_path);
				}
				chmod("$file_path",0777);
			}////////// end of gif file thumb nail creation//////////
			
			////////////// starting of JPG thumb nail creation//////////
			if($file_type=="jpeg" || $file_type=="jpg")
			{
				$im=ImageCreateFromJPEG($original_image_path); 
				$width=ImageSx($im);              // Original picture width is stored
				$height=ImageSy($im);             // Original picture height is stored
				$newimage=imagecreatetruecolor($new_width,$new_height);                 
				imageCopyResized($newimage,$im,0,0,0,0,$new_width,$new_height,$width,$height);
				ImageJpeg($newimage,$file_path);
				chmod("$file_path",0777);
			}
			if($file_type=="png")
			{
				$im=imagecreatefrompng($original_image_path); 
				$width=ImageSx($im);              // Original picture width is stored
				$height=ImageSy($im);             // Original picture height is stored
				$newimage=imagecreatetruecolor($new_width,$new_height);                 
				imageCopyResized($newimage,$im,0,0,0,0,$new_width,$new_height,$width,$height);
				imagepng($newimage,$file_path);
				chmod("$file_path",0777);
			}
			////////////////  End of JPG thumb nail creation //////////
		}
		##############  New Thumbnail Function   ##################
		 
?>