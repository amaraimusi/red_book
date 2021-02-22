

<table style="width:100%;margin-top:3px;margin-bottom:3px;"><tr>
<td>
	<!-- ログインメニュー -->
	<?php 
		$auth_level = 0; // 権限レベル
		$authority_wamei = ''; // 権限名
		if(!empty($crudBaseData['userInfo']['authority'])){
			$auth_level = $crudBaseData['userInfo']['authority']['level'];
			$authority_wamei = $crudBaseData['userInfo']['authority']['wamei'];
		}
	?>
	@auth
		@if ($auth_level >= 30)
			<a href="user_mng" class="btn btn-info btn-sm">ユーザー管理画面</a>
		@endif
		
		@if (Route::has('register'))
			<!-- 未使用 -->
			<a href="{{ route('register') }}" class="btn btn-info btn-sm">登録</a>
		@endif
	@else
	<a href="{{ url('/home') }}" class="btn btn-info btn-sm">Home</a>
	<a href="{{ route('login') }}" class="btn btn-info btn-sm">ログイン</a>
	@endauth

</td>
<td style="text-align:right">
	@guest
	
	@else
	<button class="btn btn-secondary dropdown-toggle btn btn-info btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{{ Auth::user()->name }}
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<div style="margin-left:24px;color:#9b9b9f">{{$authority_wamei}}</div>
		<a class=" btn btn-info btn-sm dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
	</div>
	@endguest
	<a href="static_page/help" class="btn btn-info btn-sm" target="_blank">使い方</a>
</td>
</tr></table>


	