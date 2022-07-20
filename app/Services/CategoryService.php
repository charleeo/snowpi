<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Helpers\Helper;
use App\Models\StockCategory;
use App\Models\StockCustomCategory;
use Throwable;

class CategoryService{
    public function __construct()
    {
        
    }

    public function getAllCategory(Request $request)
    {
        $responseData =null;
        $responseMessage ='';
        $error = null;
        $status =false;
        $query =[];
        
        $categoryColEqualsData = $request->validate([
            'category_name' => 'nullable|string',
            'category_description' => 'nullable|string',
        ]);

        $categoryColLikeData = $request->validate([
            'category_name' => 'nullable|string',
            'category_description' => 'nullable|string',
        ]);
        
        $request->validate(['per_page' => ['nullable','integer']]);
        
        try {

            foreach ($categoryColEqualsData as $safeTableCol => $userInput) {
                if ($userInput === null) continue;
                $query = array_merge($query, [
                    ['stuck_categories.' . $safeTableCol, '=', $userInput]
                ]);
            }
    
            foreach ($categoryColLikeData as $safeTableCol => $userInput) {
    
                if ($userInput === null) continue;
    
                $query = array_merge($query, [
                    ['stuck_categories.'.$safeTableCol, 'LIKE', '%' . $userInput . '%',]
                  ]);
            }
            $categories = DB::table('stuck_categories')->where($query)
            ->select(
                'stuck_categories.*'
            );
            if($categories->count() > 0){
                if($request->filled('per_page')){
                    $categories = $categories->paginate((int) $request->per_page);
                }else{
                    $categories['data'] = $categories->get();
                }
                $status=true;
                $responseData = $categories;
            }else{
                $responseMessage = "No data was found";
            }

        } catch (Throwable $ex) {
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
  
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
             Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'getAllCategory@StuckCategoryController'));
             return $res;
    }

    public function getAllCustomCategory(Request $request)
    {
        $responseData =null;
        $responseMessage ='';
        $error = null;
        $status =false;
        $query =[];
        
        $categoryColEqualsData = $request->validate([
            'custom_category_name' => 'nullable|string',
            'custom_category_description' => 'nullable|string',
        ]);

        $categoryColLikeData = $request->validate([
            'custom_category_name' => 'nullable|string',
            'custom_category_description' => 'nullable|string',
        ]);
        
        $request->validate(['per_page' => ['nullable','integer']]);
        
        try {

            foreach ($categoryColEqualsData as $safeTableCol => $userInput) {
                if ($userInput === null) continue;
                $query = array_merge($query, [
                    ['stuck_categories.' . $safeTableCol, '=', $userInput]
                ]);
            }
    
            foreach ($categoryColLikeData as $safeTableCol => $userInput) {
    
                if ($userInput === null) continue;
    
                $query = array_merge($query, [
                    ['stuck_custom_categories.'.$safeTableCol, 'LIKE', '%' . $userInput . '%',]
                  ]);
            }
            $categories = DB::table('stuck_custom_categories')->where($query)
            ->select(
                'stuck_custom_categories.*'
            );
            if($categories->count() > 0){
                if($request->filled('per_page')){
                    $categories = $categories->paginate((int) $request->per_page);
                }else{
                    $categories['data'] = $categories->get();
                }
                $status=true;
                $responseData = $categories;
            }else{
                $responseMessage = "No data was found";
            }

        } catch (Throwable $ex) {
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
  
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
             Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'getAllCustomCategory@StuckCategoryController'));
             return $res;
    }
    
    public function createAcategory(Request $request)
    {
        $responseData =null;
        $responseMessage ='';
        $error = null;
        $status =false;
        $query =[];
        $request->validate([
            "category_name"=> ['required','string','max:225'],
            "category_description"=> ['nullable','string'],
        ]);
        try {

            $category = StockCategory::updateOrCreate(
                ["category_name" => $request->category_name],
                [
                    "category_name" => $request->category_name,
                    "category_description" => $request->category_description,
                ]
            );
            if($category){
                $status= true;
                $responseMessage = "Data created";
            }else {
                $responseMessage ="Could not create Data";
            }
            $responseData = $category;
        } catch (Throwable $ex) {
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
  
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
             Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'getAllCategory@createACategory'));
             return $res;
    }
    public function createACustomCategory(Request $request)
    {
        $responseData =null;
        $responseMessage ='';
        $error = null;
        $status =false;
        $query =[];
        $request->validate([
            "custom_category_name"=> ['required','string','max:225'],
            "custom_category_description"=> ['nullable','string'],
        ]);
        try {

            $category = StockCustomCategory::updateOrCreate(
                ["custom_category_name" => $request->custom_category_name],
                [
                    "custom_category_name" => $request->custom_category_name,
                    "custom_category_description" => $request->custom_category_description,
                ]
            );
            if($category){
                $status= true;
                $responseMessage = "Data created";
            }else {
                $responseMessage ="Could not create Data";
            }
            $responseData = $category;
        } catch (Throwable $ex) {
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
  
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
             Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'getAllCategory@createACustomCategory'));
             return $res;
    }
}