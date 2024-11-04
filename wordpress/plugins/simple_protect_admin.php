<?php
/**
 * Plugin Name: トルロンの簡単Admin保護プラグイン
 * Description: *ファイルの書き込み権限が必要*①ログインURLの変更②サイト画面で管理バーを非表示③管理者以外管理画面にアクセス不可
 * Version: 1.0.0
 * Requires at least: 6.2.2
 * Requires PHP: 8.3
 * Author: torulon@torulon.net
 * License: Free
 */

if (!defined('ABSPATH')) {
  exit;
}

require_once wp_normalize_path(ABSPATH).'wp-includes/pluggable.php';

if (!defined('SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE')) {
  /**
   * ログインページ変更、「XXXXXXXXXX.php」部分を変更予定のログインページに書き換えること
   */
  define('SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE', 'XXXXXXXXXX.php');
}

if (!defined('SIMPLE_PROTECT_ADMIN_LOGIN_SECRET')) {
  /**
   * ログインページ変更、【秘密の単語】部分を任意の単語に書き換えること
   */
  define('SIMPLE_PROTECT_ADMIN_LOGIN_SECRET', '【秘密の単語】');
}

if (!function_exists('simple_protect_admin_changed_login_init')) {
  /**
   * 変更されたログインページ以外からログインしようとした場合、ホーム画面に強制リダイレクト
   * @return void
   */
  function simple_protect_admin_changed_login_init(): void {
    if (!defined('SIMPLE_PROTECT_ADMIN_HASH') || sha1(SIMPLE_PROTECT_ADMIN_LOGIN_SECRET) != SIMPLE_PROTECT_ADMIN_HASH) {
      wp_safe_redirect(home_url());
      wp_die();
    }
  }
}
add_action('login_init', 'simple_protect_admin_changed_login_init');

if (!function_exists('simple_protect_admin_changed_login_site_url')) {
  /**
   * site_url()関数が呼ばれた時、wp-login.phpを新しいページにURLを変更
   * @param $url
   * @param $path
   * @param $orig_scheme
   * @param $blog_id
   *
   * @return string
   */
  function simple_protect_admin_changed_login_site_url($url, $path, $orig_scheme, $blog_id): string {
    return str_replace('wp-login.php', SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE, $url);
  }
}
add_filter('site_url', 'simple_protect_admin_changed_login_site_url', 10, 4);

if (!function_exists('simple_protect_admin_changed_login_network_site_url')) {
  /**
   * network_site_url()関数が呼ばれた時、wp-login.phpを新しいページにURLを変更
   * @param $url
   * @param $path
   * @param $scheme
   *
   * @return string
   */
  function simple_protect_admin_changed_login_network_site_url($url, $path, $scheme = null): string {
    return str_replace('wp-login.php', SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE, $url);
  }
}
add_filter('network_site_url', 'simple_protect_admin_changed_login_network_site_url', 10, 3);

if (!function_exists('simple_protect_admin_changed_login_wp_redirect')) {
  /**
   * wp_redirect()関数が呼ばれた時、wp-login.phpを新しいページにURLを変更
   * @param $location
   * @param $status
   *
   * @return string
   */
  function simple_protect_admin_changed_login_wp_redirect($location, $status): string {
    if (str_contains($_SERVER['REQUEST_URI'], SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE)) {
      $location = str_replace('wp-login.php', SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE, $location);
    }
    return $location;
  }
}
add_filter('wp_redirect', 'simple_protect_admin_changed_login_wp_redirect', 10, 2);

// ログインユーザーに対しての操作
if (is_user_logged_in()) {
  if (!is_admin()) {
    // ログイン後、サイト画面の管理バーを非表示にする
    add_filter('show_admin_bar', '__return_false');
  } elseif (!current_user_can('manage_options')) {
    // 管理者権限が無いユーザーが管理画面にアクセスしたら、処理を強制終了し、ホーム画面に強制リダイレクト
    ob_end_clean();
    header('Location: '.site_url());
    exit;
  }
}

if (!function_exists('simple_protect_admin_activation')) {
  /**
   * プラグインの有効化時、新しいログイン画面を生成する
   * ファイルの書き込み権限が必要
   * @return void
   */
  function simple_protect_admin_activation(): void {
    $keyword = SIMPLE_PROTECT_ADMIN_LOGIN_SECRET;
    $text = <<<TEXT
<?php
define('SIMPLE_PROTECT_ADMIN_HASH', sha1('$keyword'));
require_once './wp-login.php';
TEXT;

    @file_put_contents(wp_normalize_path(ABSPATH).'/'.SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE, $text);
  }
}
register_activation_hook(__FILE__, 'simple_protect_admin_activation');

if (!function_exists('simple_protect_admin_deactivation')) {
  /**
   * プラグインの無効化時、新しいログイン画面を削除する
   * @return void
   */
  function simple_protect_admin_deactivation(): void {
    if (file_exists(wp_normalize_path(ABSPATH).'/'.SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE)) {
      unlink(wp_normalize_path(ABSPATH).'/'.SIMPLE_PROTECT_ADMIN_CHANGED_LOGIN_PAGE);
    }
  }
}
register_deactivation_hook(__FILE__, 'simple_protect_admin_deactivation');
