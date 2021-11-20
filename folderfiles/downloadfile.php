<?php
$path = $_POST['path'];
$ext = $_POST['ext'];

if(isset($path))
{
    if ($ext == "jpg" or $ext == "jpeg" or $ext == "JPG" or $ext == "JPEG" or $ext == "gif" or $ext == "GIF" or $ext == "png" or $ext == "PNG" or $ext == "bmp" or $ext == "BMP"){


    }else {
        $var_1 = $path;
        $file = $var_1;

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
} //- the missing closing brace
