<?php
/**
 * 管理画面での操作のための関数を定義する
 */

// ファイルが直接読み込まれた場合、すぐ終了(プラグイン内全てのPHPファイルの先頭に書き込む)
if (!defined('ABSPATH')) {
	exit;
}

// 管理画面でのみ実行される関数を定義
if (is_admin()) {
  if (!function_exists('torulon_sample_render_settings')) {
    /**
     * 設定画面描画
     * @return void
     */
    function torulon_sample_render_settings(): void {
      $options = get_option(TORULON_SAMPLE_OPTIONS, torulon_sample_get_default_options());
      $fieldName = TORULON_SAMPLE_OPTIONS;

      echo <<<"ADMIN"
<div class="wrap">
    <h1><span class="dashicons dashicons-admin-generic"></span>トルロンのサンプルプラグイン設定</h1>
    <form method="POST" action="options.php">
        <table class="form-table">
            <tr>
                <th>オプション１</th>
                <td><input size="50" type="text" name="{$fieldName}[option1]" placeholder="オプション１を入力してください" value="{$options['option1']}" class="regular-text" /></td>
            </tr>
            <tr>
                <th>オプション２</th>
                <td><input size="50" type="text" name="{$fieldName}[option2]" placeholder="オプション２を入力してください" value="{$options['option2']}" class="regular-text" /></td>
            </tr>
            <tr>
                <th>オプション３</th>
                <td><input size="50" type="text" name="{$fieldName}[option3]" placeholder="オプション３を入力してください" value="{$options['option3']}" class="regular-text" /></td>
            </tr>
        </table>
ADMIN;

      settings_fields(TORULON_SAMPLE_OPTION_GROUP);

      echo <<<ADMIN
        <input type="submit" class="button-primary" value="保存" />
    </form>
</div>
ADMIN;

    }
  }

  if (!function_exists('torulon_sample_init_settings')) {
    /**
     * 設定初期化
     * @return void
     */
    function torulon_sample_init_settings(): void {
      register_setting(TORULON_SAMPLE_OPTION_GROUP, TORULON_SAMPLE_OPTIONS);
    }
  }

  if (!function_exists('torulon_sample_admin_menu')) {
    /**
     * 管理画面メニュー
     * @return void
     */
    function torulon_sample_admin_menu(): void {
      add_menu_page(
        'トルロンのサンプルプラグイン設定',
        'トルロンのサンプルプラグイン設定',
        'administrator',
        'TorulonSamplePluginSettings',
        'torulon_sample_render_settings',
        'dashicons-admin-generic', // https://developer.wordpress.org/resource/dashicons/
        99
      );
    }
  }

  if (!function_exists('torulon_sample_admin_init')) {
    /**
     * 管理画面でプラグイン初期化内容を定義
     * @return void
     */
    function torulon_sample_admin_init(): void {
      add_action('admin_init', 'torulon_sample_init_settings');
      add_action('admin_menu', 'torulon_sample_admin_menu');
    }
  }
}
