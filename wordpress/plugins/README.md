# Wordpressプラグイン

---
## プラグイン作成方法
[公式マニュアル](https://developer.wordpress.org/plugins/plugin-basics/)
1. ディレクトリ作成(プラグインが単一ファイルの場合はディレクトリ作成は不要)
2. ディレクトリ名と同名の.phpファイル作成
3. 作成したPHPファイルの先頭に下記コメントを必要な部分だけ追加
(詳細は [Header Requirements](https://developer.wordpress.org/plugins/plugin-basics/header-requirements/) 参照)
```php
<?php
/**
 * プラグイン名
 *
 * @package パッケージ名
 * @author 作成者
 * @copyright コピーライト
 * @license ライセンス
 *
 * @wordpress-plugin
 * Plugin Name: プラグイン名
 * Plugin URI: プラグインの説明や配布しているページのURL
 * Description: プラグインの説明
 * Version: プラグインのバージョン
 * Requires at least: 必要最低限のWordpressのバージョン
 * Requires PHP: 必要最低限のPHPバージョン
 * Author: 開発者名
 * Author URI: 開発者のサイトURL
 * License: ライセンス
 * License URI: ライセンスの記載があるページのURL
 * Text Domain: 国際化するためのTEXTドメイン名
 * Domain Path: 国際化するための翻訳ファイルのパス
 * Network: ネットワーク経由でのみアクティベーションを行う場合は true、普通は省略
 * Update URI: プラグインアップデートURL
 * Requires Plugins: 依存関係にあるプラグインリスト
 */
```
ここまでの内容を、[WordpressRoot]/wp-content/plugins/ 配下に配置するだけで、管理画面で認識してくれる

---

参照: [Best Practices](https://developer.wordpress.org/plugins/plugin-basics/best-practices/)
## プラグイン内コード記述の基本作法

- 他のプラグインと競合しないように命名規則として必ずPrefixをつける
- 変数、関数などを定義する際は必ず重複チェックをする
    - 変数: isset()
    - 関数: function_exists()
    - クラス: class_exists()
    - 定数: defined()
- 必ずフックを利用して実行する
- 可能であれば、ファイル読み込み、定義などは条件付きで行う
```php
// 例えば、管理画面のみ実行される内容は is_admin() を使う
if (is_admin()) {
  require_once 'admin/plugin-name-admin.php';
}
```
- PHPコードの先頭にはファイルが直接実行されないように下記のコードを記述する
```php
if (!defined('ABSPATH')) {
  exit;
}
```

## ディレクトリ構造
### Best Practices
必要に応じて加減する
```
/plugins
    /plugin-name
         plugin-name.php
         uninstall.php
         /languages
         /includes
         /admin
              /js
              /css
              /images
         /public
              /js
              /css
              /images
```
### 単一ファイル
```
/plugins/plugin-name.php
```

---

## サンプルプラグイン一覧

[torulon_sample_plugin](./torulon_sample_plugin) : プラグイン新規作成の基本サンプル

---