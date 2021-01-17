<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;


class ImageController extends Controller
{
    public static function upload_single($request_file, $path,$type=1,$text=null)
    {

        if(!File::exists(storage_path($path . '/org' . "/" ))){
            File::makeDirectory(storage_path($path . '/org' . "/" ));
        }
        if(!File::exists(storage_path($path . '/200' . "/" ))){
            File::makeDirectory(storage_path($path . '/200' . "/" ));
        }
        if(!File::exists(storage_path($path . '/400' . "/" ))){
            File::makeDirectory(storage_path($path . '/400' . "/" ));
        }
        if(!File::exists(storage_path($path . '/600' . "/" ))){
            File::makeDirectory(storage_path($path . '/600' . "/" ));
        }
        $name = generate_code() . '_' . time() . '.' . $request_file->getClientOriginalExtension();
        if($type == 1){
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
        }else{
//            Original Image
            $watermark = Image::make(public_path('logo.png'))->resize(150,null,function ($c){
                $c->aspectRatio();
            });
            $img = Image::make($request_file);
            $img->insert($watermark,'bottom-right',10,10);
            $img->text(''.$text, ($img->width()-90), ($img->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(20);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img->save(storage_path($path . '/org' . "/" . $name));
//            200 Image
            $img200 = Image::make($request_file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $watermark = Image::make(public_path('logo.png'))->resize(50,null,function ($c){
                $c->aspectRatio();
            });
            $img200->insert($watermark,'bottom-right',10,15);
            $img200->text(''.$text, ($img200->width()-35), ($img200->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(8);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img200->save(storage_path($path . '/200' . "/" . $name));
//            400 Image
            $img400 = Image::make($request_file)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $watermark = Image::make(public_path('logo.png'))->resize(100,null,function ($c){
                $c->aspectRatio();
            });
            $img400->text(''.$text, ($img400->width()-70), ($img400->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(15);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img400->insert($watermark,'bottom-right',10,25);
            $img400->save(storage_path($path . '/400' . "/" . $name));
//            600 Image
            $img600 = Image::make($request_file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $watermark = Image::make(public_path('logo.png'))->resize(150,null,function ($c){
                $c->aspectRatio();
            });
            $img600->text(''.$text, ($img600->width()-90), ($img600->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(20);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img600->insert($watermark,'bottom-right',10,30);
            $img600->save(storage_path($path . '/600' . "/" . $name));
        }
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
