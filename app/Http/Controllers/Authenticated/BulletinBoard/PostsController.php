<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\CategoryFormRequest;

use Auth;
use DB;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $subcategories = SubCategory::get();
        $like = new Like;
        $post_comment = new Post;
        // １⃣検索フォーム
        if(!empty($request->keyword)){
            // キーワードがサブカテゴリーと完全一致したら対象のサブカテゴリーに属している投稿のみ表示
            $keyword = $request->keyword;
            if(!empty(SubCategory::where('sub_category',$keyword)->first())){
                $sub_category_id = SubCategory::where('sub_category',$request->keyword)->pluck('id');
                $post_id = DB::table('post_sub_categories')->where('sub_category_id',$sub_category_id)->pluck('post_id');
                $posts = Post::with('user', 'postComments')
                ->whereIn('id',$post_id)
                ->get();
            }else{
                // タイトル・投稿内容による検索結果を表示
                $posts = Post::with('user','postComments')
                ->where('post_title', 'like', '%'.$request->keyword.'%')
                ->orWhere('post', 'like', '%'.$request->keyword.'%')
                ->get();
            }
        }// 2⃣サブカテゴリーを選択して検索
        else if($request->category_word){
            $sub_category = $request->category_word;
            // 選択サブカテゴリーの検索
            $sub_category_id = SubCategory::where('sub_category',$sub_category)->pluck('id');
            $post_id = DB::table('post_sub_categories')->where('sub_category_id',$sub_category_id)->pluck('post_id');

            if(!empty($post_id)){
                $posts = Post::with('user', 'postComments')
                ->whereIn('id',$post_id)
                ->get();
            }
        }// 3⃣「いいねした投稿」を選択して検索
        else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }// 4⃣「自分の投稿」を選択して検索
        else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories','subcategories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    // 登録済みのメインカテゴリー・サブカテゴリーの表示
    public function postInput(){
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories','sub_categories'));
    }

    // 新規投稿
    public function postCreate(PostFormRequest $request){

        DB::beginTransaction();
        try{
            $post_category_id = $request->post_category_id;

            $post_get = Post::create([
                'user_id' => Auth::id(),
                'post_title' => $request->post_title,
                'post' => $request->post_body
            ]);

            // サブカテゴリーの登録
            $post = Post::findOrFail($post_get->id);
            $post->subCategories()->attach($post_category_id);
            DB::commit();
            return redirect()->route('post.show');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('post.input');
        }
    }

    // 投稿編集
    public function postEdit(Request $request){

        $request->validate([
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // 投稿削除
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    // メインカテゴリーの追加機能
    public function mainCategoryCreate(Request $request){

        // バリデーション設定
        $request->validate([
            'main_category_name' => 'required|max:100|string|unique:main_categories,main_category',
        ]);

        MainCategory::create([
            'main_category' => $request->main_category_name
        ]);
        return redirect()->route('post.input');
    }

    // サブカテゴリーの追加機能
    public function subCategoryCreate(Request $request){

        // バリデーション設定
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ]);

        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name,
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){

        $request->validate([
            'comment' => 'required|string|max:2500',
        ]);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }

}
