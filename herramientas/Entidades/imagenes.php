
<?php

class imagenes
{
    public static function setMarcaDeAgua($img, $marDeAgua)
    {
        $imgOriginal = imagecreatefromjpeg($img);
        $marcaDeAgua = imagecreatefrompng($marDeAgua);

        $margenDere = 10;
        $margenInfe = 10;
        $sy = imagesy($marcaDeAgua);
        $sx = imagesx($marcaDeAgua);

        imagecopymerge($imgOriginal, $marcaDeAgua, imagesx($imgOriginal) - $sx - $margenDere, imagesy($imgOriginal) - $sy - $margenInfe, 0, 0, $sx, $sy, 50);

        imagejpeg($imgOriginal, $img);
        imagedestroy($imgOriginal);
    }
}

