$(function () {
  // ユーザー検索画面　検索条件の追加のメニュー
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $(".add_arrow").toggle();
    $(".no_add_arrow").toggle();
  });

  // ユーザープロフィール詳細画面　選択科目の編集のメニュー
  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(".edit_arrow").toggle();
    $(".no_edit_arrow").toggle();
  });
});
