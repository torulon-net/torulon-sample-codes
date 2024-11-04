<?php
/**
 * Plugin Name: トルロンのWordpressサンプルプラグイン
 * Description: Wordpressのプラグイン作成のサンプルコード
 * Version: 1.0.0
 * Requires at least: 6.2.2
 * Requires PHP: 8.3
 * Author: torulon@torulon.net
 * License: Free
 */

// ファイルが直接読み込まれた場合、すぐ終了(プラグイン内全てのPHPファイルの先頭に書き込む)
if (!defined('ABSPATH')) {
  exit;
}

// Wordpressの基本的な関数群を読み込む
require_once wp_normalize_path(ABSPATH).'wp-includes/pluggable.php';
// プラグイン内で使う定数を定義したファイルを読み込む
require_once 'torulon_sample_constants.php';
// プラグイン内で使う共通関数を定義したファイルを読み込む
require_once 'torulon_sample_functions.php';
// 管理画面操作関連関数を定義したファイルを読み込む
require_once 'torulon_sample_admin.php';
// 各種フックを設定するファイルを読み込む
require_once 'torulon_sample_hooks.php';

// プラグインが有効化されるとき実行される
register_activation_hook(__FILE__, function() {
  add_option(TORULON_SAMPLE_OPTIONS, torulon_sample_get_default_options());
});
// プラグインが無効化されるとき実行される
register_deactivation_hook(__FILE__, function() {
  delete_option(TORULON_SAMPLE_OPTIONS);
});
// サンプルここまで