<?php
/**
 * 各種フックを定義する
 */

// ファイルが直接読み込まれた場合、すぐ終了(プラグイン内全てのPHPファイルの先頭に書き込む)
if (!defined('ABSPATH')) {
  exit;
}

if (is_admin()) {
  // 管理画面のみ使用されるフックを定義
  add_action('plugins_loaded', 'torulon_sample_admin_init');
} else {
  // サイト画面で使用されるフックを定義
  // add_action('hook name', 'callback');
  // add_filter('hook name', 'callback');
}
