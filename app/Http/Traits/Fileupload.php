<?php
namespace App\Http\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Testing\File;

trait FileUpload{
        
            /** @return $filesArray and $error
          * **
          * @return #you should just get the file you want to upload get specify the extension you want and size. You can upload unlimited number of files
           */
    public  function uploadSingleFile($image,$extensions,$size,$path, int $height, int $width)
    {
            $filesArray=[];
            $filesToDB ='';
            $error='';
                $fileRealName = $image->getClientOriginalName();
                $files = time() . $image->getClientOriginalName();
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
                $filesToDB = url('/'). '/'. $path.$files;
                if(!is_dir($path) AND !file_exists($path)){ //make a dir for
                    mkdir($path,0777,true);
                }
                Image::make($image)->resize($width,$height)->save(public_path($path.$files));
                // $image->move(public_path($path),$files);
                $filesArray['files_to_db']= $filesToDB;
                $filesArray['error'] = $error;
                if($error){
                    $file = $filesArray['files_to_db'];
                    $f= \public_path($file);
                    if(File::exists($f)){
                        unlink($f);
                    }
                }
        return $filesArray;
    }
    public  function uploadMultioleFiles($images,$extensions,$size,$path)
    {
            $filesArray=[];
            $filesToDB =[];
            $error='';
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
                $filesToDB[] = $path.$files;
                if(!is_dir($path) AND !file_exists($path)){ //make a dir for
                    mkdir($path,0777,true);
                }
                Image::make($image)->resize(300,300)->save(public_path($path.$files));
                // $image->move(public_path($path),$files);
            }
                $filesArray['files_to_db']= $filesToDB;
                $filesArray['error'] = $error;
                if($error){
                    foreach($filesArray['files_to_db'] as $file){
                    $f= \public_path($file);
                        if(File::exists($f)){
                            unlink($f);
                        }
                    }
                }
        return $filesArray;
    }
}