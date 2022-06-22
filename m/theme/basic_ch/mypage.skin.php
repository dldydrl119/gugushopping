<?php
if(!defined("_TUBEWEB_")) exit; // 个别页面无法访问
?>

<div id="smb_my">
	<section id="smb_my_ov">
        <h2>会员信息概要</h2>
        <ul>
            <li>保有券<a href="<?php echo TB_MSHOP_URL; ?>/coupon.php"><?php echo display_qty($cp_count); ?></a></li>
            <li>持仓点<a href="<?php echo TB_MSHOP_URL; ?>/point.php"><?php echo display_point($member['point']); ?></a></li>
        </ul>
        <dl>
            <dt>联络处</dt>
            <dd><?php echo ($member['telephone'] ? $member['telephone'] : /'未登记'); ?></dd>
            <dt>E-Mail</dt>
            <dd><?php echo ($member['email'] ? $member['email'] : /'未登记'); ?></dd>
            <dt>最终登录日期</dt>
            <dd><?php echo $member['today_login']; ?></dd>
            <dt>会员注册日期</dt>
            <dd><?php echo $member['reg_time']; ?></dd>
            <dt class="ov_addr">住址</dt>
            <dd class="ov_addr"><?php echo sprintf("(%s)", $member['zip']).' '.print_address($member['addr1'], $member['addr2'], $member['addr3'], $member['addr_jibeon']); ?></dd>
        </dl>
    </section>

    <section id="smb_my_od">
        <h2 class="anc_tit">最近订货明细<span class="fr"><a href="<?php echo TB_MSHOP_URL; ?>/orderinquiry.php" class="btn_txt">查看更多<i class="fa fa-angle-right"></i></a></span></h2>
		<ul id="sod_inquiry">
			<?php
			$sql = " select *
					   from shop_order
					  where mb_id = '$member[id]'
						and dan != '0'
					  group by od_id
					  order by index_no desc limit 3 ";
			$result = sql_query($sql);
			for($i=0; $row=sql_fetch_array($result); $i++)
			{
				echo '<li>'.PHP_EOL;

				$sql = " select * from shop_cart where od_id = '$row[od_id]' ";
				$sql.= " group by gs_id order by io_type asc, index_no asc ";
				$res = sql_query($sql);
				for($k=0; $ct=sql_fetch_array($res); $k++) {
					$rw = get_order($ct['od_no']);
					$gs = unserialize($rw['od_goods']);

					$href = TB_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

					$dlcomp = explode('|', trim($rw['delivery']));

					$delivery_str = '';
					if($dlcomp[0] && $rw['delivery_no']) {
						$delivery_str = get_text($dlcomp[0]).' '.get_text($rw['delivery_no']);
					}

					$uid = md5($rw['od_id'].$rw['od_time'].$rw['od_ip']);

					if($k == 0) {
			?>
				<div class="inquiry_idtime">
					<a href="<?php echo TB_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>" class="idtime_link"><?php echo $rw['od_id']; ?></a>
					<span class="idtime_time"><?php echo substr($rw['od_time'],2,8); ?></span>
				</div>
				<?php } ?>
				<div class="inquiry_info">
					<div class="inquiry_name">
						<a href="<?php echo $href; ?>"><?php echo get_text($gs['gname']); ?></a>
					</div>
					<div class="inquiry_price">
						<?php echo display_price($rw['use_price']); ?>
					</div>
					<div class="inquiry_inv">
						<span class="inv_status"><?php echo $gw_status[$rw['dan']]; ?></span>
						<span class="inv_inv"><?php echo $delivery_str; ?></span>
					</div>
				</div>

			<?php
				}
				echo '</li>'.PHP_EOL;
			}

			if($i == 0)
				echo '<li class="empty_list">无订单明细。</li>';
			?>
		</ul>
    </section>

	<section id="smb_my_wish">
        <h2 class="anc_tit">最近的愿望清单<span class="fr"><a href="<?php echo TB_MSHOP_URL; ?>/wish.php" class="btn_txt">查看更多<i class="fa fa-angle-right"></i></a></span></h2>
        <ul>
            <?php
            $sql = " select *
					   from shop_wish a, shop_goods b
                      where a.mb_id = '{$member['id']}'
                        and a.gs_id = b.index_no
                      order by a.wi_id desc
                      limit 0, 3 ";
            $result = sql_query($sql);
            for($i=0; $row=sql_fetch_array($result); $i++)
            {
                $image_w = 50;
                $image_h = 50;
                $image = get_it_image($row['gs_id'], $row['simg1'], $image_w, $image_h, true);
                $list_left_pad = $image_w + 10;
            ?>
            <li style="padding-left:<?php echo $list_left_pad + 10; ?>px">
                <div class="wish_img"><?php echo $image; ?></div>
                <div class="wish_info"><a href="<?php echo TB_MSHOP_URL; ?>/view.php?gs_id=<?php echo $row['gs_id']; ?>"><?php echo stripslashes($row['gname']); ?></a></div>
				<span class="info_date">保管日 <?php echo substr($row['wi_time'], 2, 8); ?></span>
            </li>
            <?php
            }
            if($i == 0) echo '<li class="empty_list">保管明细不存在。</li>';
            ?>
        </ul>
    </section>
</div>
