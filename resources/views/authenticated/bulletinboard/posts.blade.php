@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    @foreach($posts as $post)
    <div class="post_area w-75 p-3">
      <p class="post_name"><span>{{ $post->user->over_name }}　{{ $post->user->under_name }}</span>さん</p>
      <p class="post_title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <!-- サブカテゴリー名の表示 -->
        <div class="">
          @foreach($post->subCategories as $subCategory)
          <span class="category_btn">{{ $subCategory->sub_category }}</span>
          @endforeach
        </div>
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post->postComments()->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0">
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
              <span class="like_counts{{ $post->id }}">{{ $post->likes()->count() }}</span>
            </p>
            @else
            <p class="m-0">
              <i class="far fa-heart like_btn" post_id="{{ $post->id }}"></i>
              <span class="like_counts{{ $post->id }}">{{ $post->likes()->count() }}</span>
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="">
      <div class="post_page_link"><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="search_bar">
        <input type="text" placeholder="　キーワードを検索" name="keyword" form="postSearchRequest" class="search_bar_input" >
        <input type="submit" value="検索" form="postSearchRequest" class="search_bar_button">
      </div>
      <div class="pickup_btn">
        <input type="submit" name="like_posts" class="pickup_good" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="pickup_mine" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
        <!-- メインカテゴリー・サブカテゴリーの表示 -->
        <p>カテゴリー検索</p>
        @foreach($categories as $category)
        <div class="categories_search">
          <div class="main_categories" category_id="{{ $category->id }}">
            <div>
              <span>{{ $category->main_category }}<span>
            </div>
              <!-- 矢印 -->
              <img class="no_category_arrow" src="{{asset('image/up_arrow.png')}}"  category_id="{{ $category->id }}">
              <img class="category_arrow" src="{{asset('image/up_arrow.png')}}"  category_id="{{ $category->id }}">
          </div>
          <div class="category_num" category_id="{{ $category->id }}">
            @foreach($subcategories as $subcategory)
                @if($category->id == $subcategory->main_category_id)
                  <input type="submit" name="category_word" class="sub_categories" value="{{ $subcategory->sub_category }}" form="postSearchRequest">
                @endif
            @endforeach
          </div>
        </div>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
