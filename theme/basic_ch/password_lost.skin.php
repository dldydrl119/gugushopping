<?php
if(!defined('_TUBEWEB_')) exit;
?>

<div id="find_info" class="new_win">
	<h1 id="win_title"><?php echo $tb['title']; ?></h1>

	<form name="fpasswordlost" action="<?php echo $form_action_url; ?>" method="post" autocomplete="off">
	<input type="hidden" name="token" value="<?php echo $token; ?>">
	<fieldset id="info_fs">
		<p>
			注册会员时请输入注册的邮箱地址。<br>
			用该邮箱发送用户名和密码信息。
		</p>
		<div class="info_form">
			<label for="mb_email">E-mail 住址<strong class="sound_only">必须</strong></label>
			<input type="text" name="mb_email" id="mb_email" required email itemname="E-mail 住址" class="required frm_input" size="30">
		</div>
	</fieldset>

	<div class="win_btn">
		<input type="submit" class="btn_lsmall" value="确认">
		<button type="button" class="btn_lsmall bx-white" onclick="window.close();">关窗</button>
	</div>	
	</form>
</div>
