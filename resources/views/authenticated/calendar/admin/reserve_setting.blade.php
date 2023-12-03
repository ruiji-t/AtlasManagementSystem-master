@extends('layouts.sidebar')
@section('content')
<!-- スクール予約枠登録画面 -->
<div class="w-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="border setting_calender">
    <p class="setting_title">{{ $calendar->getTitle() }}</p>
    <div class="setting_area">
      {!! $calendar->render() !!}
    </div>
    <div class="adjust-table-btn m-auto text-right">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection
