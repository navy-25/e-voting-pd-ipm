<?php
// Including all required classes
require('BCGFont.php');
require('BCGColor.php');
require('BCGDrawing.php'); 

// Including the barcode technology
include('BCGcode39.barcode.php'); 

// Loading Font
$font = new BCGFont('/font/Arial.ttf', 9);

$isi = $_GET[isi];
// The arguments are R, G, B for color.
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255); 

$code = new BCGcode39();
$code->setScale(1); // Resolution
$code->setThickness(50); // Thickness
$code->setForegroundColor($color_black); // Color of bars
$code->setBackgroundColor($color_white); // Color of spaces
$code->setFont($font); // Font (or 0)
$code->parse($isi); // Text


/* Here is the list of the arguments
1 - Filename (empty : display on screen)
2 - Background color */
$drawing = new BCGDrawing('', $color_white);
$drawing->setBarcode($code);
$drawing->draw();

// Header that says it is an image (remove it if you save the barcode to a file)
header('Content-Type: image/png');

// Draw (or save) the image into PNG format.
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
?>