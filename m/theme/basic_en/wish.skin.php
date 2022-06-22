﻿<?php
if(!defined("_TUBEWEB_")) exit; // No access to individual pages
?>

<div id="sod_ws">
	<p id="sod_fin_no">
		<strong>total <?php echo number_format($wish_count); ?>the number</strong>The goods are in storage.
	</p>

	<form name="fwishlist" id="fwishlist" method="post">
	<input type="hidden" name="act" value="multi">
	<input type="hidden" name="sw_direct">

	<?php 
	if(!$wish_count) {
		echo "<p class=\"empty_list\">The locker is empty.</p>";
	} else {
	?>
	<div class="ws_wrap">
		<table>
		<tbody>
		<?php
		for($i=0; $row=sql_fetch_array($result); $i++) {
			$out_cd = '';
			$sql = " select count(*) as cnt from shop_goods_option where gs_id = '{$row['gs_id']}' and io_type = '0' ";
			$tmp = sql_fetch($sql);
			if($tmp['cnt'])
				$out_cd = 'no';

			if($row['price_msg']) {
				$out_cd = 'price_msg';
			}
		?>
		<tr>
			<th>
				<?php if(is_soldout($row['gs_id'])) { ?>
				<span class="fc_red tx_small">Out of stock</span>
				<?php } else { ?>
				<input type="checkbox" name="chk_gs_id[<?php echo $i;?>]" value="1" id="ct_chk_<?php echo $i;?>" onclick="out_cd_check(this, '<?php echo $out_cd;?>');" class="css-checkbox"><label for="ct_chk_<?php echo $i;?>" class="css-label"></label>
				<?php } ?>
				<input type="hidden" name="gs_id[<?php echo $i;?>]" value="<?php echo $row['gs_id'];?>">
				<input type="hidden" name="io_type[<?php echo $row['gs_id'];?>][0]" value="0">
				<input type="hidden" name="io_id[<?php echo $row['gs_id']; ?>][0]" value="">
				<input type="hidden" name="io_value[<?php echo $row['gs_id'];?>][0]" value="<?php echo $row['gname'];?>">
				<input type="hidden" name="ct_qty[<?php echo $row['gs_id'];?>][0]" value="1">
			</th>
			<td class="wish_img"><a href="<?php echo TB_MSHOP_URL; ?>/view.php?gs_id=<?php echo $row['gs_id'];?>"><?php echo get_it_image($row['gs_id'], $row['simg1'], 60, 60); ?></a></td>
			<td class="wish_info">
				<div class="wish_gname">
					<a href="<?php echo TB_MSHOP_URL; ?>/view.php?gs_id=<?php echo $row['gs_id'];?>"><?php echo cut_str($row['gname'],60);?></a>
					<div class="bold mart5"><?php echo mobile_price($row['gs_id']);?></div>
				</div>
				<div class="wish_del"><a href="<?php echo TB_MSHOP_URL; ?>/wishupdate.php?w=d&wi_id=<?php echo $row['wi_id'];?>" class="btn_small grey">delete</a></div>
			</td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>

	<div class="btn_confirm">
		<button type="button" onclick="return fwishlist_check(document.fwishlist,'');" class="btn_medium bx-white">Add to cart</button>
		<button type="button" onclick="return fwishlist_check(document.fwishlist,'direct_buy');" class="btn_medium wset">Order your product</button>
	</div>
	<?php } ?>

	</form>
</div>

<script>
<!--
function out_cd_check(fld, out_cd)
{
	if(out_cd == 'no'){
		alert("
This item is an option.\n\n
Click on the item, select the option on the product page, please order.");
		fld.checked = false;
		return;
	}

	if(out_cd == 'price_msg'){
		alert("Please contact us by phone.\n\nYou can not buy it in your shopping cart.");
		fld.checked = false;
		return;
	}
}

function fwishlist_check(f, act)
{
	var k = 0;
	var length = f.elements.length;

	for(i=0; i<length; i++) {
		if(f.elements[i].checked) {
			k++;
		}
	}

	if(k == 0)
	{
		alert("Please check one or more items");
		return false;
	}

	if(act == "direct_buy")
	{
		f.sw_direct.value = 1;
	}
	else
	{
		f.sw_direct.value = 0;
	}

	f.action = "./cartupdate.php";
	f.submit();
}
//-->
</script>
