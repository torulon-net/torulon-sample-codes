<?php
/**
 * プラグイン削除時の動作を定義
 */

// ファイルが直接読み込まれた場合、すぐ終了
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

require_once 'torulon_sample_constants.php';

delete_option(TORULON_SAMPLE_OPTIONS);
