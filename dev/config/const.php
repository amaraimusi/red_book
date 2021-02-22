<?php

// ルートパスを取得する
$root = $_SERVER['DOCUMENT_ROOT'];
$root_last_str =  mb_substr($root, -1);
if($root_last_str == '/' || $root_last_str == '\\'){
	$root = mb_substr($root,0,mb_strlen($root)-1);
}

return [
		'ROOT'=>$root,
		'CRUD_BASE_PATH' =>$root . '/red_book/dev/app/CrudBase/',
		'CRUD_BASE_JS' =>'/red_book/dev/public/js/CrudBase/dist/CrudBase.min.js',
		'CRUD_BASE_CSS' =>'/red_book/dev/public/css/CrudBase/dist/CrudBase.min.css',
		'WEB_ROOT' => '/red_book/dev/',
];

function debug($var){
	dump($var);
}