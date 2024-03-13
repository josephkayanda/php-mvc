<?php

/**
 * Image manipulation class
 */
namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

class Image
{
    /**
     * Resize an image
     *
     * @param string $filename The path to the image file
     * @param int    $max_size The maximum size (width or height) for the resized image
     *
     * @return string The path to the resized image
     */
    public function resize($filename, $max_size = 700)
    {
        /** Check the file type of the image **/
        $type = mime_content_type($filename);

        if (file_exists($filename)) {
            switch ($type) {
                case 'image/png':
                    $image = imagecreatefrompng($filename);
                    break;

                case 'image/gif':
                    $image = imagecreatefromgif($filename);
                    break;

                case 'image/jpeg':
                    $image = imagecreatefromjpeg($filename);
                    break;

                case 'image/webp':
                    $image = imagecreatefromwebp($filename);
                    break;

                default:
                    return $filename;
                    break;
            }

            $src_w = imagesx($image);
            $src_h = imagesy($image);

            // Determine the dimensions of the resized image
            if ($src_w > $src_h) {
                if ($src_w < $max_size) {
                    $max_size = $src_w;
                }

                $dst_w = $max_size;
                $dst_h = ($src_h / $src_w) * $max_size;
            } else {
                if ($src_h < $max_size) {
                    $max_size = $src_h;
                }

                $dst_w = ($src_w / $src_h) * $max_size;
                $dst_h = $max_size;
            }

            $dst_w = round($dst_w);
            $dst_h = round($dst_h);

            // Create a new true-color image for the resized image
            $dst_image = imagecreatetruecolor($dst_w, $dst_h);

            if ($type == 'image/png') {
                // Enable alpha channel for PNG images
                imagealphablending($dst_image, false);
                imagesavealpha($dst_image, true);
            }

            // Copy and resize the image
            imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

            // Destroy the original image
            imagedestroy($image);

            // Save the resized image based on its original type
            switch ($type) {
                case 'image/png':
                    imagepng($dst_image, $filename, 8);
                    break;

                case 'image/gif':
                    imagegif($dst_image, $filename);
                    break;

                case 'image/jpeg':
                    imagejpeg($dst_image, $filename, 90);
                    break;

                case 'image/webp':
                    imagewebp($dst_image, $filename, 90);
                    break;

                default:
                    imagejpeg($dst_image, $filename, 90);
                    break;
            }

            // Destroy the resized image
            imagedestroy($dst_image);
        }

        // Return the path to the resized image
        return $filename;
    }
}
