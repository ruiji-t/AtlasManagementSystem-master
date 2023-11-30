<?php
namespace App\Calendars\General;

/* 日付用のライブラリ */
use Carbon\Carbon;
use Auth;

// スクール予約画面
class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  /* タイトル */
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  /* カレンダー部分 */
  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th style="color:blue">土</th>';
    $html[] = '<th style="color:red">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';

    // 3行目（曜日の下行）からの出力
    $html[] = '<tbody>';
    $weeks = $this->getWeeks(); // 週カレンダーオブジェクト内の$weekを取得

    foreach($weeks as $week){
      // 1週間ごと
      $html[] = '<tr class="'.$week->getClassName().'">';

      // 日カレンダーオブジェクト内$daysを取得
      $days = $week->getDays();

      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){

          $html[] = '<td class="calendar-td past-day" >';
          $html[] ='<p class=" '.$day->getClassName().'"';

        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
          $html[] ='<p class=" '.$day->getClassName().'"';
        }
        $html[] = $day->render();

        // 予約が存在するとき
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }

          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){

            if($reservePart == "リモ1部"){
            $reservePart = "1部参加";
            }else if($reservePart == "リモ2部"){
            $reservePart = "2部参加";
            }else if($reservePart == "リモ3部"){
            $reservePart = "3部参加";
            }

            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'. $reservePart .'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            // 「リモ〇部」ボタン（赤）　予約した日と部をモーダルにわたす
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'">
            <a class="js-modal-open cancel" href="" date="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'" part="'. $day->authReserveDate($day->everyDay())->first()->setting_part .'" >'. $reservePart .'</a>
            </button>';
          }
          $html[] = $day->getDate();
        }// 予約が存在しないとき
        else{
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){
            $html[] = '<p style="font-size:12px">受付終了</p>';
          }else {
            $html[] = $day->selectPart($day->everyDay());
            $html[] = $day->getDate();
          }
        }
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';

    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }



  // 週情報を取得する
  protected function getWeeks(){
    $weeks = [];
    // 月の初日　※copy():インスタンスのコピーを作成
    $firstDay = $this->carbon->copy()->firstOfMonth();
    // 月の末日　
    $lastDay = $this->carbon->copy()->lastOfMonth();

    // 1週目　初日を指定
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;

    // addDays(x):x日追加/startOfWeek():その週の初日の00:00:00を取得
    //
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

    // 月末の日になるまで繰り返し処理　　※lte():日付の判定「～以下」
    while($tmpDay->lte($lastDay)){
      // 週カレンダーを作成　今何週目か送る
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;

      // 次週＝＋７
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
