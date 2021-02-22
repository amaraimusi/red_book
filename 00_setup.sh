#!/bin/sh
echo 'CrudBase関連のファイルを対象のプロジェクトにセットアップします。'

project_name='red_book'
echo プロジェクト名→$project_name

date1=`date "+%Y%m%d_%H%M%S"`

echo const.phpをコピー
rm -f ~/git/$project_name/dev/config/const.php
cat ~/git/CrudBase/laravel7/dev/config/const.php.default >> ~/git/$project_name/dev/config/const.php
sed -i -e "s/xxxx/$project_name/g" ~/git/$project_name/dev/config/const.php

echo "CrudBaseパッケージ(PHP用）をコピー"
rm -f -r ~/git/$project_name/dev/app/CrudBase
rsync -auvz ~/git/CrudBase/dist/CrudBase/php/CrudBase ~/git/$project_name/dev/app

echo "CrudBaseパッケージ(JS用）をコピー"
rm -f -r ~/git/$project_name/dev/public/js/CrudBase
rsync -auvz ~/git/CrudBase/dist/CrudBase/js/CrudBase ~/git/$project_name/dev/public/js

echo "CrudBaseパッケージ(CSS用）をコピー"
rm -f -r ~/git/$project_name/dev/public/css/CrudBase
rsync -auvz ~/git/CrudBase/dist/CrudBase/css/CrudBase ~/git/$project_name/dev/public/css

rsync -auvz ~/git//CrudBase/laravel7/dev/resources/views/layouts ~/git/$project_name/dev/resources/views

sed -i -e "s/DB_DATABASE=laravel/DB_DATABASE=$project_name/g" ~/git/$project_name/dev/.env

cp ~/git/red_book/dev/routes/web.php ~/git/red_book/dev/routes/web_${date1}.php
#rm -f ~/git/red_book/dev/routes/web.php
#rsync -auvz ~/git/CrudBase/laravel7/dev/routes/web.php ~/git/red_book/dev/routes

rm -f -r ~/git/$project_name/dev/resources/js
rm -f -r ~/git/$project_name/dev/resources/sass
rsync -auvz ~/git/CrudBase/laravel7/dev/resources/js ~/git/$project_name/dev/resources
rsync -auvz ~/git/CrudBase/laravel7/dev/resources/sass ~/git/$project_name/dev/resources

rsync -auvz ~/git/CrudBase/laravel7/dev/public ~/git/$project_name/dev

echo "------------ セットアップ完了"

cmd /k