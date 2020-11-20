<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public static function upload_single($request_file, $path)
    {
        $name = generate_code() . '_' . time() . '.' . $request_file->getClientOriginalExtension();
        Image::make($request_file)->save(storage_path($path . '/org' . "/" . $name));
        Image::make($request_file)->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($path . '/200' . "/" . $name));
        Image::make($request_file)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($path . '/400' . "/" . $name));
        Image::make($request_file)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($path . '/600' . "/" . $name));
        return $name;
    }

    public static function delete_image_from_folder($image_name, $path)
    {
        unlink(storage_path($path . '/org' . "/" . $image_name));
        unlink(storage_path($path . '/200' . "/" . $image_name));
        unlink(storage_path($path . '/400' . "/" . $image_name));
        unlink(storage_path($path . '/600' . "/" . $image_name));
    }
}
