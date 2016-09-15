<?php
/**
 * アイキャッチ画像を使用可能にする
 */
 add_theme_support( 'post-thumbnails' );
/**
 * カスタムメニュー機能を使用可能にする
 */
 add_theme_support( 'menus' );
/**
 * コメント投稿フォームから入力フィールドを削除する
 */
add_filter('comment_form_default_fields','my_comment_form_defoult_fields');
function my_comment_form_defoult_fields( $args ) {
  $args['author'] = ''; //「名前」の削除
  $args['email'] = ''; //「メールアドレス」の削除
  $args['url'] = ''; //「ウェブサイト」の削除
  return $args;
}
/**
 * head内にRSSのlink要素を出力する
 */
add_theme_support( 'automatic-feed-links' );
?>