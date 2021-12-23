<?php
namespace App\Services;

use App\Exceptions\Helpers\Helper;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostCategoryService {
    public function store(Request $request)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $category = null;
        $request->validate(
            [
                'name'=>"required|string|min:2|max:225|unique:categories,name",
            ]
        );
        DB::beginTransaction();
        try{
          $category = Category::updateOrCreate(['name'=>$request->name]);
          if($category){
              DB::commit();
              $responseMessage = "Post category created successfully";
              $responseData = $category;
              $status=true;
            }else{
              $responseMessage = "Post category could not be created successfully";
              DB::rollBack();
          }
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
            DB::rollBack();
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
             Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store Category'));
             return $res;
    }

    public function index($request)
    {
      $responseMessage = '';
      $status = false;
      $responseData = null;
      $error = null;
      $category = null;
      $query=[];
      $request->validate(['per_page'=>'nullable|integer']);
      try{
        $category = Category::where($query);
        if($category){
          if($request->per_page){
            $category = $category->paginate((int)$request->per_page);
          }else{ $category=$category->get();}
            $responseMessage = "Post category found successfully";
            $responseData = $category;
            $status=true;
          }else{
            $responseMessage = "Post category could not be found";
        }
      }catch(Throwable $ex){
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);
        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
           Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Category lists'));
           return $res;
    }
    public function getSubCategory($request)
    {
      $responseMessage = '';
      $status = false;
      $responseData = null;
      $error = null;
      $category = null;
      $query=[];
      $request->validate(['per_page'=>'nullable|integer']);
      try{
        $category = DB::table('sub_categories')
         ->where($query)
         ->select('sub_category_name','id','category_id');
          if($request->per_page){
            $category = $category->paginate((int)$request->per_page);
          }else{ $category=$category->get();}
            $responseMessage = "Post subcategory found successfully";
            $responseData = $category;
            $status=true;
      }catch(Throwable $ex){
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);
        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
           Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'SubCategory lists'));
           return $res;
    }
    public function storeSubCategory($request)
    {
      $responseMessage = '';
      $status = false;
      $responseData = null;
      $error = null;
      $subCategory = null;
      $request->validate(
          [
              'name'=>"required|string|min:2|max:225",
              'category_id' => "required|integer|exists:categories,id"
          ]
      );
      DB::beginTransaction();
      try{
        $subCategory = SubCategory::updateOrCreate(['sub_category_name'=>$request->name,'category_id'=>$request->category_id]);
        if($subCategory){
            DB::commit();
            $responseMessage = "Post sub category created successfully";
            $responseData = $subCategory;
            $status=true;
          }else{
            $responseMessage = "Post sub category could not be created successfully";
            DB::rollBack();
        }
      }catch(Throwable $ex){
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);
          DB::rollBack();
        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
           Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store Sub Category'));
           return $res;
    }
}