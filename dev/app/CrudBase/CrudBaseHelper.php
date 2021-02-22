<?php


/**
 * CrudBase用ヘルパー
 * 
 * @note
 * 検索条件入力フォームや、一覧テーブルのプロパティのラッパーを提供する
 * 2.0.0よりCakeからの依存から離脱
 * 
 * @version 2.0.2
 * @since 2016-7-27 | 2020-9-17
 * @author k-uehara
 * @license MIT
 */
class CrudBaseHelper {
	
	private $crudBaseData;

	private $_dateTimeList=[]; // 日時選択肢リスト
	
	// 列並びモード用
	private $_clmSortTds = []; // 列並用TD要素群
	private $_clmSortMode = 0;		// 列並モード 0:OFF, 1:ON
	private $_fieldData;			// フィールドデータ
	private $kjs; // 検索条件情報
	
	
	/**
	 * コンストラクタ
	 * @param [] $crudBaseData CrudBaseデータ
	 */
	public function __construct(&$crudBaseData){
		$this->crudBaseData = $crudBaseData;
		$this->_fieldData = $crudBaseData['fieldData'];
		$this->kjs = $this->crudBaseData['kjs'];
	}
	
	/**
	 * 初期化
	 * 
	 * @param array $param パラメータ
	 *  - model_name	モデル名（キャメル記法）
	 *  - bigDataFlg	巨大データフラグ
	 *  - debug_mode	デバッグモード
	 *  
	 */
	public function init($param = []){

		// モデル名関連の設定
		$model_name = $param['model_name'];
		
	}

	
	/**
	 * CSSファイルリストを取得する
	 * @return array CSSファイルリスト
	 */
	public function getCssList(){
		
		
		return [
			'bootstrap.min',
			'bootstrap-theme.min',
			'jquery-ui.min',
			'Layouts/default',
			'CrudBase/dist/CrudBase.min.css?ver=3.0.5',
		];
	}
	
	/**
	 * JSファイルのインクルード
	 */
	public function getJsList(){
		return array(
				'jquery-2.1.4.min',
				'bootstrap.min',
				'jquery-ui.min',
				'vue.min.js',
				'Layouts/default',
				'CrudBase/dist/CrudBase.min.js?ver=3.0.5',
				
		);
	}
	
	/**
	 * スネーク記法のモデル名を取得する
	 * @return string スネーク記法のモデル名
	 */
	public function getModelNameSnk(){
		return $this->crudBaseData['model_name_s'];
	}
	
	
	
	/**
	 * 検索用のid入力フォームを作成
	 * 
	 * @param string $field フィールド名（省略可）
	 * @param string $wamei フィールド和名（省略可）
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - int maxlength 最大文字数(共通フィールドは設定不要）
	 *  - string model_name_c モデル名（キャメル記法）
	 *  - string placeholder
	 * 
	 * 
	 */
	public function inputKjId($field='kj_id', $wamei='ID', $width=100, $title=null, $option = []){
		
		if($title===null) $title = $wamei."で検索";
		
		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		// maxlengthがデフォルト値のままなら、共通フィールド用のmaxlength属性値を取得する
		$maxlength=0;
		if(empty($option['maxlength'])){
			$maxlength = 8;
		}else{
			$maxlength=$option['maxlength'];
		}
		
		$placeholder = '';
		if(empty($option['placeholder'])){
			$placeholder = $wamei;
		}else{
			$placeholder = $option['placeholder'];
		}

		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}'>
				<div class='input text'>
					<input 
						name='data[{$model_name_c}][{$field}]' 
						id='{$field}' 
						value='{$this->kjs[$field]}' 
						placeholder='{$placeholder}' 
						style='width:{$width}px' 
						class='kjs_inp' 
						title='{$title}' 
						maxlength='{$maxlength}' 
						type='text'>
				</div>
				<span id='kj_id_err' class='text-danger'></span>
			</div>
		";
		
		echo $html;
				
	}
	
	
	/**
	 * メイン検索の入力フォームを作成
	 *
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - int maxlength 最大文字数(共通フィールドは設定不要）
	 *  - string model_name_c モデル名（キャメル記法）
	 *  - string placeholder
	 */
	public function inputKjMain($field, $wamei, $width=200,$title=null, $option = []){

		if($title===null) $title = $wamei."で検索";
		
		// maxlengthがデフォルト値のままなら、共通フィールド用のmaxlength属性値を取得する
		$maxlength=1000;
		if(empty($option['maxlength'])){
			$maxlength = $this->getMaxlenIfCommonField($field,$maxlength);
		}else{
			$maxlength=$option['maxlength'];
		}
		

		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		
		$placeholder = '';
		if(empty($option['placeholder'])){
			$placeholder = $wamei;
		}else{
			$placeholder = $option['placeholder'];
		}
		
		$html = "
			<div class='' data-field='{$field}' style='display:inline-block'>
				<div class='input search'>
					<input 
						name='data[{$model_name_c}][{$field}]' 
						id='{$field}' 
						value='{$this->kjs[$field]}'
						 placeholder='{$placeholder}' 
						style='width:{$width}px; ' 
						class='kjs_inp' 
						title='{$title}' maxlength='{$maxlength}' type='search' />
				</div>
			</div>
		";
		
		echo $html;

	}
	
	
	/**
	 * メイン検索の入力フォームを作成
	 *
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - int maxlength 最大文字数(共通フィールドは設定不要）
	 *  - string model_name_c モデル名（キャメル記法）
	 *  - string placeholder
	 */
	public function inputKjText($field, $wamei, $width=200, $title=null, $option = []){
		
		if($title===null) $title = $wamei."で検索";
		
		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		// maxlengthがデフォルト値のままなら、共通フィールド用のmaxlength属性値を取得する
		$maxlength=1000;
		if(empty($option['maxlength'])){
			$maxlength = $this->getMaxlenIfCommonField($field,$maxlength);
		}else{
			$maxlength=$option['maxlength'];
		}
		
		$placeholder = '';
		if(empty($option['placeholder'])){
			$placeholder = $wamei;
		}else{
			$placeholder = $option['placeholder'];
		}
		
		
		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}'>
				<div class='input text'>
					<input 
						name='data[{$model_name_c}][{$field}]' 
						id='{$field}' 
						value='{$this->kjs[$field]}' 
						placeholder='{$placeholder}' 
						class='kjs_inp' 
						style='width:{$width}px; '
						title='{$title}' 
						maxlength='{$maxlength}' 
						type='text'>
				</div>
				<span id='{$field}_err' class='text-danger'></span>
			</div>
		";
		
		echo $html;
	}
	
	/**
	 * 共通フィールド用のmaxlength属性値を取得する
	 * 
	 * @param string $field フィールド名
	 * @return maxlength属性値;
	 */
	private function getMaxlenIfCommonField($field,$maxlength){
		
		if($field == 'kj_update_user'){
			$maxlength = 50;
		}else if($field == 'kj_user_agent'){
			$maxlength = 255;
		}else if($field == 'kj_ip_addr'){
			$maxlength = 16;
		}
		
		return $maxlength;
	}
	
	
	/**
	 * 検索用のhiddenフォームを作成
	 *
	 * @param string $field フィールド名
	 */
	public function inputKjHidden($field){
		
		$model_name_c = $this->crudBaseData['model_name_c'];
	
		$html = "
			<input type='hidden' 
				name='data[{$model_name_c}][{$field}]' 
				id='{$field}' 
				value='{$this->kjs[$field]}' 
				data-field='{$field}' 
				class='kj_wrap kjs_inp'>
		";

		echo $html;

		
	}
	
	
	
	
	
	/**
	 * 検索用のセレクトフォームを作成
	 * 
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 * @param string $list 選択肢リスト
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - string model_name_c モデル名（キャメル記法）
	 */
	public function inputKjSelect($field, $wamei, $list, $width=null, $title=null, $option = []){
		
		
		$width_style = '';
		if(!empty($width)) $width_style="width:{$width}px";
		
		if($title===null) $title = $wamei . "で検索";

		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		$options_str = ''; // option要素群文字列
		
		$value = $this->kjs[$field];
		foreach($list as $id => $name){
			$selected = '';
			if($id == $value) $selected = 'selected';
			$name = htmlspecialchars($name); // XSSサニタイズ
			$options_str .= "<option value='{$id}' {$selected}>{$name}</option>";
		}
		
		
		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}'>
				<div class='input select'>
					<select name='data[{$model_name_c}][{$field}]' id='{$field}' style='{$width_style}' class='kjs_inp' title='{$title}'>
						<option value=''>-- {$wamei} --</option>
						$options_str
					</select>
				</div>
			</div>
		";

		echo $html;
	}


	
	
	
	/**
	 * 検索用の更新日時セレクトフォームを作成
	 */
	public function inputKjModified(){
	
		$this->inputKjDateTimeA('kj_modified','更新日時');
	}
	
	
	/**
	 * 検索用の日時入力フォームを作成
	 *
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - int maxlength 最大文字数(共通フィールドは設定不要）
	 *  - string model_name_c モデル名（キャメル記法）
	 *  - string placeholder
	 */
	public function inputKjDateTime($field, $wamei, $width=200, $title=null, $option = []){
		
		if($title===null) $title = $wamei."で検索";
		
		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		// maxlengthがデフォルト値のままなら、共通フィールド用のmaxlength属性値を取得する
		$maxlength = 255;
		if(!empty($option['maxlength'])){
			$maxlength=$option['maxlength'];
		}
		
		$placeholder = '';
		if(empty($option['placeholder'])){
			$placeholder = $wamei;
		}else{
			$placeholder = $option['placeholder'];
		}
		
		
		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}' data-gadget='datetimepicker'>
				<div class='input text'>
					<input
						name='data[{$model_name_c}][{$field}]'
						id='{$field}'
						value='{$this->kjs[$field]}'
						placeholder='{$placeholder}'
						class='kjs_inp'
						style='width:{$width}px; '
						title='{$title}'
						maxlength='{$maxlength}'
						type='text'>
				</div>
			</div>
		";
		
		echo $html;
		

	}

	
	
	
	
	/**
	 * 検索用の生成日時セレクトフォームを作成
	 */
	public function inputKjCreated(){
	
		$this->inputKjDateTimeA('kj_created','生成日時');
	}
	

	
	
	
	/**
	 * 検索用の日時セレクトフォームを作成
	 *
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 * @param string $list 選択肢リスト（省略可）
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - string model_name_c モデル名（キャメル記法）
	 */
	public function inputKjDateTimeA($field, $wamei, $list=[], $width=200 ,$title=null, $option = []){
	
		$width_style = '';
		if(!empty($width)) $width_style="width:{$width}px;";
		
		if($title===null) $title = $wamei . "で検索";
		
		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		if(empty($list)) $list = $this->getDateTimeList();
		
		$d1 = $this->kjs[$field];
		$u1 = strtotime($d1);

		// option要素群
		$options_str = ''; // option要素群文字列
		foreach($list as $d2 => $name){
			
			$selected = '';
			$u2 = strtotime($d2);
			if(!empty($u1)){
				if($u1 == $u2) $selected = 'selected';
			}
			
			$name = htmlspecialchars($name); // XSSサニタイズ
			$options_str .= "<option value='{$d2}' $selected>{$name}</option>";
		}
		
		$sub_info_str = '';
		if(!empty($d1)) $sub_info_str = "<div class='text-danger'>検索対象 ～{$d1}</div>";
		
		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}'>
				<div class='input select'>
					<select name='data[{$model_name_c}][{$field}]' id='{$field}' style='{$width_style}' class='kjs_inp' title='{$title}'>
						<option value=''>-- {$wamei} --</option>
						{$options_str}
					</select>
				</div>
				{$sub_info_str}
			</div>
		";
		
		echo $html;
		
	}
	
	
	
	
	
	/**
	 * 検索用の削除フラグフォームを作成
	 *
	 * @param string $field フィールド名（省略可）
	 * @param string $wamei フィールド和名（省略可）
	 * @param int $width 入力フォームの横幅（省略可）
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - string model_name_c モデル名（キャメル記法）
	 * 
	 * 
	 */	
	public function inputKjDeleteFlg($field='kj_delete_flg', $wamei='削除', $width=null, $title=null, $option = []){
		if($title===null) $title = $wamei."で検索";
		
		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		$width_style='';
		if(!empty($width)) $width_style="width:{$width}px;";
		
		$list = [
				'-1' => 'すべて表示',
				'0' => '有効',
				'1' => '削除',
		];
		
		// SELECT選択肢の組み立て
		$exist_value = $this->kjs[$field];
		$option_html = '';
		foreach($list as $key => $value){
			$selected = '';
			if($key == $exist_value) $selected = " selected='selected'";
			$option_html .= "<option value='{$key}' {$selected}>{$value}</option>";
		}
		
		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}'>
				<span>有効/削除</span>
				<div class='input select' style='display:inline-block'>
					<select name='data[{$model_name_c}][{$field}]' id='{$field}' class='kjs_inp' title='{$title}' style='{$width_style}'>
						{$option_html}
					</select>
				</div>
			</div>
		";
		
		echo $html;

	}
	
	
	
	
	
	/**
	 * 検索用のフラグフォームを作成
	 *
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 * @param string $title ツールチップメッセージ（省略可）
	 * @param [] option
	 *  - string model_name_c モデル名（キャメル記法）
	 *
	 */
	public function inputKjFlg($field, $wamei, $title=null, $option = []){
		
		if($title===null) $title = $wamei."で検索";
		
		// モデル名を取得
		$model_name_c = $this->crudBaseData['model_name_c'];
		if(!empty($option['model_name_c'])) $model_name_c = $option['model_name_c'];
		
		
		$list = [
				'-1' =>"-- {$wamei} --",
				'0' => 'OFF',
				'1' => 'ON',
		];
		
		// SELECT選択肢の組み立て
		$exist_value = $this->kjs[$field];
		$option_html = '';
		foreach($list as $key => $value){
			$selected = '';
			if($key == $exist_value) $selected = " selected='selected'";
			$option_html .= "<option value='{$key}' {$selected}>{$value}</option>";
		}
		
		$html = "
			<div class='kj_div kj_wrap' data-field='{$field}'>
				<div class='input select'>
					<select name='data[{$model_name_c}][{$field}]' id='{$field}' class='kjs_inp' title='{$wamei}'>
						{$option_html}
					</select>
				</div>
			</div>
		";
		
		echo $html;
		
	}
	
	
	
	
	
	/**
	 * 検索用の表示件数セレクトを作成
	 */	
	public function inputKjLimit(){

		$model_name_c = $this->crudBaseData['model_name_c'];
		
		$list = [
				'5' =>"5件表示",
				'10' =>"10件表示",
				'20' =>"20件表示",
				'50' =>"50件表示",
				'100' =>"100件表示",
				'200' =>"200件表示",
				'500' =>"500件表示",
				];
		
		// SELECT選択肢の組み立て
		$exist_value = $this->crudBaseData['pages']['row_limit'];
		$option_html = '';
		foreach($list as $key => $value){
			$selected = '';
			if($key == $exist_value) $selected = " selected='selected'";
			$option_html .= "<option value='{$key}' {$selected}>{$value}</option>";
		}
		
		$html = "
			<div class='kj_div kj_wrap' data-field='row_limit'>
				<div class='input select'>
					<select name='data[{$model_name_c}][row_limit]' id='row_limit' style='height:27px' class='kjs_inp'>
						{$option_html}
					</select>
				</div>
			</div>
		";
		
		echo $html;
		
	}
	
	
	
	
	
	
	
	
	
	/**
	 * 月・日付範囲検索
	 *
	 * @param string $field フィールド名
	 * @param string $wamei フィールド和名
	 */
	public function inputKjMoDateRng($field,$wamei){
		
		$kjs = $this->crudBaseData['kjs'];

		// 年月を取得
		$kj_field_ym = $field . '_ym';
		$ym = $kjs[$kj_field_ym];
		
		$kj_field1 = $field . '1';
		$date1 =  $kjs[$kj_field1];
		
		$kj_field2 = $field . '2';
		$date2 =  $kjs[$kj_field2];
		
		echo "<div id='{$field}' class='range_ym_ex' data-wamei='{$wamei}' data-def-ym='{$ym}' data-def1='{$date1}' data-def2='{$date2}' style='margin-right:40px'></div>";
		
	}
	
	
	
	
	
	
	
	/**
	 * 
	 * 検索用の年月入力フォームを作成
	 * 
	 * @param string $field フィールド名（ kj_ を付けないこと）
	 * @param string $wamei フィールド和名
	 */
	public function inputKjNumRange($field, $wamei, $option=[]){
		
		$kj_field1 = "kj_{$field}1";
		$kj_field2 = "kj_{$field}2";
		$value1 = $this->kjs[$kj_field1];
		$value2 = $this->kjs[$kj_field2];
		
		// テキストの幅を自動指定する
		$str_len = mb_strlen($wamei);
		$str_len += 3;
		if($str_len < 4) $str_len = 4;
		$width = $str_len . 'em';
		
		echo "
			<div class='kj_div'>
				<div class='input number' style='display:inline-block'>
					<input name='data[Neko][kj_{$field}1]' id='kj_{$field}1' value='{$value1}' 
						class='kjs_inp' placeholder='{$wamei}～' title='{$wamei}～' 
						type='number' style='width:{$width}'>
						<span id='kj_{$field}1_err' class='text-danger'></span>
				</div>
				<span>～</span>
				<div class='input number' style='display:inline-block'>
					<input name='data[Neko][kj_{$field}2]' id='kj_{$field}2' value='{$value2}' 
						class='kjs_inp' placeholder='～{$wamei}' title='～{$wamei}' 
						type='number' style='width:{$width}'>
					<span id='kj_{$field}2_err' class='text-danger'></span>
				</div>
			</div>
		";

	}
	


	
	/**
	 * 特に何もせずのTD要素を出力する。
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdPlain(&$ent,$field){
		
		$v = $ent[$field];
		$td = "<td><input type='hidden' name='{$field}' value='{$v}'  /><span class='{$field}' >{$v}</span></td>\n";
		$this->setTd($td,$field);
	}
	public function tpPlain($v,$wamei){
		$this->tblPreview($v,$wamei);
	}
	

	
	/**
	 * XSS対策を施してからTD要素を出力する。
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdStr(&$ent,$field){
		
		$v = $ent[$field];
		$v = htmlspecialchars($v);
		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}' >{$v}</span></td>\n";
		$this->setTd($td,$field);
	
	}
	public function tpStr($v,$wamei){
		$v = htmlspecialchars($v);
		$this->tblPreview($v,$wamei);
	}
	
	/**
	 * 改行を<br>タグに変換してからTD要素を出力する。（XSS対策有）
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdStrRN(&$ent,$field){
	
		$v = $ent[$field];
		$v = htmlspecialchars($v); // XSS対策
		$v = nl2br($v);// 改行置換
		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}'>{$v}</span>\n";
		$this->setTd($td,$field);
	
	}
	
	
	/**
	 * 
	 * ＩＤのTD要素を出力する。（XSS対策有）
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名（省略可）
	 * @param array $option オプション
	 *  - checkbox_name チェックボックス名プロパティ   このプロパティに値をセットすると、複数選択による一括処理用のチェックボックスが作成される。
	 */
	public function tdId(&$ent,$field='id',$option=[]){
		
		$v = $ent[$field];
		
		// 複数選択による一括処理用のチェックボックスHTMLを組み立てる
		$cbHtml = ''; // チェックボックスHTML
		if(!empty($option['checkbox_name'])){
			$cbHtml = "<input type='checkbox' name='{$option['checkbox_name']}' /> ";
		}
		
		// TD要素を組み立てる
		$td = "<td>{$cbHtml}<input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}' >{$v}</span></td>\n";
		
		$this->setTd($td,$field);
		

	}
	public function tpId($v,$wamei='ID'){
		$v = $this->propId($v);
		$this->tblPreview($v,$wamei);
	}	
	

	
	
	/**
	 * 値にひもづくリストの値をTD要素出力する。（XSS対策有）
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param array $list リスト
	 */
	public function tdList(&$ent,$field,$list=[]){
		
		$v = $ent[$field];

		$v2 = $this->propList($v,$list);
		$v2 = htmlspecialchars($v2);
		
		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}'>{$v2}</span></td>\n";
		$this->setTd($td,$field);
	
	}
	public function tpList($v,$wamei,$list){
		$v = $this->propList($v,$list);
		$this->tblPreview($v,$wamei);
	
	}
	/**
	 * プロパティをリスト内の値に置き換える
	 * @param string $v プロパティ
	 * @param array $list リスト
	 * @param valiant リスト内の値
	 */
	public function propList($v,$list){
		
		if(isset($list[$v])){
			$v = $list[$v];
		}else{
			$v="";
		}
		
		return $v;
		
	}
	
	
	
	
	/**
	 * フラグ系TDO出力
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param array $list リスト
	 */
	public function tdFlg(&$ent,$field,$list=array('OFF','ON')){
		
		$v = $ent[$field];
		
		// ▼ 0か1に書き換える
		if($v == null || $v == '') $v = 0;
		if($v != 0) $v = 1;
		
		// ▼ スタイル
		$style = '';
		if($v == 0) $style = 'color:Gray';
		
		$v2 = $list[$v];
		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}' style='{$style}'>{$v2}</span></td>\n";
		$this->setTd($td,$field);
		
	}
	
	
	
	
	
	
	
	
	/**
	 * 値を日本円表記に変換してTD要素を出力する。
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdMoney(&$ent,$field){
		
		$v = $ent[$field];
		$v2 = $this->propMoney($v); // 日本円変換
		
		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}'>{$v2}</span></td>\n";
		$this->setTd($td,$field);
	}
	public function tpMoney($v,$wamei){
		$v = $this->propMoney($v);
		$this->tblPreview($v,$wamei);

	}
	public function propMoney($v){
		if(!empty($v) || $v===0){
			$v= '&yen'.number_format($v);
		}
		
		return $v;
	}
	
	
	/**
	 * リンクを作成する
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param string $url URL	URLの変値部分は「%0」と表記する。
	 */
	public function tdLink(&$ent, $field, $url){
		
		$v = $ent[$field];
		$url2 = str_replace('%0', $v, $url);
		
		$td = "
			<td>
				<input data-custum-type='link' type='hidden' name='{$field}' value='{$v}' />
				<a href='{$url2}' data-url-tmp='{$url}' >{$v}</a>
			</td>";
		$this->setTd($td,$field);
	}
	
	
	/**
	 * リンクを作成する | クエリ別
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param string $q_field クエリ・フィールド名
	 * @param string $url URL	URLの変値部分は「%0」と表記する。
	 */
	public function tdLinkQ(&$ent, $field, $url, $q_field){
		
		$v = $ent[$field];
		$q_v = $ent[$q_field];
		$url2 = str_replace('%0', $q_v, $url);
		
		$td = "
			<td>
				<input data-custum-type='link' type='hidden' name='{$field}' value='{$v}' />
				<a href='{$url2}' data-url-tmp='{$url}' >{$v}</a>
			</td>";
		$this->setTd($td,$field);
	}
	
	
	/**
	 * 外部URL（ホームページURLなど）
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param string $link_text  リンクテキスト(省略するとURLがセットされる）
	 */
	public function tdOuterUrl(&$ent, $field, $link_text=null){
		
		$v = $ent[$field];
		
		if(empty($link_text)){
			$link_text = $v;
		}

		$td = "
			<td>
				<input data-custum-type='link' type='hidden' name='{$field}' value='{$v}' />
				<a href='{$v}' data-url-tmp='{$v}' target='_blank'>{$link_text}</a>
			</td>";
		$this->setTd($td,$field);
	}
	
	
	/**
	 * 長文の冒頭部分だけをTD要素出力する。
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param int $strLen 表示文字数（バイト）(省略時は無制限に文字表示）
	 */
	public function tdNote(&$ent,$field,$str_len = null){
		
		$v = $ent[$field];
		
		$v2="";
		$long_over_flg = 0; // 制限文字数オーバーフラグ
		if(!empty($v)){
			$v = htmlspecialchars($v);
			if($str_len === null){
				$v2 = $v;
			}else{
				if(mb_strlen($v) > $str_len){
					$v2=mb_strimwidth($v, 0, $str_len * 2);
					$long_over_flg = 1;
				}else{
					$v2 = $v;
				}
			}
			$v2= str_replace('\\r\\n', ' ', $v2);
			$v2= str_replace('\\', '', $v2);
		}

		// ノート詳細開きボタンのHTMLを作成
		$note_detail_open_html = '';
		if($long_over_flg) {
			$note_detail_open_html = "<input type='button' class='btn btn-secondary btn-sm note_detail_open_btn' value='...' onclick=\"crudBase.openNoteDetail(this, '{$field}')\" />";
		}
		
		$td = "
			<td>
				<input type='hidden' name='{$field}' value='{$v}' />
				<span class='{$field}'>{$v2}</span>{$note_detail_open_html}
			</td>";
		$this->setTd($td,$field);
	}
	
	
	/**
	 * ノートなどの長文を改行を含めてそのままTD要素出力する。
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdNotePlain(&$ent,$field){
		
		$v = $ent[$field];

		if(!empty($v)){
			$v = htmlspecialchars($v);
			$v=nl2br($v);
		
		}

		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><div class='{$field}' >{$v}</div></td>\n";
		$this->setTd($td,$field);
	}
	public function tpNote($v,$wamei){
	
		if(!empty($v)){
			$v= str_replace('\\r\\n', '<br>', htmlspecialchars($v));
			$v= str_replace('\\', '', $v);
		}
	
		$this->tblPreview($v,$wamei);
	
	}
	
	/**
	 * テキストエリア用の文字列変換
	 * @param string $v 文字列（改行OK)
	 * @return string テキストエリア用に加工した文字列
	 */
	public function convNoteForTextarea($v){
		if(!empty($v)){
		
			//サニタイズされた改行コードを「&#13;」に置換
			$v = str_replace('\\r\\n', '&#13;', htmlspecialchars($v));
			$v = str_replace('\\', '', $v);
		
		}
		
		return $v;
	}
	
	/**
	 * 削除フラグの表記を変換する
	 * 
	 * @param string $v 削除フラグ
	 */
	public function propDeleteFlg($v){
		
		if($v==0){
			$v="<span style='color:#23d6e4;'>有効</span>";
		}elseif($v==1){
			$v="<span style='color:#b4b4b4;'>削除</span>";
		}
		
		return $v;
	}
	
	/**
	 * フラグの表記を変換する
	 *
	 * @param string $v 削除フラグ
	 */
	public function propFlg($v){
		
		if($v==0){
			$v="<span style='color:#b4b4b4;'>無効</span>";
		}elseif($v==1){
			$v="<span style='color:#23d6e4;'>有効</span>";
		}
		
		return $v;
	}
	
	
	public function tdAdd($html,$field){
		$this->setTd($html,$field);
	}
	
	
	/**
	 * 削除フラグを有効/無効の表記でTD要素出力する。
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdDeleteFlg(&$ent,$field){
		
		$v = $ent[$field];
		if(empty($v)) $v = 0;
		
		$v2 = $this->propDeleteFlg($v);
		$td = "<td><input type='hidden' name='{$field}' value='{$v}' /><span class='{$field}'>{$v2}</span></td>\n";
		
		$this->setTd($td,$field);
	}
	public function tpDeleteFlg($v,$wamei='削除フラグ'){
		$v = $this->propDeleteFlg($v);
		
		$this->tblPreview($v,$wamei);

	}
	
	/**
	 * 画像TD要素出力 1型
	 * 値は画像ファイルパスの方式に対応
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 * @param string $midway_dp 中間ディレクトリパス
	 */
	public function tdImage(&$ent, $field, $midway_dp = ''){
		
		$orig_fp = $midway_dp . $ent[$field];
		$href = '';
		$thum_src = '';
		
		if(!empty($orig_fp)){
			$href = $orig_fp;
			$thum_src = str_replace('/orig/', '/thum/', $orig_fp);
		}else{
			$href = 'javascript void(0)';
			$thum_src = 'img/icon/none.gif';
		}
		
		$td_html = "
			<td>
				<input type='hidden' name='{$field}' value='{$orig_fp}' data-inp-ex='image1'>
				<label for='{$field}'>
					<a href='{$href}' target='brank'>
						<img src='{$thum_src}' >
					</a>
				</label>
			</td>
		";

		$this->setTd($td_html,$field);
		
	}
	
	
	/**
	 * 画像TD要素出力 プレーンタイプ
	 * 
	 * @note
	 * origディレクトリの画像を表示
	 * リンクなどもないシンプルタイプ。
	 * 画像サイズもそのまま表示。
	 * 
	 * @param array $ent データのエンティティ
	 * @param string $field フィールド名
	 */
	public function tdImagePlain(&$ent, $field){

		$orig_fp = $ent[$field];
		
		if(empty($orig_fp)){
			$orig_fp = 'img/icon/none.gif';
		}
		
		$td_html = "
			<td>
				<input type='hidden' name='{$field}' value='{$orig_fp}' data-inp-ex='image1'>
				<label for='{$field}'>
					<img src='{$orig_fp}' >
				</label>
			</td>
		";
		
		$this->setTd($td_html,$field);
		
	}
	
	
	
	/**
	 * 列並用TD要素群にTD要素をセット
	 *
	 * 列並モードがOFFならTD要素をそのまま出力する。
	 *
	 * @param string $td TD要素文字列
	 * @param string $field フィールド名
	 */
	private function setTd($td,$field){
		if($this->_clmSortMode && !empty($field) ){
			$this->_clmSortTds[$field] = $td;
		}else{
			echo $td;
		}
	}
	
	
	
	/**
	 * プロパティのプレビュー表示
	 * @param string $v プロパティの値
	 * @param string $wamei プロパティ和名
	 */
	public function tblPreview($v,$wamei){
		echo "<tr>\n";
		echo "	<td>{$wamei}</td>\n";
		echo "	<td>{$v}</td>\n";
		echo "</tr>\n";
	}

	
	
	/**
	 * 行の編集ボタンを作成する
	 * @param int $id ID
	 * @param string $css_class CSSスタイル（省略可）
	 * @param $onclick 編集フォームを呼び出すjs関数（CRUDタイプがajax型である場合。省略可)
	 */
	public function rowEditBtn($id,$css_class=null,$onclick=null){
		if(empty($css_class)){
			$css_class='row_edit_btn btn btn-primary btn-sm ';//
		}
		
		if(empty($onclick)){
			$onclick="editShow(this);";
		}
		
		echo "<input type='button' value='編集'  class='{$css_class}' onclick='{$onclick}' />";

	}
	
	
	
	
	/**
	 * 行の複製ボタンを作成する
	 * @param int $id ID
	 * @param string $css_class CSSスタイル（省略可）
	 * @param $onclick 複製フォームを呼び出すjs関数（CRUDタイプがajax型である場合。省略可)
	 */
	public function rowCopyBtn($id,$css_class=null,$onclick=null){
		
		if(empty($css_class)){
			$css_class='btn btn-primary btn-sm row_copy_btn';
		}
		
		if(empty($onclick)){
			$onclick="copyShow(this);";
		}

		echo "<input type='button' value='複製'  class='{$css_class}' onclick='{$onclick}' />";
		
	}
	

	/**
	 * 行の削除ボタンを作成する
	 * @param int $id ID
	 * @param string $css_class CSSスタイル（省略可）
	 * @param $onclick 削除フォームを呼び出すjs関数（CRUDタイプがajax型である場合。省略可)
	 */
	public function rowDeleteBtn(&$ent,$option=[]){
		
		$css_class = 'row_delete_btn btn btn-warning btn-sm';
		if(isset($option['css_class'])) $css_class = $option['css_class'];
		
		$onclick="deleteAction(this);";
		if(isset($option['onclick'])) $css_class = $option['onclick'];

		// 検索条件データの削除フラグが0(有効)でなければ削除ボタンを表示しない。
		$display_none = '';
		if($ent['delete_flg'] == 1) $display_none = 'display:none;';
		
		echo "<input type='button' value='削除'  class='{$css_class}' onclick='{$onclick}' style='{$display_none}' />";	

	}
	
	
	
	
	/**
	 * 行の有効ボタンを作成する
	 * @param int $id ID
	 * @param string $css_class CSSスタイル（省略可）
	 * @param $onclick 有効フォームを呼び出すjs関数（CRUDタイプがajax型である場合。省略可)
	 */
	public function rowEnabledBtn(&$ent,$option=[]){
		
		$css_class = 'row_enabled_btn btn btn-success btn-sm';
		if(isset($option['css_class'])) $css_class = $option['css_class'];
		
		$onclick="enabledAction(this);";
		if(isset($option['onclick'])) $css_class = $option['onclick'];
		
		// 検索条件データの有効フラグが1(無効)でなければ有効ボタンを表示しない。
		$style='';
		if($ent['delete_flg'] != 1) $style = "style='display:none'";
		
		// CRUDタイプがajax型である場合
		echo "<input type='button' value='有効'  class='{$css_class}' onclick='{$onclick}' {$style} />";
		
	}
	
	
	
	
	/**
	 * 行の抹消ボタンを作成する
	 * 
	 * @note
	 * 検索条件データの削除フラグが1(削除)でなければ抹消ボタンを表示しない。
	 * 
	 * @param array $ent エンティティ
	 * @param array $option
	 *  - css_class CSSスタイル（省略可）
	 *  - onclick 抹消フォームを呼び出すjs関数（CRUDタイプがajax型である場合。省略可)
	 */
	public function rowEliminateBtn(&$ent,$option=[]){
		

		
		$css_class = 'row_eliminate_btn btn btn-danger btn-sm';
		if(isset($option['css_class'])) $css_class = $option['css_class'];
		
		$onclick="eliminateShow(this);";
		if(isset($option['onclick'])) $css_class = $option['onclick'];
		
		$style='';
		if($ent['delete_flg'] != 1) $style = "style='display:none'";
		
		echo "<input type='button' value='抹消'  class='{$css_class}' onclick='{$onclick}' {$style} title='データベースからも消去します。復元できません。' />";
		
	}
	
	
	
	
	
	
	
	
	
	
	/**
	 * 更新情報を表示する
	 * @param array $ent エンティティ
	 */
	public function updateInfo($ent){
		
		echo "<table class='tbl_sm'><tbody>\n";
		

		$this->_updateInfoTr($ent,'id','ID');
		$this->_updateInfoTr($ent,array('update_user','user_name','user','updater','modified_user'),'前回更新者');
		$this->_updateInfoTr($ent,array('update_ip_addr','ip_addr','user_ip_addr'),'前回更新IPアドレス');
		$this->_updateInfoTr($ent,'created','生成日時');
		$this->_updateInfoTr($ent,'modified','前回更新日時');
		
		echo "</tbody></table>\n";
	}
	private function _updateInfoTr($ent,$field,$fieldName){
		
		$ary = [];
		if (!is_array($field)){
			$ary[] = $field;
		}else{
			$ary = $field;
		}
		
		foreach($ary as $f){
			if(!empty($ent[$f])){
				echo "<tr><td>{$fieldName}</td><td>{$ent[$f]}</td></tr>\n";
				break;
			}
		}
	}
	
	
	
	
	
	/**
	 * 日時選択肢リストを取得する
	 * 
	 * @return array 日時選択肢リスト
	 */
	private function getDateTimeList(){

		
		if(!empty($this->_dateTimeList)){
			return $this->_dateTimeList;
		}
			
		$d1=date('Y-m-d');//本日
		$d2=$this->getBeginningWeekDate($d1);//週初め日付を取得する。
		$d3 = date('Y-m-d', strtotime("-10 day"));//10日前
		$d4 = $this->getBeginningMonthDate($d1);//今月一日を取得する。
		$d5 = date('Y-m-d', strtotime("-30 day"));//30日前
		$d6 = date('Y-m-d', strtotime("-50 day"));//50日前
		$d7 = date('Y-m-d', strtotime("-100 day"));//100日前
		$d8 = date('Y-m-d', strtotime("-180 day"));//180日前
		$d9 = $this->getBeginningYearDate($d1);//今年元旦を取得する
		$d10 = date('Y-m-d', strtotime("-365 day"));//365日前
			
		$list= [
				$d1=>'本日',
				$d2=>'今週（日曜日から～）',
				$d3=>'10日以内',
				$d4=>'今月（今月一日から～）',
				$d5=>'30日以内',
				$d6=>'50日以内',
				$d7=>'100日以内',
				$d8=>'半年以内（180日以内）',
				$d9=>'今年（今年の元旦から～）',
				$d10=>'1年以内（365日以内）',
		];
		
		$this->_dateTimeList = $list;
	
		return $list;
			
	}
	
	/**
	 * 引数日付の週の週初め日付を取得する。
	 * 週初めは日曜日とした場合。
	 * @param $ymd
	 * @return DateTime 週初め
	 */
	private function getBeginningWeekDate($ymd) {
			
		$w = date("w",strtotime($ymd));
		$bwDate = date('Y-m-d', strtotime("-{$w} day", strtotime($ymd)));
		return $bwDate;
			
	}
	
	/**
	 * 引数日付から月初めの日付を取得する。
	 * @param $ymd
	 */
	private function getBeginningMonthDate($ymd) {
	
		$ym = date("Y-m",strtotime($ymd));
		$d=$ym.'-01';
			
		return $d;
	
	}
	
	/**
	 * 引数日付から元旦日を取得する。
	 * @param $ymd
	 */
	private function getBeginningYearDate($ymd) {
	
		$y = date("Y",strtotime($ymd));
		$d=$y.'-01-01';
			
		return $d;
	
	}
	
	
	/**
	 * スネークケースにキャメルケースから変換
	 * @param string $str キャメルケース
	 * @return string スネークケース
	 */
	private function snakize($str) {
		$str = preg_replace('/[A-Z]/', '_\0', $str);
		$str = strtolower($str);
		return ltrim($str, '_');
	}
	
	
	/**
	 * td要素出力を列並モードに対応させる
	 * @param array $fieldData フィールドデータ
	 */
	public function startClmSortMode(){
		$this->_clmSortMode = 1; // 列並モード ON
		
	}
	
	
	/**
	 * 列並に合わせてTD要素群を出力する
	 */
	public function tdsEchoForClmSort(){

		foreach($this->_fieldData as $f_ent){
			$field = $f_ent['id'];
			if(!empty($this->_clmSortTds[$field])){
				echo $this->_clmSortTds[$field];
			}
		}
		
		// クリア
		$this->_clmSortTds = [];
		
	}
	
	
	/**
	 * シンプルなSELECT要素を作成
	 * @param string $name SELECTのname属性
	 * @param string $value 初期値
	 * @param array $list 選択肢
	 * @param array $option オプション  要素の属性情報
	 * @param array $empty 未選択状態に表示する選択肢名。nullをセットすると未選択項目は表示しない
	 * 
	 */
	public function selectX($name,$value,$list,$option=null,$empty=null){
		
		// オプションから各種属性文字を作成する。
		$optionStr = "";
		if(!empty($option)){
			foreach($option as $attr_name => $v){
				$str = $attr_name.'="'.$v.'" ';
				$optionStr.= $str;
			}
		}
		
		
		$def_op_name = '';
		
		echo "<select  name='{$name}' {$optionStr} >";
		
		if($empty!==null){
			$selected = '';
			if($value===null){
				$selected='selected';
			}
			echo "<option value='' {$selected}>{$empty}</option>";
		}
		
		foreach($list as $v=>$n){
			$selected = '';
			if($value==$v){
				$selected='selected';
			}
			
			$n = str_replace(array('<','>'),array('&lt;','&gt;'),$n);

			echo "<option value='{$v}' {$selected}>{$n}</option>";
			
		}
		
		echo "</select>";
	}
	
	
	/**
	 * Vue.js用のセレクトボックスを作成
	 * @param array $list 選択肢
	 * @param string $property SELECTのname属性
	 * @param string $empty_str 未選択状態に表示する選択肢名。nullをセットすると未選択項目は表示しない
	 *
	 */
	public function selectForVue($list, $property, $empty_str = null){
		
		$options_str = '';
		
		// 空選択
		if(!empty($empty_str)){
			$options_str .= "<option value='' >{$empty_str}</option>";
		}
		
		// オプション部分
		foreach($list as $key => $value){
			$options_str .= "<option value='{$key}' >{$value}</option>";
		}
		
		
		$html = "
			<select v-model='{$property}'>
				{$options_str}
			</select>
		";
		
		echo $html;
	}
	
	
	/**
	 * シンプルなCHECKBOX要素を作成
	 * @param string $name CHECKBOXのname属性
	 * @param string $value 初期値
	 * @param array $option オプション  要素の属性情報
	 * 
	 */
	public function checkboxX($name,$value,$option=null){
		
		// オプションから各種属性文字を作成する。
		$optionStr = "";
		if(!empty($option)){
			foreach($option as $attr_name => $v){
				$str = $attr_name.'="'.$v.'" ';
				$optionStr.= $str;
			}
		}
		
		$checked = '';
		if(!empty($value)){
			$checked = 'checked';
		}
		
		echo "<input type='checkbox' name='{$name}' {$checked} {$optionStr} />\n";
		
	}
	
	
	/**
	 * 配列型用RADIO要素を作成
	 * @param string $name RADIOのname属性
	 * @param string $value 初期値
	 * @param array $list 選択肢
	 * @param array $option オプション  要素の属性情報
	 * 
	 */
	public function radioForMult($name,$value,$list,$option=null){
		
		// オプションから各種属性文字を作成する。
		$optionStr = "";
		if(!empty($option)){
			foreach($option as $attr_name => $v){
				$str = $attr_name.'="'.$v.'" ';
				$optionStr.= $str;
			}
		}
		
		
		$def_op_name = '';
		
		echo "<select name='{$name}' {$optionStr} >\n";
		

		
		foreach($list as $v=>$n){
			$selected = '';
			if($value===$v){
				$selected='selected';
			}
			$n = str_replace(array('<','>'),array('&lt;','&gt;'),$n);
			echo "<option value='{$v}' {$selected}>{$n}</option>\n";
			
		}
		
		echo "</select>\n";
	}
	
	
	
	
	
	
	
	/**
	 * グループ分類SELECT要素を作成する
	 * @param int $x_name name属性
	 * @param string $value 初期の値
	 * @param array $grpList グループ分類リスト
	 * 	- グループ分類リストの構造例
	 * 	(int) 17 => array(
	 *		'label' => '桃太郎',
	 *		'optgroup_value' => 98,
	 *		'list' => array(
	 *			(int) 118 => 'body1.png',
	 *			(int) 119 => 'eye1.png',
	 *	(int) 22 => array(
	 *		'label' => '怪しい影',
	 *		'optgroup_value' => 99,
	 *		'list' => array(
	 *			(int) 144 => 'silhouette.png',
	 * @param array $option オプション。主にSELECT要素の各種属性値
	 * - empty 未選択のテキストをセットする。（値要素は空値である。）
	 */
	public function selectOptgroup($x_name,$value,$grpList,$param=null){
		
		
		// オプションからselect要素の属性群文字列を作成する
		$attr_str = "";
		$empty = null;
		if($param){
			foreach($param as $attr_key => $attr_value){
				if($attr_key == 'empty'){
					$empty = $attr_value;
					continue;
				}
				$attr_str .= ' '.$attr_key.'="'.$attr_value.'"';
			}
		}
		
		// ヘッド部分を作成
		$h_head = "<select name=\"{$x_name}\" {$attr_str}>\n";
		
		
		
		// 未選択部分の作成
		$h_data = "";
		if(!empty($empty)){
			$h_data = "<option value=\"\">".$empty."</option>\n";
		}
		
		// リスト部分を作成
		foreach($grpList as $c_i =>$ent){
			
			// グループラベルを取得、およびoptgroup要素を組み立て
			$label = $ent['label'];
			if(empty($label)){
				$label = '未分類';
			}
			
			// グループオプション属性の組み立て
			$optgroup_value_str = "";
			if(isset($ent['optgroup_value'])){
				$optgroup_value_str = "data-value = '{$ent['optgroup_value']}'";
			}
			
			$h_data .= "<optgroup label=\"{$label}\" {$optgroup_value_str}>\n";
			
			// option要素を組み立てる
			$list = $ent['list'];
			foreach($list as $opt_val => $opt_name){
				$selected = "";
				if($opt_val == $value){
					$selected = "selected";
				}
				
				$h_data .= "<option value=\"{$opt_val}\" {$selected}>{$opt_name}</option>\n";
			}
			
			$h_data .= "</optgroup>\n";
			
		}
		
		
		// フッター部分を追加
		$html = $h_head.$h_data."</select>\n";
		
		return $html;
		
		
	}
	
	
	
	/**
	 * CSVボタンとそれに属するプルダウンメニューを作成する
	 * @param string $csv_dl_url
	 */
	public function makeCsvBtns($csv_dl_url){
		
		$html = "
		<a href='{$csv_dl_url}' class='btn btn-secondary btn-sm'>CSVエクスポート</a>
		<input type='button' value='CSVインポート' class='btn btn-secondary btn-sm' onclick='jQuery(\"#csv_fu_div\").toggle(300);' style='display:none' />
		<div id='csv_fu_div' style='display:none'><input type='file' id='csv_fu' /></div>
		";
		
		echo $html;
		
	}
	
	
	/**
	 * Cakeに対応したhidden要素を作成
	 *
	 * @param string $field 要素のフィールド（キー）
	 * @param string $value 値
	 */
	public function hiddenX($field,$value){
		
		$model_name_c = $this->crudBaseData['model_name_c'];
		$value = htmlspecialchars($value); // XSSサニタイズ
		
		$html = "
			<input type='hidden'
				name='data[{$model_name_c}][{$field}]'
				id='{$field}'
				value='{$value}'
				data-field='{$field}'
				class='kj_wrap kjs_inp'>
		";
		
		echo $html;
		
	}
	
	
	/**
	 * ハッシュタグを作成
	 * @param array $ent エンティティ
	 * @param string $field フィールド
	 * @param string wamei 和名
	 * @param string $label ラベル　 0:ラベル無(デフォルト), 1:ラベル有
	 * @param string $class class属性名
	 * @param string $unit_after 単位（後）
	 */
	public function hashTag(&$ent, $field, $wamei, $label=0, $class='hash_tag0', $unit_after=''){
		if(empty($ent[$field])){
			return;
		}
		
		
		// ラベル名、ツールチップ名の取得
		$label_name = '';
		$title_name = '';
		if($label == 1){
			$label_name = $wamei . ': ';
		}else{
			$title_name = $wamei;
		}
		
		echo "<div class='{$class}' title='{$title_name}' >{$label_name}{$ent[$field]}{$unit_after}</div>";
	}
	
	
	/**
	 * ハッシュURLを作成
	 * @param array $ent エンティティ
	 * @param string $field フィールド
	 * @param string wamei 和名
	 * @param $label string ラベル　 0:ラベル無(デフォルト), 1:ラベル有
	 * @param $class string class属性名
	 * @param $unit_after string 単位（後）
	 */
	public function hashUrl(&$ent, $field, $wamei, $label=0, $class='hash_tag0', $unit_after=''){
		if(empty($ent[$field])){
			if($ent[$field] !== 0 && $ent[$field]!=='0') return;
		}
		
		
		// ラベル名、ツールチップ名の取得
		$label_name = '';
		$title_name = '';
		if($label == 1){
			$label_name = $wamei;
		}else{
			$title_name = $wamei;
		}
		if(empty($label_name)){
			$label_name = 'URL';
		}
		
		echo "<div class='{$class}' title='{$title_name}' ><a href='{$ent[$field]}' target='blank'>{$label_name}{$unit_after}</a></div>";
	}
	
	
	/**
	 * 値連結型ハッシュタグを作成
	 * @param array $ent エンティティ
	 * @param array $fields フィールドリスト
	 * @param string $wamei 値連結後の和名
	 * @param $label string ラベル　 0:ラベル無(デフォルト), 1:ラベル有
	 * @param $class string class属性名
	 */
	public function hashTagJoin(&$ent, $fields, $wamei, $label=0, $class='hash_tag0'){
		
		// 値を連結
		$join_str = '';
		foreach($fields as $field){
			$join_str .= $ent[$field];
		}
		
		// ラベル名、ツールチップ名の取得
		$label_name = '';
		$title_name = '';
		if($label == 1){
			$label_name = $wamei . ': ';
		}else{
			$title_name = $wamei;
		}
		
		echo "<div class='{$class}' title='{$title_name}' >{$label_name}{$join_str}</div>";
	}
 
	/**
	 * google mapピン付きリンクの作成
	 * @param string $lat 緯度
	 * @param string $lon 経度
	 * @return string google mapピン付きリンク
	 */
	public function gmapPinLink($lat, $lon, $text, $class='btn btn-link'){
		
		if($this->_empty0($lat) || $this->_empty0($lon)) return;
		
		$url = "https://maps.google.com/maps?q={$lat},{$lon}";
		echo "<a href='{$url}' class='{$class}' target='blank'>$text</a>";
		
	}
	
	
	/**
	 * 新バージョン通知区分を表示
	 */
	public function divNewPageVarsion(){
		
		$new_version_flg = $this->crudBaseData['new_version_flg'];
		$this_page_version = $this->crudBaseData['this_page_version'];
		
		if(empty($new_version_flg)) return;
		$html = "
			<div style='padding:10px;background-color:#fac9cc'>
				<div>新バージョン：{$this_page_version}</div>
				<div class='text-danger'>当画面は新しいバージョンに変更されています。
				セッションクリアボタンを押してください。</div>
				<input type='button' class='btn btn-danger btn-sm' value='セッションクリア' onclick='sessionClear()' >
			</div>
		";
		echo $html;
	}
	
	
	/**
	 * 列表示切替機能の区分を表示
	 */
	public function divCsh(){
		
		$html = "
			<div id='csh_div' style='display:inline-block'>
				<input type='button' value='列表示切替' class='btn btn-secondary btn-sm' onclick=\"jQuery('#clm_cbs_detail').toggle(300)\" />
				<div id='clm_cbs_detail' style='display:none;margin-top:5px'>
					<div id='clm_cbs_rap'>
						<table style='width:100%'><tbody><tr>
							<td><p>列表示切替</p></td>
							<td style='text-align:right;'>
								<button type='button' class='btn btn-primary btn-sm' onclick=\"jQuery('#clm_cbs_detail').toggle(300)\">閉じる</button>
							</td>
						</tr></tbody></table>
						<div id='clm_cbs'></div>
					</div>
					<hr class='hr_purple'>
				</div>
			</div>
		";
		echo $html;
	}
	
	/**
	 * ページネーション区分の表示
	 */
	public function divPagenation(){
		
		$pages = $this->crudBaseData['pages'];
		$data_count = $this->crudBaseData['data_count'];
		
		$html = "
			<div class='pagenation_w' style='margin-top:8px;'>
				<div style='display:inline-block'>
					{$pages['page_index_html']}
				</div>
				<div id='pagenation_jump' 
					data-row-limit='{$pages['row_limit']}' 
					data-count='{$data_count}' 
					data-hina-url='{$pages['def_url']}' 
					style='display:inline-block'></div>
				<div style='display:inline-block'>件数:{$data_count}</div>
			</div>
		";
		echo $html;
	}
	
	/**
	 * ページネーション区分の表示(下段用）
	 */
	public function divPagenationB(){
		
		$pages = $this->crudBaseData['pages'];
		$data_count = $this->crudBaseData['data_count'];
		
		$html="
			<div  class='pagenation_w' style='margin-top:8px;'>
				<div style='display:inline-block'>
					{$pages['page_index_html']}
				</div>
				<div id='pagenation_jump_b' 
					data-row-limit='{$pages['row_limit']}' 
					data-count='{$data_count}' 
					data-hina-url='{$pages['def_url']}' 
					style='display:inline-block'></div>
				<div style='display:inline-block'>件数:{$data_count}</div>
			</div>
		";
		
		echo $html;
	}
	
	
	/**
	 * 複数有効/削除の区分を表示する
	 */
	public function divPwms(){
		$html = "
			<div style='margin-top:10px;margin-bottom:10px'>
				<label for='pwms_all_select'>すべてチェックする <input type='checkbox' name='pwms_all_select' onclick='crudBase.pwms.switchAllSelection(this);' /></label>
				<button type='button' onclick='crudBase.pwms.action(10)' class='btn btn-success btn-sm'>有効</button>
				<button type='button' onclick='crudBase.pwms.action(11)' class='btn btn-danger btn-sm'>削除</button>
				<aside>
					※ID列の左側にあるチェックボックスにチェックを入れてから「削除」ボタンを押すと、まとめて削除されます。<br>
					削除の復元は画面下側のヘルプボタンを参照してください。<br>
				</aside>
			</div>
		";
		echo $html;
	}
	
	
	/**
	 * 0以外の空判定
	 *
	 * @note
	 * いくつかの空値のうち、0と'0'は空と判定しない。
	 *
	 * @param $value
	 * @return int 判定結果 0:空でない , 1:空である
	 */
	private function _empty0($value){
		if(empty($value) && $value!==0 && $value!=='0'){
			return 1;
		}
		return 0;
	}
	
}