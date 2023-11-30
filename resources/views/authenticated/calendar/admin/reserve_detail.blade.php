@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="justify-content:center;">
<!-- 予約した日(Y年m月d日)と部門を表示 -->
<div class="detail_day">
  <p><span>{{ date('Y年m月d日',strtotime($date)) }} </span><span class="ml-3">{{ $part }} 部</span></p>
  <div class="detail_area m-auto">
    <div class="border">
      <table class="detail_table">
        <tr class="text-center detail_head">
          <th>ID</th>
          <th>名前</th>
          <th>場所</th>
        </tr>
        <!-- 予約した人のユーザー情報を表示 -->
        @foreach($reservePersons as $reservePerson)
          @foreach($reservePerson->users as $user)
            <tr class="text-center detail_body">
              <td>{{ $user->id }}</td>
              <td>{{ $user->over_name }} {{ $user->under_name }}</td>
              <td>リモート</td>
            </tr>
          @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
</div>
@endsection
