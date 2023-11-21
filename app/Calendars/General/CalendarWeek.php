<?php
namespace App\Calendars\General;

use Carbon\Carbon;

// カレンダー週クラス：その週のカレンダーを出力する
class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  // CSS用のクラス名を出力
  function getClassName(){
    return "week-" . $this->index;
  }

  /**
   * @return
   */


   // その週の開始日から終了日までを作成
   function getDays(){
     $days = [];

     // 開始日から終了日
     $startDay = $this->carbon->copy()->startOfWeek();
     $lastDay = $this->carbon->copy()->endOfWeek();

     // 処理用の日
     $tmpDay = $startDay->copy();

     //　週の末日まで繰り返し処理（月から日曜）
     while($tmpDay->lte($lastDay)){

      // その日が当月以外の日付の場合（CalendarWeekBlankDayオブジェクト）
       if($tmpDay->month != $this->carbon->month){
        // 空白を表示
         $day = new CalendarWeekBlankDay($tmpDay->copy());
         $days[] = $day;

         // 翌日に更新
         $tmpDay->addDay(1);
         continue;
        }

        // その日が当月の日付の場合（CalendarWeekDayオブジェクト）
        $day = new CalendarWeekDay($tmpDay->copy());
        $days[] = $day;

        // 翌日に更新
        $tmpDay->addDay(1);
      }
      return $days;
    }
  }
