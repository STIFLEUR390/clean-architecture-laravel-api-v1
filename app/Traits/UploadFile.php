<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// use Intervention\Image\Facades\Image;

trait UploadFile
{
    public function uploadFile($file, $path = '', $exitpath = null)
    {
        $new_path = 'uploads/'.$path;
        if (! File::isDirectory(public_path($new_path))) {
            File::makeDirectory(public_path($new_path), 0777, true, true);
        }

        $this->deleteFile($exitpath);

        $filename = date('YmdHis').'-'.Str::slug(uniqid()).'-dev-master.'.$file->extension();
        $filePath = $file->storeAs($new_path, $filename, ['disk' => 'public_uploads']);
        $path = $filePath;

        return $path;
    }

    /* public function uploadFileResizeWidth($file, $width, $path = '', $exitpath = null)
    {
        $new_path = 'uploads/'.$path;
        if (! File::isDirectory(public_path($new_path))) {
            File::makeDirectory(public_path($new_path), 0777, true, true);
        }

        $this->deleteFile($exitpath);

        $filename = date('YmdHis').'-'.Str::slug(uniqid()).'-dev-master.'.$file->extension();
        $img = Image::make($file)->widen($width);
        $img->save($new_path.'/'.$filename, 100);
        $path = $new_path.'/'.$filename;

        return $path;
    }

    public function uploadFileResizeHeight($file, $height, $path = '', $exitpath = null)
    {
        $new_path = 'uploads/'.$path;
        if (! File::isDirectory(public_path($new_path))) {
            File::makeDirectory(public_path($new_path), 0777, true, true);
        }

        $this->deleteFile($exitpath);

        $filename = date('YmdHis').'-'.Str::slug(uniqid()).'-dev-master.'.$file->extension();
        $img = Image::make($file)->heighten($height);
        $img->save($new_path.'/'.$filename, 100);
        $path = $new_path.'/'.$filename;

        return $path;
    }

    public function uploadFileResize($file, $width, $height, $path = '', $exitpath = null)
    {
        $new_path = 'uploads/'.$path;
        if (! File::isDirectory(public_path($new_path))) {
            File::makeDirectory(public_path($new_path), 0777, true, true);
        }

        $this->deleteFile($exitpath);

        $filename = date('YmdHis').'-'.Str::slug(uniqid()).'-dev-master.'.$file->extension();
        $img = Image::make($file)->resize($width, $height);
        $img->save($new_path.'/'.$filename, 100);
        $path = $new_path.'/'.$filename;

        return $path;
    } */

    public function deleteFile($path = null)
    {
        if (! empty($path) && File::exists($path) && ! in_array($path, exception_image())) {
            File::delete($path);
        }
    }
}
