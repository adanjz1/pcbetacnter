<?php
//header("Content-Type: image/jpeg");
$jpg = imagecreatefrompng($_GET['url']);

//$img = imagecreatefromjpeg($image_path);
$black = array("red" => 255, "green" => 255, "blue" => 255, "alpha" => 127);

$removeLeft = 0;
for($x = 0; $x < imagesx($jpg); $x++) {
    for($y = 0; $y < imagesy($jpg); $y++) {
        if(imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y)) != $black){
            break 2;
        }
    }
    $removeLeft += 1;
}

$removeRight = 0;
for($x = imagesx($jpg)-1; $x > 0; $x--) {
    for($y = 0; $y < imagesy($jpg); $y++) {
        if(imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y)) != $black){
            break 2;
        }
    }
    $removeRight += 1;
}

$removeTop = 0;
for($y = 0; $y < imagesy($jpg); $y++) {
    for($x = 0; $x < imagesx($jpg); $x++) {
        if(imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y)) != $black){
            break 2;
        }
    }
    $removeTop += 1;
}

$removeBottom = 0;
for($y = imagesy($jpg)-1; $y > 0; $y--) {
    for($x = 0; $x < imagesx($jpg); $x++) {
        if(imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y)) != $black){
            break 2;
        }
    }
    $removeBottom += 1;
}

//$cropped = imageCreateTransparent(imagesx($jpg) - ($removeLeft + $removeRight), imagesy($jpg) - ($removeTop + $removeBottom));
////imagesavealpha($cropped, true);
////imagecopy($cropped, $jpg, 0, 0, $removeLeft, $removeTop, imagesx($cropped), imagesy($cropped));
//
//header("Content-type: image/png");
//imagepng($cropped); //change to `imagejpeg($cropped, $image_path);` to save
//imagedestroy($cropped);
//imagedestroy($jpg);

$im = @imagecreatetruecolor(imagesx($jpg) - ($removeLeft + $removeRight), imagesy($jpg) - ($removeTop + $removeBottom));
# important part one
imagesavealpha($im, true);
imagealphablending($im, false);
# important part two
$white = imagecolorallocatealpha($im, 255, 255, 255, 127);
imagefill($im, 0, 0, $white);
# do whatever you want with transparent image
$lime = imagecolorallocate($im, 204, 255, 51);
imagecopy($im, $jpg, 0, 0, $removeLeft, $removeTop, imagesx($im), imagesy($im));
header("Content-type: image/png");
imagepng($im);
imagedestroy($im);

?>
