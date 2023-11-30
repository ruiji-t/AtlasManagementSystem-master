@extends('layouts.sidebar')

@section('content')
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person">
      <div>
        <span class="grey_item">ID : </span><span class="black_item">{{ $user->id }}</span>
      </div>
      <div><span class="grey_item">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="grey_item">カナ : </span>
        <span class="black_item">({{ $user->over_name_kana }}</span>
        <span class="black_item">{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span class="grey_item">性別 : </span><span class="black_item">男</span>
        @elseif($user->sex == 2)
        <span class="grey_item">性別 : </span><span class="black_item">女</span>
        @else
        <span class="grey_item">性別 : </span><span class="black_item">その他</span>
        @endif
      </div>
      <div>
        <span class="grey_item">生年月日 : </span><span class="black_item">{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span class="grey_item">権限 : </span><span class="black_item">教師(国語)</span>
        @elseif($user->role == 2)
        <span class="grey_item">権限 : </span><span class="black_item">教師(数学)</span>
        @elseif($user->role == 3)
        <span class="grey_item">権限 : </span><span class="black_item">講師(英語)</span>
        @else
        <span class="grey_item">権限 : </span><span class="black_item">生徒</span>
        @endif
      </div>
      <div>
        <!-- 選択科目を表示 -->
        @if($user->role == 4)
        <span class="grey_item">選択科目 :</span>
        @foreach($user->subjects as $subject)
        <span class="black_item"> {{ $subject->subject }} </span>
        @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25">
    <div class="search_box">
      <p class="search_title">検索</p>
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <p>カテゴリ</p>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <p>並び替え</p>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_add">
        <p class="m-0 search_conditions">
          <span>検索条件の追加</span>
          <!-- 矢印 -->
          <img class="no_add_arrow" src="{{asset('image/up_arrow.png')}}">
          <img class="add_arrow" src="{{asset('image/up_arrow.png')}}">
        </p>
        <div class="search_conditions_inner">
          <div>
            <p>性別</p>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div>
            <p>権限</p>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <p>選択科目</p>
            <div class="selected_subject">
              @foreach($subjects as $subject)
              <span>{{ $subject->subject }}</span>
              <input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest">
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div>
        <input type="submit" name="search_btn" value="検索" class="search_submit" form="userSearchRequest">
      </div>
      <div>
        <input type="reset" value="リセット"  class="search_reset" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
