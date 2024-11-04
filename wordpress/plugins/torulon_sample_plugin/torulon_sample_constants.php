<?php
/**
 * プラグイン内で利用する定数を定義する
 */

// ファイルが直接読み込まれた場合、すぐ終了(プラグイン内全てのPHPファイルの先頭に書き込む)
if (!defined('ABSPATH')) {
  exit;
}

if (!defined('TORULON_SAMPLE_OPTION_GROUP')) {
  /**
   * 設定グループ名
   */
  define('TORULON_SAMPLE_OPTION_GROUP', 'torulon_sample_option_group');
}

if (!defined('TORULON_SAMPLE_OPTIONS')) {
  /**
   * 設定の名称
   */
  define('TORULON_SAMPLE_OPTIONS', 'torulon_sample_options');
}
