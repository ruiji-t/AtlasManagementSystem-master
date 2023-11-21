<?php
namespace App\Calendars\General;

// 空白用の日カレンダークラス（カレンダー上の前月、後月に含まれる日付部分）
  // CalendarWeekDayを基にクラス名（day-blank）とHTML（空白）だけ変更できるように指定
class CalendarWeekBlankDay extends CalendarWeekDay{
  function getClassName(){
    return "day-blank";
  }

  /**
   * @return
   */

   function render(){
     return '';
   }

   function selectPart($ymd){
     return '';
   }

   function getDate(){
     return '';
   }

   function cancelBtn(){
     return '';
   }

   function everyDay(){
     return '';
   }

}
