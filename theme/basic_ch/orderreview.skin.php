<?php
if(!defined('_TUBEWEB_')) exit;
?>

<div id="sit_use_write" class="new_win">
	<h1 id="win_title"><?php echo $tb['title']; ?></h1>

	<form name="forderreview" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return forderreview_submit(this);">
	<input type="hidden" name="gs_id" value="<?php echo $gs_id; ?>">
	<input type="hidden" name="seller_id" value="<?php echo $gs['mb_id']; ?>">
	<input type="hidden" name="token" value="<?php echo $token; ?>">

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col class="w90">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">商品名称</th>
			<td><?php echo get_text($gs['gname']); ?></td>
		</tr>
		<tr>
			<th scope="row">订单号码</th>
			<td><?php echo $od_id; ?></td>
		</tr>
		<tr>
			<th scope="row">名</th>
			<td><?php echo $member['name']; ?></td>
		</tr>
		<tr>
			<th scope="row">评分</th>
			<td>
				<input type="radio" name="score" value="5" checked>
				<img src="<?php echo TB_IMG_URL ?>/sub/score_5.gif">
				<input type="radio" name="score" value="4">
				<img src="<?php echo TB_IMG_URL ?>/sub/score_4.gif">
				<input type="radio" name="score" value="3">
				<img src="<?php echo TB_IMG_URL ?>/sub/score_3.gif">
				<input type="radio" name="score" value="2">
				<img src="<?php echo TB_IMG_URL ?>/sub/score_2.gif">
				<input type="radio" name="score" value="1">
				<img src="<?php echo TB_IMG_URL ?>/sub/score_1.gif">
			</td>
		</tr>
		<tr>
			<th scope="row">内容</th>
			<td><textarea name="memo" class="frm_textbox wufll"></textarea></td>
		</tr>
		</tbody>
		</table>
	</div>

    <div class="win_btn">
        <input type="submit" value="制作完毕" class="btn_lsmall">
		<a href="javascript:window.close();" class="btn_lsmall bx-white">关窗</a>
    </div>

	</form>
</div>

<script>
function forderreview_submit(f) {
	if(!f.memo.value) {
		alert('请输入内容。.');
		f.memo.focus();
		return false;
	}

	if(confirm("确定要登记吗?") == false)
		return false;

    return true;
}
</script>