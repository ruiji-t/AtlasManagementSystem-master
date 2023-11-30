@extends('layouts.sidebar')

@section('content')
<!-- スクール予約確認画面 -->
<div class="confirm_calender">
    <p class="confirm_title">{{ $calendar->getTitle() }}</p>
    <div class="confirm_area">
      <p>{!! $calendar->render() !!}</p>
    </div>
</div>
@endsection
