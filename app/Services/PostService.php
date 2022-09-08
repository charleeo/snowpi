<?php
namespace App\Services;
use App\Exceptions\Helpers\Helper;
use App\Http\Requests\StorePostRequest;
use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class PostService{
    public const DEFAULTIMAGE =  "assets/images/post_images/no_image.png";
    
    public function store(StorePostRequest $request)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $post = null;
        $postAuthor=null;
        $user = User::find(auth()->id());

        DB::beginTransaction();
       try{
        //    check if this user has created a post before
        $postAuthor = Author::where(['email'=>$user->email])->first();
        if(!$postAuthor){
          $postAuthor= Author::create(['name'=>$user->name, 'email'=>$user->email]);
        }       
        $validatedData = $request->validated();
        $validatedData['author_id']  = $postAuthor->id;
        $validatedData['user_id']  = $user->id;

        if($request->hasFile('file')){
            $path = 'assets/images/post_images/';
            $pathForSmallImages = 'assets/images/post_small_images/';
            $extensions = ['jpg','png','jpeg','gif'];
            $size = 2084000;
            $file = $request->file('file');
            $postFile = new Post;
            $fileBigSize = $postFile->uploadSingleFile($file,$extensions,$size,$path,400,800);
            $fileSmallSize = $postFile->uploadSingleFile($file,$extensions,$size,$pathForSmallImages,150,300);
            $error = $fileBigSize['error'];
            $errorFromSmallSize = $fileSmallSize['error'];
            if($error || $errorFromSmallSize){
                $responseMessage = $errorFromSmallSize?$errorFromSmallSize:$error;
                $res = AppUtils::formatJson($responseMessage, $status, $responseData);
                Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
                return $res;
            }
            
            $imageFileURL =  $fileBigSize['files_to_db'];
            $smalImageFileURL =  $fileSmallSize['files_to_db'];
            $validatedData['file_url'] = $imageFileURL;
            $validatedData['file_small_size_url'] = $smalImageFileURL;
        }

         $post = Post::create($validatedData);
         if($post){
             $responseMessage = "Post created";
             $status = true;
             DB::commit();
         }else {
             $responseMessage = "Could not create post";
             DB::rollBack();
         }
         $responseData = $post;
      }catch(Throwable $ex){
          DB::rollBack();
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);

        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
           Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
           return $res;
    }
    public function update(StorePostRequest $request)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $post = null;
        $request->validate(['post_id'=>"required|integer|exists:posts,id"]);
        DB::beginTransaction();
       try{
         $post = Post::find($request->post_id);  
         $validatedData = $request->validated();
         if($post){
            if($request->hasFile('file')){
                $postExistingBigFile =  str_replace(url('/').'/',"", $post['file_url']);
                $postExistingSmallFile = str_replace(url('/').'/',"", $post['file_small_size_url']);
                if($postExistingSmallFile != PostService::DEFAULTIMAGE){
                    $smallSizeFile= \public_path($postExistingSmallFile);
                    if(file_exists($smallSizeFile)){
                        unlink($smallSizeFile);
                    }
                    $bigSizeFile= \public_path($postExistingBigFile);
                    if(file_exists($bigSizeFile)){
                        unlink($bigSizeFile);
                    }
                }
                $path = 'assets/images/post_images/';
                $pathForSmallImages = 'assets/images/post_small_images/';
                $extensions = ['jpg','png','jpeg','gif'];
                $size = 2084000;
                $file = $request->file('file');
                $postFile = new Post;

                $fileBigSize = $postFile->uploadSingleFile($file,$extensions,$size,$path,400,800);
                $fileSmallSize = $postFile->uploadSingleFile($file,$extensions,$size,$pathForSmallImages,150,300);

                $error = $fileBigSize['error'];
                $errorFromSmallSize = $fileSmallSize['error'];
                if($error || $errorFromSmallSize){
                    $responseMessage = $errorFromSmallSize?$errorFromSmallSize:$error;
                    $res = AppUtils::formatJson($responseMessage, $status, $responseData);
                    Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
                    return $res;
                }
                
                $imageFileURL =  $fileBigSize['files_to_db'];
                $smalImageFileURL =  $fileSmallSize['files_to_db'];
                // $imageFileURL = implode('|', $fileUploadDetils['files_to_db']);
                $validatedData['file_url'] = $imageFileURL;
                $validatedData['file_small_size_url'] = $smalImageFileURL;
            }
             $post->update($validatedData);
             $responseMessage = "Post updated";
             $status = true;
             DB::commit();
         }else {
             $responseMessage = "Could not create post";
             DB::rollBack();
         }
         $responseData = $post;
      }catch(Throwable $ex){
          DB::rollBack();
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);

        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
           Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'update#PostController'));
           return $res;
    }

    public function index(Request $request)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $posts = null;
        $query =[];
        try{
          $posts = DB::table('posts')->where($query)
          ->leftJoin('authors','authors.id','=','posts.author_id')
          ->leftJoin('sub_categories','sub_categories.id','=','posts.sub_category_id')
          ->leftJoin('categories','categories.id','=','sub_categories.category_id')
          ->select(
              'posts.title',
              'posts.body',
              'posts.id',
              'posts.user_id',
              'posts.created_at',
              'posts.file_url',
              'posts.file_small_size_url',
              'sub_categories.sub_category_name',
              'sub_categories.id as sub_category_id',
              'categories.name',
              'categories.id as category_id',
              'authors.name as writer',
              'authors.email as writer_email',
              'authors.id as writer_id'
          )->orderBy('posts.created_at',"DESC");
          if($request->per_page){
              $responseData = $posts ->latest()-> paginate((int) $request->per_page);
          }else{
              $posts = $posts->latest()->get();
              $responseData = [];
              $responseData['data'] = $posts;
          }
          if($posts->count() >0){
              $responseMessage ="Post data found for your query";
              $status = true;
          }else $responseMessage = "No post data was found for your query";
        //   $responseData  = $posts;
        }catch(Throwable $ex){
        $responseMessage = 'There was an error';
        $error = LogUtils::errorLog($ex);

      }
      $res = AppUtils::formatJson($responseMessage, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
         return $res;
    }
    public function show(Request $request,$id)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $post = null;
        $query =[];
        $query[] = ['posts.id', '=', $id];
        try{
          $post = DB::table('posts')->where($query)
          ->leftJoin('authors','authors.id','=','posts.author_id')
          ->leftJoin('sub_categories','sub_categories.id','=','posts.sub_category_id')
          ->leftJoin('categories','categories.id','=','sub_categories.category_id')
          ->select(
              'posts.title',
              'posts.body',
              'posts.id',
              'posts.file_url',
              'posts.file_url',
              'posts.file_small_size_url',
              'sub_categories.sub_category_name',
              'sub_categories.id as sub_category_id',
              'categories.name',
              'categories.id as category_id',
              'authors.name as writer',
              'authors.email as writer_email',
              'authors.id as writer_id',
              'user_id'
          )->first();
          if($post){
              $responseMessage ="Post data found for your query";
              $status = true;
              $responseData  = $post;
          };
        }catch(Throwable $ex){
        $responseMessage = 'There was an error';
        $error = LogUtils::errorLog($ex);

      }
      $res = AppUtils::formatJson($responseMessage, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
         return $res;
    }

    public function deletePost(Request $request,$id)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $post = null;
        $query =[];
        $query[] = ['posts.id', '=', $id];
        DB::beginTransaction();
        try{
          $post = DB::table('posts')->where($query);
          $postDetails = $post->first();
          $deleted = $post->delete();
          if($deleted){

            $file_small_size_url = 
            str_replace(url('/').'/',"",$postDetails->file_small_size_url);
            $file_url = str_replace(url('/').'/',"",$postDetails->file_url);

            if($file_small_size_url != PostService::DEFAULTIMAGE && $file_url != PostService::DEFAULTIMAGE){
                $f1 = \public_path($file_small_size_url);
                $f2 = \public_path($file_url);
                if(File::exists($f1)){
                    unlink($f1);
                }
                if(File::exists($f2)){
                    unlink($f2);
                }
            }
            $responseMessage ="Post was deleted";
            $status = true;
            $responseData  = $postDetails;
            DB::commit();
          }else{
              $responseMessage = "Could not delete post. Please retry";
              DB::rollBack();
          }
        }catch(Throwable $ex){
        $responseMessage = 'There was an error';
        $error = LogUtils::errorLog($ex);
        DB::rollBack();
      }
      $res = AppUtils::formatJson($responseMessage, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'delete#PostController'));
         return $res;
    }
}