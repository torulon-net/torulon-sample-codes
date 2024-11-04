<?php
/**
 * 共通関数を定義する
 */

// ファイルが直接読み込まれた場合、すぐ終了(プラグイン内全てのPHPファイルの先頭に書き込む)
if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('torulon_sample_get_default_options')) {
  /**
   * 設定のデフォルト値取得
   * @return string[]
   */
  function torulon_sample_get_default_options(): array {
    return [
      'option1' => '',
      'option2' => '',
      'option3' => '',
    ];
  }
}

