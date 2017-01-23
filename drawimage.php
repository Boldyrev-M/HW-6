<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 07.01.2017
 * Time: 22:38
 */
header('Content-type: image/png');
$certText = file_get_contents(__DIR__."/cert.txt");
$p_img = imagecreatetruecolor(400,300);
$backColor = imagecolorallocate($p_img, 130,230,230);
$fontColor = imagecolorallocate($p_img, 10,20,0);
$fontPath = __DIR__. '/fonts/arial.ttf';
imagefill($p_img, 0, 0, $backColor);
$text = explode(';',$certText);
//var_dump($text);
foreach ($text as $num => $textStr)
imagettftext($p_img, 16, 0, 5, 50+30*$num, $fontColor, $fontPath, $textStr);

imagepng($p_img);
imagedestroy($p_img);
unlink(__DIR__."/cert.txt");