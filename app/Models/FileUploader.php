<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class FileUploader extends Model
{
    use HasFactory;

    public static function upload($uploaded_file, $upload_to, $width = null, $height = null, $optimized_width = 250, $optimized_height = null)
    {
        // Explanation: $upload_file = this is the uploaded temp file => $request->video_feild_name
        // Explanation: $upload_to = "public/storage/video" OR "public/storage/video/Sj8Ro5Gksde3T.mp4" OR "sdsdncts7sn.png" OR empty if amazon s3 is active
        // Explanation: $width and $height => Image width and height
        // Explanation: $optimized_width and $optimized_height ultra optimization, That is stored in optimized folder

        if (!$uploaded_file)
            return;

        if (!extension_loaded('fileinfo')) {
            Session::flash('error', get_phrase('Please enable fileinfo extension on your server.'));
            return;
        }

        if (!extension_loaded('exif')) {
            Session::flash('error', get_phrase('Please enable exif extension on your server.'));
            return;
        }

        //Add public path
        $upload_path = $upload_to;
        $upload_to = public_path($upload_to);

        $s3_keys = get_settings('amazon_s3', 'object');
        if (empty($s3_keys) || $s3_keys->active != 1) {
            if (is_dir($upload_to)) {
                $file_name = time() . '-' . random(30) . '.' . $uploaded_file->extension();
                $upload_path = $upload_path.'/'.$file_name;
            } else {
                $uploaded_path_arr = explode('/', $upload_to);
                $file_name = end($uploaded_path_arr);
                $upload_to = str_replace('/' . $file_name, "", $upload_to);
                if (!is_dir($upload_to)) {
                    Storage::makeDirectory($upload_to);
                }
            }

            if ($width == null) {
                $uploaded_file->move($upload_to, $file_name);
            } else {
                // Use GD for image optimization instead of Intervention Image
                if (!extension_loaded('gd')) {
                    Log::warning('GD extension not available, falling back to simple move', [
                        'file' => $file_name,
                        'path' => $upload_to
                    ]);
                    $uploaded_file->move($upload_to, $file_name);
                } else {
                    try {
                        $tempPath = $uploaded_file->path();
                        $imageInfo = @getimagesize($tempPath);
                        
                        if ($imageInfo === false) {
                            // Not an image, just move it
                            $uploaded_file->move($upload_to, $file_name);
                        } else {
                            $imageType = $imageInfo[2];
                            $originalWidth = $imageInfo[0];
                            $originalHeight = $imageInfo[1];
                            
                            // Calculate new dimensions
                            // If height is provided, fit inside the box maintaining aspect ratio
                            // If height is null, scale by width keeping aspect ratio
                            // Never upscale
                            if ($height !== null) {
                                // Fit inside box ($width x $height) maintaining aspect ratio
                                $widthRatio = $width / $originalWidth;
                                $heightRatio = $height / $originalHeight;
                                $ratio = min($widthRatio, $heightRatio);
                                
                                // Only shrink if bigger, never upscale
                                if ($ratio < 1) {
                                    $newWidth = (int) ($originalWidth * $ratio);
                                    $newHeight = (int) ($originalHeight * $ratio);
                                } else {
                                    $newWidth = $originalWidth;
                                    $newHeight = $originalHeight;
                                }
                            } else {
                                // Scale by width, keep aspect ratio, no upscaling
                                if ($originalWidth > $width) {
                                    $newWidth = $width;
                                    $newHeight = (int) ($originalHeight * ($width / $originalWidth));
                                } else {
                                    $newWidth = $originalWidth;
                                    $newHeight = $originalHeight;
                                }
                            }
                            
                            // Load source image
                            $sourceImage = null;
                            if ($imageType == IMAGETYPE_JPEG) {
                                $sourceImage = @imagecreatefromjpeg($tempPath);
                            } elseif ($imageType == IMAGETYPE_PNG) {
                                $sourceImage = @imagecreatefrompng($tempPath);
                            } elseif ($imageType == IMAGETYPE_GIF) {
                                $sourceImage = @imagecreatefromgif($tempPath);
                            }
                            
                            if ($sourceImage !== false) {
                                // Create new image
                                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                                
                                // Preserve transparency for PNG and GIF
                                if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                                    imagealphablending($newImage, false);
                                    imagesavealpha($newImage, true);
                                    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                                    imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
                                }
                                
                                // Resize
                                imagecopyresampled(
                                    $newImage, $sourceImage,
                                    0, 0, 0, 0,
                                    $newWidth, $newHeight,
                                    $originalWidth, $originalHeight
                                );
                                
                                // Save main image
                                $finalPath = $upload_to . '/' . $file_name;
                                if ($imageType == IMAGETYPE_JPEG) {
                                    imagejpeg($newImage, $finalPath, 85);
                                } elseif ($imageType == IMAGETYPE_PNG) {
                                    imagepng($newImage, $finalPath, 6);
                                } elseif ($imageType == IMAGETYPE_GIF) {
                                    imagegif($newImage, $finalPath);
                                }
                                
                                // Clean up source image (keep newImage for thumbnail if needed)
                                imagedestroy($sourceImage);
                                
                                // Ultra Image optimization (thumbnail in optimized folder)
                                $optimized_path = $upload_to . '/optimized';
                                if (is_dir($optimized_path)) {
                                    try {
                                        // Calculate thumbnail dimensions
                                        if ($optimized_height !== null) {
                                            // Fit inside box maintaining aspect ratio
                                            $thumbWidthRatio = $optimized_width / $newWidth;
                                            $thumbHeightRatio = $optimized_height / $newHeight;
                                            $thumbRatio = min($thumbWidthRatio, $thumbHeightRatio);
                                            
                                            // No upscaling
                                            if ($thumbRatio < 1) {
                                                $thumbWidth = (int) ($newWidth * $thumbRatio);
                                                $thumbHeight = (int) ($newHeight * $thumbRatio);
                                            } else {
                                                $thumbWidth = $newWidth;
                                                $thumbHeight = $newHeight;
                                            }
                                        } else {
                                            // Scale by width, keep aspect ratio, no upscaling
                                            if ($newWidth > $optimized_width) {
                                                $thumbWidth = $optimized_width;
                                                $thumbHeight = (int) ($newHeight * ($optimized_width / $newWidth));
                                            } else {
                                                $thumbWidth = $newWidth;
                                                $thumbHeight = $newHeight;
                                            }
                                        }
                                        
                                        // Create thumbnail from already resized image
                                        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
                                        
                                        // Preserve transparency for PNG and GIF
                                        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                                            imagealphablending($thumbImage, false);
                                            imagesavealpha($thumbImage, true);
                                            $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
                                            imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
                                        }
                                        
                                        // Resize to thumbnail
                                        imagecopyresampled(
                                            $thumbImage, $newImage,
                                            0, 0, 0, 0,
                                            $thumbWidth, $thumbHeight,
                                            $newWidth, $newHeight
                                        );
                                        
                                        // Save thumbnail
                                        $thumbPath = $optimized_path . '/' . $file_name;
                                        if ($imageType == IMAGETYPE_JPEG) {
                                            imagejpeg($thumbImage, $thumbPath, 75);
                                        } elseif ($imageType == IMAGETYPE_PNG) {
                                            imagepng($thumbImage, $thumbPath, 6);
                                        } elseif ($imageType == IMAGETYPE_GIF) {
                                            imagegif($thumbImage, $thumbPath);
                                        }
                                        
                                        imagedestroy($thumbImage);
                                    } catch (\Exception $thumbException) {
                                        Log::error('Thumbnail generation in upload() failed', [
                                            'file' => $file_name,
                                            'error' => $thumbException->getMessage()
                                        ]);
                                        // Continue - thumbnail failure is not critical
                                    }
                                }
                                
                                // Clean up new image
                                imagedestroy($newImage);
                            } else {
                                // Failed to load image, fallback to move
                                Log::warning('Failed to load image with GD, falling back to simple move', [
                                    'file' => $file_name,
                                    'path' => $upload_to
                                ]);
                                $uploaded_file->move($upload_to, $file_name);
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Image optimization in upload() failed', [
                            'file' => $file_name,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        // Fallback to simple move
                        $uploaded_file->move($upload_to, $file_name);
                    }
                }
            }

            return $upload_path;
        } else {
            //upload to amazon s3
            ini_set('max_execution_time', '600');
            config(['filesystems.disks.s3.key' => $s3_keys->AWS_ACCESS_KEY_ID]);
            config(['filesystems.disks.s3.secret' => $s3_keys->AWS_SECRET_ACCESS_KEY]);
            config(['filesystems.disks.s3.region' => $s3_keys->AWS_DEFAULT_REGION]);
            config(['filesystems.disks.s3.bucket' => $s3_keys->AWS_BUCKET]);

            //social-files this directory automatically created on S3 server, the file upload in this folder
            //The file name generated by laravel s3 package
            $s3_file_path = Storage::disk('s3')->put('social-files', $uploaded_file, 'public');
            $s3_file_path = Storage::disk('s3')->url($s3_file_path);
            return $s3_file_path;
        }
    }

    /**
     * Upload and optimize image for listing images using native PHP GD
     * 
     * @param \Illuminate\Http\UploadedFile $uploadedFile The uploaded file
     * @param string $path Relative path from public (e.g., 'uploads/listing-images')
     * @param string $baseFileName The desired filename (e.g., '0-1234567890.jpg')
     * @return string The final filename
     */
    public static function uploadOptimized($uploadedFile, $path, $baseFileName)
    {
        if (!$uploadedFile) {
            return null;
        }

        $fullPath = public_path($path);
        
        // Ensure directory exists
        if (!is_dir($fullPath)) {
            if (!mkdir($fullPath, 0755, true) && !is_dir($fullPath)) {
                Session::flash('error', get_phrase('Failed to create upload directory.'));
                return null;
            }
        }

        $finalPath = $fullPath . '/' . $baseFileName;

        // Check if GD extension is available
        if (!extension_loaded('gd')) {
            // Fallback to simple move if GD is not available
            try {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            } catch (\Exception $e) {
                Session::flash('error', get_phrase('Image upload failed.'));
                return null;
            }
        }

        // Get file path and detect image type
        $tempPath = $uploadedFile->path();
        $imageInfo = @getimagesize($tempPath);
        
        // If not a valid image, just move the file as-is
        if ($imageInfo === false) {
            try {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            } catch (\Exception $e) {
                Session::flash('error', get_phrase('File upload failed.'));
                return null;
            }
        }

        $imageType = $imageInfo[2]; // IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];

        try {
            $maxWidth = 800;
            $maxFileSize = 120 * 1024; // 120 KB in bytes

            // Calculate new dimensions (max width 800px, keep aspect ratio, no upscaling)
            if ($originalWidth > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = (int) ($originalHeight * ($maxWidth / $originalWidth));
            } else {
                // No upscaling - keep original size if smaller
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            }

            // Load source image based on type
            $sourceImage = null;
            if ($imageType == IMAGETYPE_JPEG) {
                $sourceImage = @imagecreatefromjpeg($tempPath);
            } elseif ($imageType == IMAGETYPE_PNG) {
                $sourceImage = @imagecreatefrompng($tempPath);
            } elseif ($imageType == IMAGETYPE_GIF) {
                $sourceImage = @imagecreatefromgif($tempPath);
            } elseif (defined('IMAGETYPE_WEBP') && $imageType == IMAGETYPE_WEBP && function_exists('imagecreatefromwebp')) {
                $sourceImage = @imagecreatefromwebp($tempPath);
            } else {
                // Unsupported image type, fallback to simple move
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            }

            if ($sourceImage === false) {
                throw new \Exception('Failed to load image');
            }

            // Create new image with calculated dimensions
            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG and GIF
            if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            // Resize image
            imagecopyresampled(
                $newImage, $sourceImage,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                $originalWidth, $originalHeight
            );

            // Handle JPEG with quality compression loop
            if ($imageType == IMAGETYPE_JPEG) {
                $minQuality = 40;
                $maxQuality = 85;
                $qualityStep = 5;
                $bestQuality = $maxQuality;
                $bestBuffer = null;
                $bestFileSize = null;

                // Try different quality levels
                for ($quality = $maxQuality; $quality >= $minQuality; $quality -= $qualityStep) {
                    // Start output buffering
                    ob_start();
                    imagejpeg($newImage, null, $quality);
                    $buffer = ob_get_clean();
                    $fileSize = strlen($buffer);

                    // If we found a quality that meets our size requirement, use it
                    if ($fileSize <= $maxFileSize) {
                        $bestQuality = $quality;
                        $bestBuffer = $buffer;
                        $bestFileSize = $fileSize;
                        break;
                    }

                    // Track the best quality so far (smallest file size)
                    if ($bestFileSize === null || $fileSize < $bestFileSize) {
                        $bestQuality = $quality;
                        $bestBuffer = $buffer;
                        $bestFileSize = $fileSize;
                    }
                }

                // Save final image with best quality buffer
                if ($bestBuffer !== null) {
                    file_put_contents($finalPath, $bestBuffer);
                } else {
                    // Fallback: save directly
                    imagejpeg($newImage, $finalPath, $bestQuality);
                }
            } elseif ($imageType == IMAGETYPE_PNG) {
                // PNG: save with compression level 6 (good balance)
                imagepng($newImage, $finalPath, 6);
            } elseif ($imageType == IMAGETYPE_GIF) {
                // GIF: save as-is
                imagegif($newImage, $finalPath);
            } elseif (defined('IMAGETYPE_WEBP') && $imageType == IMAGETYPE_WEBP && function_exists('imagewebp')) {
                imagewebp($newImage, $finalPath, 80);
            }

            // Clean up memory
            imagedestroy($sourceImage);
            imagedestroy($newImage);

            return $baseFileName;

        } catch (\Exception $e) {
            // Fallback to simple move if optimization fails
            try {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            } catch (\Exception $fallbackException) {
                Session::flash('error', get_phrase('Image upload failed.'));
            return null;
        }
    }

    /**
     * Upload and optimize image with higher resolution for floor plans / large images.
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @param string $path Relative path from public (e.g., 'uploads/floor-plan')
     * @param string $baseFileName
     * @param int $maxWidth Max width in pixels (default 1600)
     * @param int $targetKB Target file size in KB for JPEG (default 300)
     * @return string|null The final filename
     */
    public static function uploadOptimizedLarge($uploadedFile, $path, $baseFileName, $maxWidth = 1600, $targetKB = 300)
    {
        if (!$uploadedFile) {
            return null;
        }

        $fullPath = public_path($path);
        if (!is_dir($fullPath)) {
            if (!mkdir($fullPath, 0755, true) && !is_dir($fullPath)) {
                Session::flash('error', get_phrase('Failed to create upload directory.'));
                return null;
            }
        }

        $finalPath = $fullPath . '/' . $baseFileName;

        if (!extension_loaded('gd')) {
            try {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            } catch (\Exception $e) {
                Session::flash('error', get_phrase('Image upload failed.'));
                return null;
            }
        }

        $tempPath = $uploadedFile->path();
        $imageInfo = @getimagesize($tempPath);

        if ($imageInfo === false) {
            try {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            } catch (\Exception $e) {
                Session::flash('error', get_phrase('File upload failed.'));
                return null;
            }
        }

        $imageType = $imageInfo[2];
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $maxFileSize = $targetKB * 1024;

        try {
            if ($originalWidth > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = (int) ($originalHeight * ($maxWidth / $originalWidth));
            } else {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            }

            $sourceImage = null;
            if ($imageType == IMAGETYPE_JPEG) {
                $sourceImage = @imagecreatefromjpeg($tempPath);
            } elseif ($imageType == IMAGETYPE_PNG) {
                $sourceImage = @imagecreatefrompng($tempPath);
            } elseif ($imageType == IMAGETYPE_GIF) {
                $sourceImage = @imagecreatefromgif($tempPath);
            } elseif (defined('IMAGETYPE_WEBP') && $imageType == IMAGETYPE_WEBP && function_exists('imagecreatefromwebp')) {
                $sourceImage = @imagecreatefromwebp($tempPath);
            } else {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            }

            if ($sourceImage === false) {
                throw new \Exception('Failed to load image');
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled(
                $newImage, $sourceImage,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                $originalWidth, $originalHeight
            );

            if ($imageType == IMAGETYPE_JPEG) {
                $minQuality = 50;
                $maxQuality = 90;
                $qualityStep = 5;
                $bestQuality = $maxQuality;
                $bestBuffer = null;
                $bestFileSize = null;

                for ($quality = $maxQuality; $quality >= $minQuality; $quality -= $qualityStep) {
                    ob_start();
                    imagejpeg($newImage, null, $quality);
                    $buffer = ob_get_clean();
                    $fileSize = strlen($buffer);

                    if ($fileSize <= $maxFileSize) {
                        $bestQuality = $quality;
                        $bestBuffer = $buffer;
                        $bestFileSize = $fileSize;
                        break;
                    }

                    if ($bestFileSize === null || $fileSize < $bestFileSize) {
                        $bestQuality = $quality;
                        $bestBuffer = $buffer;
                        $bestFileSize = $fileSize;
                    }
                }

                if ($bestBuffer !== null) {
                    file_put_contents($finalPath, $bestBuffer);
                } else {
                    imagejpeg($newImage, $finalPath, $bestQuality);
                }
            } elseif ($imageType == IMAGETYPE_PNG) {
                imagepng($newImage, $finalPath, 6);
            } elseif ($imageType == IMAGETYPE_GIF) {
                imagegif($newImage, $finalPath);
            } elseif (defined('IMAGETYPE_WEBP') && $imageType == IMAGETYPE_WEBP && function_exists('imagewebp')) {
                imagewebp($newImage, $finalPath, 80);
            } else {
                $uploadedFile->move($fullPath, $baseFileName);
                imagedestroy($sourceImage);
                imagedestroy($newImage);
                return $baseFileName;
            }

            imagedestroy($sourceImage);
            imagedestroy($newImage);

            return $baseFileName;

        } catch (\Exception $e) {
            try {
                $uploadedFile->move($fullPath, $baseFileName);
                return $baseFileName;
            } catch (\Exception $fallbackException) {
                Session::flash('error', get_phrase('Image upload failed.'));
                return null;
            }
        }
    }
}
}
