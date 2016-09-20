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

/**
 *RSSの文字数を調整
 */
add_filter('excerpt_mblength','my_excerpt_mblength');
function my_excerpt_mblength( $length ) {
  return 20; // 抜粋に出力する文字数
}

/**
 *RSSにアイキャッチ画像を出力する
 */
function rss_post_thumbnail( $content) {
     global $post;
     if (has_post_thumbnail( $post->ID)) {
         $content = '<p>' . get_the_post_thumbnail($post->ID) .'</p>' . $content;
     }
     return $content;
}
add_filter( 'the_excerpt_rss',  'rss_post_thumbnail');
add_filter( 'the_content_feed', 'rss_post_thumbnail');

/**
 *RSSに「続きを読む」のリンクを追加する
 */
add_filter('excerpt_more','excerpt_more');
function my_excerpt_more( $more ) {
  return '...<a href="'. get_permalink( get_the_ID() ) . '">続きを読む→</a>';
}

//RSSの配信を止める
// remove_action('do_feed_rss2', 'do_feed_rss2', 10, 1);

/**
 *トップページのみ投稿数を3件に設定
 */
add_action( 'pre_get_posts', 'my_pre_get_posts' );
function my_pre_get_posts($query) {
  //管理画面、メインクエリ以外には設定しない
  if ( is_admin() || ! $query->is_main_query() ){
      return;
  }

  //トップページの場合
  if ( $query->is_home() ){
      $query->set( 'posts_per_page', 3 );
      return;
  }
}
?>
