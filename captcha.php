<?php


//create an image with a width and height from 120 x 30 pixels
$captchaimage = @imagecreatetruecolor(120, 30) or die("Cannot create image");

//Set the background to white and assign drawing colors (0xFF = white)
$background = imagecolorallocate($captchaimage, 0xFF, 0xFF, 0xFF);
imagefill($captchaimage, 0, 0, $background);

//Get the color from the lines in the captcha (0xCC = light grey)
$colorlines = imagecolorallocate($captchaimage, 0xCC, 0xCC, 0xCC);

//creates the text on the image (0x33 = dark color)
$textcolor = imagecolorallocate($captchaimage, 0x33, 0x33, 0x33);

//Draw 6 random lines on the image
for ($i = 0; $i < 6; $i++) {
    //create the thickness of the lines wiith randomize
    imagesetthickness($captchaimage, rand(1, 3));
    // create position from the lines on the image
    imageline($captchaimage, 0, rand(0, 30), 120, rand(0, 30), $colorlines);
}

session_start();

//Add random digits to image
$digit = '';
for ($x = 15; $x <= 95; $x += 20) {
    $digit .= ($num = rand(0, 9));
    //the numbers are random and in the color given above
    imagechar($captchaimage, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
}

//Set numbers in session variable
$_SESSION['digit'] = $digit;

//Display image
header('Content-type: image/png');
imagepng($captchaimage);
imagedestroy($captchaimage);
