<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait ImageUpload{
    public static function uploadFiles($images,$extensions,$size,$path){
        $error =null;
        $returnValue  =[
            'error'=>null,
            'db'=>null
        ];
        foreach($images as $key => $image){
            $fileRealName = $image->getClientOriginalName();
            $files = time().$key. $image->getClientOriginalName();
            $sizes = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            if(!in_array($extension,$extensions)){
                $error= "$fileRealName has a wrong extension of .$extension which is not allowed.";
            }
            if($sizes > $size){
               $checkedSize= $sizes/1000;
               $maxSize =$size/1000;
                $error= "$fileRealName has a size of $checkedSize kilobytes which is larger than $maxSize kilobytes maximum size ";
            }
            if(!is_dir($path) AND !file_exists($path)){ //make a dir for
                mkdir($path,0777,true);
            }
            if($error){
              $returnValue['error'] = $error;
            }else{
                $image->move(public_path($path),$files);
                $filesToDB[] = $path.$files;
                $returnValue['db']= implode ("|",$filesToDB);
            }
        }
        return $returnValue;    
       }
}