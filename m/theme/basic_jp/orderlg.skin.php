<?php
if(!defined("_TUBEWEB_")) exit; // 個別ページアクセス不可

require_once(TB_MSHOP_PATH.'/settle_lg.inc.php');
?>

<!-- LGユープラス決済開始 { -->
<div id="sod_fin">
	<section id="sod_fin_list">
        <h2>注文することが商品</h2>
        <ul id="sod_list_inq" class="sod_list">
            <?php
			$goods = '';
			$goods_count = -1;

			$sql = " select *
					   from shop_cart
					  where od_id = '$od_id'
					    and ct_select = '0'
					  group by gs_id
					  order by index_no ";
			$result = sql_query($sql);
            for($i=0; $row=sql_fetch_array($result); $i++) {
				$rw = get_order($row['od_no']);
				$gs = get_goods($row['gs_id'], 'gname,simg1');

				if(!$goods)
					$goods = preg_replace("/\?|\'|\"|\||\,|\&|\;/", "", $gs['gname']);

				$goods_count++;

				unset($it_name);
				$it_options = mobile_print_complete_options($row['gs_id'], $od_id);
				if($it_options){
					$it_name = '<div class="li_name_od">'.$it_options.'</div>';
				}
            ?>
            <li class="sod_li">
                <div class="li_opt"><?php echo get_text($gs['gname']); ?></div>
				<?php echo $it_name; ?>
                <div class="li_prqty">
                    <span class="prqty_price li_prqty_sp"><span>商品金額 </span><?php echo number_format($rw['goods_price']); ?></span>
                    <span class="prqty_qty li_prqty_sp"><span>数量 </span><?php echo number_format($rw['sum_qty']); ?></span>
                    <span class="prqty_sc li_prqty_sp"><span>配送費 </span><?php echo number_format($rw['baesong_price']); ?></span>
					<span class="prqty_stat li_prqty_sp"><span>状態 </span>注文大気</span>
                </div>
                <div class="li_total" style="padding-left:60px;height:auto !important;height:50px;min-height:50px;">
                    <span class="total_img"><?php echo get_od_image($rw['od_id'], $gs['simg1'], 50, 50); ?></span>
                    <span class="total_price total_span"><span>決済金額 </span><?php echo number_format($rw['use_price']); ?></span>
                    <span class="total_point total_span"><span>積立ポイント </span><?php echo number_format($rw['sum_point']); ?></span>
                </div>
            </li>
			<?php
			}

			if($goods_count) $goods .= /' 他 '.$goods_count./'件';

			//複合課税処理
			$comm_tax_mny  = 0; // 課税金額
			$comm_vat_mny  = 0; // 付加税
			$comm_free_mny = 0; // 免税金額
			if($default['de_tax_flag_use']) {
				$info = comm_tax_flag($od_id);
				$comm_tax_mny  = $info['comm_tax_mny'];
				$comm_vat_mny  = $info['comm_vat_mny'];
				$comm_free_mny = $info['comm_free_mny'];
			}
			?>
        </ul>

		<dl id="sod_bsk_tot">
            <dt class="sod_bsk_dvr"><span>注文総額</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_price($stotal['price']); ?></strong></dd>

            <?php if($stotal['coupon']) { ?>
            <dt class="sod_bsk_dvr"><span>クーポン割引</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_price($stotal['coupon']); ?></strong></dd>
            <?php } ?>

            <?php if($stotal['usepoint']) { ?>
            <dt class="sod_bsk_dvr"><span>ポイント決済</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_point($stotal['usepoint']); ?></strong></dd>
            <?php } ?>

            <?php if($stotal['baesong']) { ?>
            <dt class="sod_bsk_dvr"><span>配送費</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_price($stotal['baesong']); ?></strong></dd>
            <?php } ?>

            <dt class="sod_bsk_cnt"><span>総計 </span></dt>
            <dd class="sod_bsk_cnt"><strong><?php echo display_price($stotal['useprice']); ?></strong></dd>

            <dt class="sod_bsk_point"><span>ポイント積立</span></dt>
            <dd class="sod_bsk_point"><strong><?php echo display_point($stotal['point']); ?></strong></dd>
        </dl>
    </section>

	<?php
	// 決済代行社別コード include (スクリプトなど)
	require_once(TB_MSHOP_PATH.'/lg/orderform.1.php');
	?>

	<form id="forderform" name="forderform" method="post" action="<?php echo $order_action_url; ?>" autocomplete="off">

	<section id="sod_fin_orderer">
		<h3 class="anc_tit">ご注文の方</h3>
		<div  class="odf_tbl">
			<table>
			<colgroup>
				<col class="w70">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">名前</th>
				<td><?php echo get_text($od['name']); ?></td>
			</tr>
			<tr>
				<th scope="row">電話番号</th>
				<td><?php echo get_text($od['telephone']); ?></td>
			</tr>
			<tr>
				<th scope="row">携帯電話</th>
				<td><?php echo get_text($od['cellphone']); ?></td>
			</tr>
			<tr>
				<th scope="row">住所</th>
				<td><?php echo get_text(sprintf("(%s)", $od['zip']).' '.print_address($od['addr1'], $od['addr2'], $od['addr3'], $od['addr_jibeon'])); ?></td>
			</tr>
			<tr>
				<th scope="row">E-mail</th>
				<td><?php echo get_text($od['email']); ?></td>
			</tr>
			</tbody>
			</table>
		</div>
	</section>

	<section id="sod_fin_receiver">
		<h3 class="anc_tit">お受け取りの方</h3>
		<div  class="odf_tbl">
			<table>
			<colgroup>
				<col class="w70">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">名前</th>
				<td><?php echo get_text($od['b_name']); ?></td>
			</tr>
			<tr>
				<th scope="row">電話番号</th>
				<td><?php echo get_text($od['b_telephone']); ?></td>
			</tr>
			<tr>
				<th scope="row">携帯電話</th>
				<td><?php echo get_text($od['b_cellphone']); ?></td>
			</tr>
			<tr>
				<th scope="row">住所</th>
				<td><?php echo get_text(sprintf("(%s)", $od['b_zip']).' '.print_address($od['b_addr1'], $od['b_addr2'], $od['b_addr3'], $od['b_addr_jibeon'])); ?></td>
			</tr>
			<?php if($od['memo']) { ?>
			<tr>
				<th scope="row">伝言</th>
				<td><?php echo conv_content($od['memo'], 0); ?></td>
			</tr>
			<?php } ?>
			</tbody>
			</table>
		</div>
	</section>

	<?php
	// 決済代行社別コード include (決済代行情報フィールド)
	require_once(TB_MSHOP_PATH.'/lg/orderform.2.php');
	?>

    <div id="show_progress" style="display:none;">
        <img src="<?php echo TB_MSHOP_URL; ?>/img/loading.gif" alt="">
        <span>注文完了中です。 少々お待ちください。</span>
    </div>

	</form>
</div>

<script>
/* 決済方法による処理後,決済登録要請の実行 */
function pay_approval()
{
    var f = document.sm_form;
    var pf = document.forderform;

    // 金額チェック
    if(!payment_check(pf))
        return false;

	var pay_method = "";
	var easy_pay = "";
	switch(pf.od_settle_case.value) {
		case "振込み":
			pay_method = "SC0030";
			break;
		case "仮想口座":
			pay_method = "SC0040";
			break;
		case "携帯電話":
			pay_method = "SC0060";
			break;
		case "クレジットカード":
			pay_method = "SC0010";
			break;
		case "簡便決済":
			easy_pay = "PAYNOW";
			break;
	}
	f.LGD_CUSTOM_FIRSTPAY.value = pay_method;
	f.LGD_BUYER.value = pf.od_name.value;
	f.LGD_BUYEREMAIL.value = pf.od_email.value;
	f.LGD_BUYERPHONE.value = pf.od_hp.value;
	f.LGD_AMOUNT.value = f.good_mny.value;
	f.LGD_EASYPAY_ONLY.value = easy_pay;
	<?php if($default['de_tax_flag_use']) { ?>
	f.LGD_TAXFREEAMOUNT.value = pf.comm_free_mny.value;
	<?php } ?>

	// 注文情報一時保存
	var order_data = $(pf).serialize();
	var save_result = "";
	$.ajax({
		type: "POST",
		data: order_data,
		url: tb_url+"/shop/ajax.orderdatasave.php",
		cache: false,
		async: false,
		success: function(data) {
			save_result = data;
		}
	});

	if(save_result) {
		alert(save_result);
		return false;
	}

	f.submit();

    return false;
}

function forderform_check()
{
    var f = document.forderform;

    // 金額チェック
    if(!payment_check(f))
        return false;

    if(f.res_cd.value != "0000") {
        alert("決済登録を要請した後,ご注文ください。");
        return false;
    }

    document.getElementById("display_pay_button").style.display = "none";
    document.getElementById("show_progress").style.display = "block";

    setTimeout(function() {
        f.submit();
    }, 300);
}

// 決済チェック
function payment_check(f)
{
    var tot_price = parseInt(f.good_mny.value);

	if(f.od_settle_case.value == /'振込み') {
		if(tot_price < 150) {
			alert("口座振込みは150ウォン以上の決済が可能です。");
			return false;
		}
	}

    if(f.od_settle_case.value == /'クレジットカード') {
		if(tot_price < 1000) {
			alert("クレジットカードは1000ウォン以上の決済が可能です。");
			return false;
		}
    }

	if(f.od_settle_case.value == /'携帯電話') {
		if(tot_price < 350) {
			alert("携帯電話は350ウォン以上の決済が可能です。");
			return false;
		}
    }

    return true;
}
</script>
<!-- } LGユープラス決済の終り -->
