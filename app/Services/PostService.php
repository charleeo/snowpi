<?php
namespace App\Services;
use App\Exceptions\Helpers\Helper;
use App\Http\Requests\StorePostRequest;
use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostService{
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
              'sub_categories.sub_category_name',
              'sub_categories.id as sub_category_id',
              'categories.name',
              'categories.id as category_id',
              'authors.name as writer',
              'authors.email as writer_email',
              'authors.id as writer_id'
          )->orderBy('posts.created_at',"DESC");
          if($request->per_page){
              $posts = $posts->paginate((int) $request->per_page);
          }else{
              $posts = $posts->get();
          }
          if($posts){
              $responseMessage ="Post data found for your query";
              $status = true;
          }else $responseMessage = "No post data was found for your query";
          $responseData  = $posts;
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
}