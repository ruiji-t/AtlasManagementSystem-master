// 予約のキャンセル確認画面のモーダル
$(function () {
  // 「リモ〇部」ボタン(class="js-modal-open")が押されたら発火
  $('.js-modal-open').on('click', function () {
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから予約日を取得し変数へ格納
    var date = $(this).attr('date');
    // 押されたボタンから予約部門を取得し変数へ格納
    var part = $(this).attr('part');

    // 取得した予約日をモーダルの中身へ渡す
    $('.modal_date').val(date);
    // 取得した予約部門をモーダルの中身へ渡す
    $('.modal_part').val(part);

    return false;
  });

  // 閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });
});
