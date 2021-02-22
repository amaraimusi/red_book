<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="google" content="notranslate" />
   	<meta http-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Demo | 使い方</title>
	<link rel='shortcut icon' href='/home/images/favicon.ico' />
	
	<link href="../../css/app.css" rel="stylesheet">
	<link href="../../css/common.css" rel="stylesheet">
	
	<script src="../../js/app.js"></script>	<!-- jquery-3.3.1.min.js -->
	<script src="../../js/static_page/livipage.js"></script>
	<script src="../../js/static_page/ImgCompactK.js"></script>

	<style>
	.btn-info{
		margin-bottom:4px;
		color:white;
	}
	</style>
</head>
<body>
<div id="header" ><h1>Demo | 使い方</h1></div>
<div id="container" class="container">


<!-- CrudBase共通ヘルプ -->
<div id="help_csh" >
<div class="help_x">

	このページでは各管理画面で共通する機能の使い方を説明します。<br>
	画面特有の機能については説明していません。
	画面によっては当ページで説明されている機能が存在しない場合もあります。<br>
	<br>
	
	<div id="help_x_div1">
		<a href="#crudbase_help2" class="livipage btn btn-info btn-sm">追加/編集/複製/削除/抹消</a>
		<a href="#crudbase_help3" class="livipage btn btn-info btn-sm">検索/詳細検索/初期戻し機能</a>
		<a href="#crudbase_help5" class="livipage btn btn-info btn-sm">列表示切替機能</a>
		<a href="#crudbase_help13" class="livipage btn btn-info btn-sm">CSVエスポート機能</a>
		<a href="#crudbase_help14" class="livipage btn btn-info btn-sm">一括追加機能</a>
		<a href="#crudbase_help6" class="livipage btn btn-info btn-sm">セッションクリア機能</a>
		<a href="#crudbase_help7" class="livipage btn btn-info btn-sm">スマホ用一覧</a>
		<a href="#crudbase_help8" class="livipage btn btn-info btn-sm">ページネーション</a>
		<a href="#crudbase_help9_0" class="livipage btn btn-info btn-sm">削除した行を復元(有効化）する | または完全抹消する</a>
		<a href="#crudbase_help9" class="livipage btn btn-info btn-sm">まとめて削除</a>
		<a href="#crudbase_help9_2" class="livipage btn btn-info btn-sm">まとめて復元（有効）</a>
		<a href="#crudbase_help10" class="livipage btn btn-info btn-sm">ソート機能</a>
		<a href="#crudbase_help11" class="livipage btn btn-info btn-sm">行入替機能</a>
		<a href="#crudbase_help_err" class="livipage btn btn-info btn-sm">よくあるエラー対処法</a>
		<a href="#crudbase_help_version" class="livipage btn btn-info btn-sm">バージョン</a>
		
	</div>
	<hr>

	<div id="crudbase_help2">
	<h4>追加/編集/複製/削除/抹消</h4>
	一覧の基本操作として新規追加、編集、複製、削除、抹消があります。<br>
	各行の最右側にこれらのボタンは表示されています。<br> 
	<img src="img/help_a1.png" alt="追加/編集/複製/削除/抹消" class="img_compact_k" />
	<br> 
	
	「ボタン設定」からボタンのサイズや表示を切り替えることができます。<br> 
	「ボタン設定」はツールボックス内の「設定」からアクセスできます。<br> 
	<img src="img/help_a2.png" alt="ボタン設定" class="img_compact_k" /><br>
	<br> 
	
	「削除」は削除フラグをONにするだけで実際にDBから消去するわけではありません。<br>
	「抹消」はデータそのものをデータベースから消去します。 削除フラグがONのデータのみ抹消できます。
	つまり一度削除してから抹消という流れになります。
	<a href="#crudbase_help9_0" class="livipage">(参考：削除した行を復元(有効化）する | または完全抹消する)</a>
	<br>
	「複製」機能は文字通りその行を複製する機能です。<br>
	</div>
	<hr>
	
	<div id="crudbase_help3">
	<h4>検索/詳細検索/初期戻し機能</h4>
	検索機能は2種類あり、メインの検索と詳細検索から構成されています。<br>
	メイン検索はいくつかの主要な項目を検索対象にしています。（各画面により異なります）
	詳細検索は各列ごとに細かい検索指定ができます。<br>
	<br>
	
	<div style="margin-left:20px;">
		<strong>リセットボタン</strong>(初期戻し機能)<br>
		最初にページを開いた時の状態に戻す機能です。
		メイン検索のとなりにあるリセットボタンを押すと、検索されている状態やソートされている状態をリセットして最初に画面を表示していた時の状態に戻すことができます。<br>
	</div><br>
	<img src="img/help_a3.png" alt="初期戻し機能" class="img_compact_k" /><br>
	</div>
	<hr>
		
	
	<div id="crudbase_help5">	
	<h4>列表示切替機能について</h4>
	一覧の列を表示したり隠したりすることができます。<br>
	列並替ボタンからは、列の並び替えができます。<br>
	一覧の行が500件を超えると、表示速度の都合で当機能はオフになります。<br>
	<br>
	<img src="img/help_a4.png" alt="列表示切替機能" class="img_compact_k" /><br>
	</br>

	<p>「列表示を保存」ボタン</p>
	現在の列表示状態を保存します。<br>
	画面を閉じても列表示状態は保持されます。<br>
	「初期に戻す」ボタンを押すと保存状態はクリアされます。<br>
	
	<p>「すべてチェック」ボタン</p>
	すべての列を表示します。<br>

	<p>「初期に戻す」ボタン</p>
	列表示を初期に戻します。<br>
	また「列表示を保存」ボタンによる保存状態も解除します。<br>
	<br>
	
	</div><hr>
		
		
	<div id="crudbase_help13">
		<h4>CSVエスポート機能</h4>
		一覧をCSV形式でダウンロードできます。<br>
		CSVエクスポートボタンはツール内に存在します。<br>
		<br>
		出力されるCSVデータは検索状態が反映されます。つまり特定の項目で絞り込んだデータだけをCSV出力するということが可能です。<br>
		<br>
		画面上の一覧とは異なり行数制限の影響をうけません。
		画面上の一覧は検索結果数が多い場合、行数制限がかけられ代わりにページ目次が表示されます。
		ですがCSVダウンロードはすべての行を出力します。（ページ目次の概念はありません）<br>
		<br>
		列表示切替機能による列表示/非表示の影響は受けません。隠れている列もCSV出力されます。<br>
		<br>
	</div><hr>
		
		
	<div id="crudbase_help14">
		<h4>一括追加機能</h4>
		
		複数の行を一括で入力できる機能です。<br>
		Excelやスプレットシートなどからコピーしたデータを張り付けて入力できます。
		プレビューが先に表示されますので、DB登録前に確認が可能です。<br>
		<img src="img/help_a5.png" alt="一括追加機能" class="img_compact_k" /><br>
		</br>

	</div><hr>
		
		
	<div id="crudbase_help7">
		<h4>スマホ用一覧</h4>
		一覧表示は2タイプあり、行列型と縦型が存在します。<br>
		行列型はPC向けであり、一般的な列と行からなるテーブル構造です。
		縦型はスマホ向けであり各項目を縦に並べます。なお、スマホで画面を開くと自動的に縦型になります。<br>
		ツール内の「一覧の変形・区分モード」ボタンを押すと切替ができます。<br>
		<br>
		<img src="img/help_a7.png" alt="一覧の変形・区分モード" class="img_compact_k" /><br>
		</br>
	</div><hr>
	
	
	<div id="crudbase_help6">
	<h4>セッションクリアボタン</h4>
	デバッグモードの場合のみ表示されます。<br>
	この画面に関係するセッションをすべてクリアします。<br>
	当システムのバージョンアップによる不具合が生じたときに押します。<br>
	<img src="img/help_a6.png" alt="一括追加機能" class="img_compact_k" /><br>
	</br>
	</div><hr>
		
		
	<div id="crudbase_help8">
		<h4>ページネーション</h4>
		一度に表示する行は制限されています。<br>
		そのため検索結果数が多い場合、ページ分割されると共にページ目次が表示されます。<br>
		なお、表示する行数は詳細検索にて指定できます。(表示行数を選択して検索を行います)<br>
		指定ページにジャンプ移動できるページジャンプ機能も備えています。<br>
		<img src="img/help_a8.png" alt="一括追加機能" class="img_compact_k" /><br>
	</div><hr>
		
		
	<div id="crudbase_help9_0">
		<h4>削除した行を復元(有効化）する | または完全抹消する</h4>
		
		一覧の各行に存在する「削除」ボタンを押すとその行は消えますが、実際は削除状態になっているだけであり、DBから抹消されているわけではありません。<br>
		ですので削除状態にある行を元に戻して復元することが可能です。
		また、DBから完全抹消することもできます。（抹消すると復元できなくなります）<br>
		<br>
		
		復元もしくは完全抹消したい場合、まず「削除」で検索して削除状態になっている行を一覧表示させる必要があります。
		削除状態になっている行を一覧表示するには、詳細検索から「有効/削除」のセレクトボックスを「削除」もしくは「すべて表示」にして検索ボタンを押します。<br>
		すると一覧の各行に「有効」ボタンと、「抹消」ボタンが表示されます。<br>
		<br>
		
		復元する場合「有効」ボタンを押します。<br>
		DBから完全抹消する場合は、「抹消」ボタンを押します。<br>
		<br>
		
		
		<img src="img/help_a9.png" alt="削除した行を復元(有効化）する | または完全抹消する" class="img_compact_k" /><br>
		<br>
		
		<aside>画面によっては「抹消」ボタンは非表示設定されていることがあります。その場合、ボタン設定で「抹消」ボタンを表示に切り替えます。</aside>
		
	</div><hr>
	

		
		
	<div id="crudbase_help9">
		<h4>まとめて削除</h4>
		一覧の行をまとめて削除する機能です。<br>
		ID列左側に存在するチェックボックスにチェックを入れ、一覧の下にある「削除」ボタンを押します。<br>
		※となりにある「有効」ボタンは削除したデータをまとめて復元するときに使用します。<br>
	</div><hr>
		
		
	<div id="crudbase_help9_2">
		<h4>まとめて復元（有効）</h4>
		削除したデータをまとめて復元する機能です。<br>
		まずは、削除状態にある行を一覧表示させる必要があります。<br>
		削除状態の行を表示させるには、詳細検索から「有効」となっている箇所を「削除」に切り替えて検索します。<br>
		<br>
		削除状態の行が一覧表示されましたら、ID列左側に存在するチェックボックスにチェックを入れます。<br>
		そして一覧の下にある「有効」ボタンを押すると削除状態の行が有効化、つまり復元されます。<br>
	</div><hr>
	
	
	
		
		
	<div id="crudbase_help10">
		<h4>ソート機能</h4>
		一覧の列名リンクをクリックするとその列のデータで昇順並べ替えを行えます。<br>
		もう一度クリックすると降順並べ替えになります。<br>
		並べ替え状態は上部メニューに存在する「リセット」ボタンを押すと解除することができます。（並べ替える前の状態に戻ります）<br>
	</div><hr>
		
		
	<div id="crudbase_help11">
		<h4>行入替機能</h4>
		一覧の左側に存在する<span class="btn btn-info btn-sm">↑↓</span>ボタンをクリックを押すと、
		行入替フォームが現れ、行を上下に移動させたり、指定位置にジャンプさせたりできます。<br>
		
		<p class="text-danger">注意</p>
		この機能は「順番」で昇順ソートしている場合のみ有効です。
		他の列でソートしている状態だと<span class="btn btn-info btn-sm">↑↓</span>ボタンは表示されません。<br>
		<br>
		
	</div><hr>
	

</div>
</div>

<br>
<hr>

<div id="crudbase_help_err">
<h4 style="color:#de5347">エラー対処法</h4>

<p>よく起こるエラー：ログイン切れ</p>
今まで正常であったのに突然、ボタンを押しても反応しなかったり、エラーが表示されたりする場合、ログインが切れている可能性があります。<br>
再度ログインしなおしてください。<br>
<br>

<p>バージョンアップ直後のバグ</p>
当システムのバージョンアップ直後は、ブラウザに保存されている古いデータのためエラーが起きることがあります。<br>
列表示切替機能の「リセット」ボタンおよび「セッションクリア」ボタンを押したのち、ブラウザをリロードしてください。<br>
ブラウザのCookie消去でも解決します。<br>
<br>
</div>

<div id="crudbase_help_version">
<p>バージョン情報</p>
ヘルプの更新日: 2020年9月<br>
<br>
</div>



</div><!-- content -->
<div id="footer">(C) kenji uehara 2020-9-12</div>
</body>
</html>