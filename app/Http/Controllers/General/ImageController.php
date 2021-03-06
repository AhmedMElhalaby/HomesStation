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
        $path = 'storage/'.$path;
        if(!File::exists(public_path($path . '/org' ))){
            File::makeDirectory(public_path($path . '/org' ),0777,true);
        }
        if(!File::exists(public_path($path . '/200' ))){
            File::makeDirectory(public_path($path . '/200' ),0777,true);
        }
        if(!File::exists(public_path($path . '/400' ))){
            File::makeDirectory(public_path($path . '/400' ),0777,true);
        }
        if(!File::exists(public_path($path . '/600' ))){
            File::makeDirectory(public_path($path . '/600' ),0777,true);
        }
        $name = generate_code() . '_' . time() . '.' . $request_file->getClientOriginalExtension();
        if($type == 1){
            Image::make($request_file)->save(public_path($path . '/org' . "/" . $name));
            Image::make($request_file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($path . '/200' . "/" . $name));
            Image::make($request_file)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($path . '/400' . "/" . $name));
            Image::make($request_file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($path . '/600' . "/" . $name));
        }else{
//            Original Image
            $watermark = Image::make(public_path('logo.png'))->resize(50,null,function ($c){
                $c->aspectRatio();
            });
            $img = Image::make($request_file);
            $img->insert($watermark,'bottom-right',10,15);
            $img->text(''.$text, ($img->width()-35), ($img->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(8);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img->save(public_path($path . '/org' . "/" . $name));
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
            $img200->save(public_path($path . '/200' . "/" . $name));
//            400 Image
            $img400 = Image::make($request_file)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $watermark = Image::make(public_path('logo.png'))->resize(50,null,function ($c){
                $c->aspectRatio();
            });
            $img400->text(''.$text, ($img400->width()-35), ($img400->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(8);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img400->insert($watermark,'bottom-right',10,15);
            $img400->save(public_path($path . '/400' . "/" . $name));
//            600 Image
            $img600 = Image::make($request_file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $watermark = Image::make(public_path('logo.png'))->resize(50,null,function ($c){
                $c->aspectRatio();
            });
            $img600->text(''.$text, ($img600->width()-35), ($img600->height()-5), function($font) {
                $font->file(base_path('public/fonts/CairoRegular.ttf'));
                $font->size(8);
                $font->color('#ffffff');
                $font->align('center');
            });
            $img600->insert($watermark,'bottom-right',10,15);
            $img600->save(public_path($path . '/600' . "/" . $name));
        }
        return $name;
    }

    public static function delete_image_from_folder($image_name, $path)
    {
        if(File::exists(public_path($path . '/org' . "/" . $image_name ))){
            unlink(public_path($path . '/org' . "/" . $image_name));
        }
        if(File::exists(public_path($path . '/200' . "/" . $image_name ))){
            unlink(public_path($path . '/200' . "/" . $image_name));
        }
        if(File::exists(public_path($path . '/400' . "/" . $image_name ))){
            unlink(public_path($path . '/400' . "/" . $image_name));
        }
        if(File::exists(public_path($path . '/600' . "/" . $image_name ))){
            unlink(public_path($path . '/600' . "/" . $image_name));
        }

    }
}
