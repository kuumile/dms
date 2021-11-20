<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<script>
    //window.open("directory/Documents/EmmanuelLumu.pdf","_blank");
</script>
<?
//include "wordconvert.php";
$url = "directory/Semester One Exams Questions/APITS agenda.docx";
//header("Content-type: application/pdf");
//header("Content-Disposition: inline; filename='EmmanuelLumu.pdf'");
//header("Content-Transfer-Encoding: binary");
//header("Accept-Ranges: bytes");
//readfile($url);
require ("wordconvert.php"); # The class file wordconvert.php should be saved on the PHP include directory
$convert = wordconvert::class;
# Change as you wish with your own values:
$filename="a.doc";
$ext = "htm"; # - will convert rtf file above to htm file
$ext = 8;       # Same as above. See class info for Extension <-> Number correspondence.
$vis= 1; # =1Word will be visible, =0 to hide it

# Run the script with the above values
//new wordconvert($url,$ext,$vis); #Do the trick

new $convert($url,$ext,$vis);

print "done!";
?>
<?php

// The location of the PDF file
// on the server
//$filename = "directory/Documents/EmmanuelLumu.pdf";
//
//// Header content type
//header("Content-type: application/pdf");
//
//header("Content-Length: " . filesize($filename));
//header("Content-Transfer-Encoding: binary");
//// Send the file to the browser.
//readfile($filename);
?>

</body>
</html>



