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
/*
add_filter('excerpt_more','my_excerpt_more');
function my_excerpt_more( $more ) {
  return '...<a href="'. get_permalink( get_the_ID() ) . '">続きを読む→</a>';
}
*/

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
      $query->set( 'posts_per_page', 2 );
      return;
  }
}

/**
 * 管理画面、ログイン画面用のCSSを設定する
 */
add_action('admin_print_styles', 'print_admin_stylesheet');
add_action('login_head', 'print_admin_stylesheet');
function print_admin_stylesheet() {
    echo '<link href="' .get_template_directory_uri() . '/css/admin.css"
type="text/css" rel="stylesheet" media="all" />' . PHP_EOL;
}

/**
 *ビジュアルモードが表示されるよう設定
 */
add_filter('wp_default_editor', 'my_wp_default_editor');
function my_wp_default_editor(){
  return 'tinymce';
}

/**
 * メッセージを表示する簡単なショートコード
 */
function shortcode_test(){
    return "「ショートコードのテストです」";
}
add_shortcode('test', 'shortcode_test');

/**
 * ツイッターへのリンクを表示するショートコード
 */
function shortcode_twitter(){
  return 'こんにちは！ナカシマ(<a href="https://twitter.com/kanakogi" target="blank">@kanakogi</a>)です。';
}
add_shortcode('twitter', 'shortcode_twitter');

/**
 * パラメータでりんごの個数を受け取るショートコード
 */
function shortcode_apple($atts){
    $atts = shortcode_atts(array(
              'num' => 5, //$numの初期値を設定
          ), $atts);
    extract($atts); //連想配列から変数を作成
    return "リンゴが" . $num . "個ありました。";
}
add_shortcode('apple', 'shortcode_apple');

/**
 * クラス名がwrapの<div>タグで囲むショートコード
 */
function shortcode_price($atts, $content = null) {
  return '<div class="wrap"><em>価格</em>:' . $content . '</div>';
}
add_shortcode('price', 'shortcode_price');

/**
 * 画像データへのパスを返すショートコード
 */
function shortcode_url(){
    echo get_template_directory_uri();
}
add_shortcode('dir_url', 'shortcode_url');
?>