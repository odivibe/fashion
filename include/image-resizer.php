<?php

// image resizing
function resizeImage($sourcePath, $destinationPath, $width, $height) 
{
    list($originalWidth, $originalHeight, $imageType) = getimagesize($sourcePath);

    $aspectRatio = $originalWidth / $originalHeight;

    if ($width / $height > $aspectRatio) {
        $width = $height * $aspectRatio;
    } 
    else 
    {
        $height = $width / $aspectRatio;
    }

    $resizedImage = imagecreatetruecolor($width, $height);

    switch ($imageType) 
    {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false; // Unsupported image type
    }

    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

    switch ($imageType) 
    {
        case IMAGETYPE_JPEG:
            imagejpeg($resizedImage, $destinationPath, 90); // 90 is the image quality
            break;
        case IMAGETYPE_PNG:
            imagepng($resizedImage, $destinationPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($resizedImage, $destinationPath);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($resizedImage, $destinationPath);
            break;
    }

    imagedestroy($resizedImage);
    imagedestroy($sourceImage);
}

?>