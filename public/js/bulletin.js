$(function () {
  // 掲示板　カテゴリー検索のメニュー
  $('.main_categories').click(function () {
    //  クリックしたcategory_idをもつメインカテゴリーのサブカテゴリーを表示
    var category_id = $(this).attr('category_id');

    // $('.category_num' + category_id).slideToggle();
    $('.category_num[category_id="' + category_id + '"]').slideToggle();

    // 矢印
    $('.category_arrow[category_id="' + category_id + '"]').toggle();
    $('.no_category_arrow[category_id="' + category_id + '"]').toggle();
  });


  // 白ハート（「いいね」ボタン）をクリック　白抜き(far)→赤塗りつぶし(fas)
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).addClass('fas');
    $(this).removeClass('like_btn');
    $(this).removeClass('far');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  // 赤ハート（「いいね」取り消しボタン）をクリック　赤塗りつぶし→白抜き
  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).removeClass('fas');
    $(this).addClass('like_btn');
    $(this).addClass('far');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  $('.edit-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});
