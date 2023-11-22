@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
  <!-- モーダルの中身 -->
    <div class="modal js-modal">
        <div class="modal__bg"></div>
        <div class="modal__content">
          <form action="/delete/calendar" method="post">
            <p>予約日：<input name="reserve_date" class="modal_date" value="" readonly></p>
            <br>
            <p>時間：リモ<input name="reserve_part" class="modal_part" value="" readonly>部</p>
            <br>
            <p>上記の予約をキャンセルしてもよろしいですか？</p>
            <br>
                {{ csrf_field() }}
            <!-- 閉じるボタン -->
            <button class="js-modal-close btn btn-primary" href="">閉じる</button>
            <!-- キャンセルボタン -->
            <input type="submit" class="btn btn-danger" value="キャンセル">
          </form>
        </div>
    </div>
</div>
@endsection
