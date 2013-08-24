<?php
function creat($thname,$thumbnailwidth,$thumbnailheight,$image,$type){

	if($type == '.gif'){	
	$mainimage=imagecreatefromgif($image);
	}	
	if($type == '.jpg'){	
	$mainimage=imagecreatefromjpeg($image);
	}
	if($type == '.JPG'){	
	$mainimage=imagecreatefromjpeg($image);
	}
	
	if($type == '.jpeg'){	
	$mainimage=imagecreatefromjpeg($image);
	}
	if($type == '.png'){	
	$mainimage=imagecreatefrompng($image);
	}

	$mainwidth = imagesx($mainimage);
	$mainheight = imagesy($mainimage);
    $mythumbnail = imagecreatetruecolor($thumbnailwidth,$thumbnailheight);
    imagecopyresampled($mythumbnail,$mainimage,0,0,0,0,$thumbnailwidth,$thumbnailheight,$mainwidth,$mainheight);
	
	if($type == '.gif'){	
	ImageGIF($mythumbnail,$thname,95);
	}
	if($type == '.jpg'){	
	ImageJPEG($mythumbnail,$thname,95);
	}
	
	if($type == '.JPG'){	
	ImageJPEG($mythumbnail,$thname,95);
	}
	if($type == '.jpeg'){	
	ImageJPEG($mythumbnail,$thname,95);
	}
	if($type == '.png'){	
	ImageJPEG($mythumbnail,$thname,95);
	}

    imagedestroy($mythumbnail);
    imagedestroy($mainimage);
	
	return 1;
}

class thumimage {

var $thmbWidth="";
var $thmbHeight="";
var $extension_array=array('jpg','jpeg','gif','png','JPG');
var $src="";
var $thmbName="";
var $dest="";
var $base="";
var $ext="";
var $fileextension_arr;
var $mysock="";
var $percentage="";
var $width="";
var $height="";
var $thumimgName="";
var $thumbnail_create;

function createThumbimage($thmbName,$src,$dest,$thmbWidth,$thmbHeight,$base)
{
   $this->thmbName=$thmbName;
   $this->src=$src;
   $this->dest=$dest;
   $this->thmbWidth=$thmbWidth;
   $this->thmbHeight=$thmbHeight;
   $this->base=$base;
	
	
	if(trim(strlen($this->thmbName) < 1)){	
	return "Please enter new name of thumbnail image without any extension";
	}	
	 	
	if((!file_exists($this->src)) || (!is_file($this->src) == true)){	
	  return "Source doesn't exists";
	}	
		
	$this->fileextension_arr=explode(".",$this->src);
	$getCounts=count($this->fileextension_arr)-1;
	$this->ext=$this->fileextension_arr[$getCounts];
	
	 
	if(!in_array($this->ext,$this->extension_array)){	
		return "Only image files are allowed";
	}	
		
	if(!file_exists($this->dest)){	
		return "Destination doesn't exists";
	}
	if(!is_writable($this->dest)){	
		return "Destination is not writable";
	}
		
	if(!is_numeric($this->thmbWidth)){	
		return "thumb width should be numeric";
	}	
	  
	if(!is_numeric($this->thmbHeight)){	
		return "thumb height should be numeric";
	}
	
	$this->mysock=getimagesize($this->src);
	
	
	if($this->base=="w"){
		if($this->mysock[0] > $this->thmbWidth)
		{
		$this->percentage =($this->thmbWidth / $this->mysock[0]); 		
		$this->width=round($this->mysock[0] * $this->percentage); 
        $this->height=round($this->mysock[1] * $this->percentage);
		}
		else {
		$this->width=$this->mysock[0]; 
        $this->height=$this->mysock[1];
		}
	}
	
	if($this->base=="wxh"){	   	
	     $this->width=$this->thmbWidth; 
         $this->height=$this->thmbHeight;		
	}
		
	$this->thumimgName=$this->dest."/".$this->thmbName .".".$this->ext;
	$this->thumbnail_create=creat($this->thumimgName,$this->width,$this->height,$this->src,".".$this->ext);	
	return $this->thumbnail_create;
}

}
$thumbnail=new thumimage('','','','','','');	
?>