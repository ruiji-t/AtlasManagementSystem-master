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
        <div class="modal__bg js-modal-close"></div>
        <div class="modal__content">
          <form action="" method="post">
            <p>予約日：<input name="" class="modal_date" value="" readonly></p>
            <br>
            <p>時間：リモ<input name="" class="modal_part" value="" readonly>部</p>
            <br>
            <p>上記の予約をキャンセルしてもよろしいですか？</p>
            <br>
                {{ csrf_field() }}
          </form>
          <!-- 閉じるボタン -->
          <button class="js-modal-close btn btn-primary" href="">閉じる</button>
          <!-- キャンセルボタン -->
          <button type="submit" class="btn btn-danger">キャンセル</button>
        </div>
    </div>
</div>
@endsection
