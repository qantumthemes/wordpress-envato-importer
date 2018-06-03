<?php
		$user = get_option("qwim_envatousername");
		$apikey = get_option("qwim_apikey");
		$url = "http://marketplace.envato.com/api/edge/".$user."/".$apikey."/verify-purchase:[purchase].json";
?>

<h1>Verify User Purchase</h1>

<form method="post" action="tools.php?page=qtenvatoimp_settings&tab=settings" novalidate="novalidate">
	<input type="hidden" name="option_page" value="QWIM_VERIFYPURCHASE">
	<input type="hidden" name="action" value="verify">
	<?php wp_referer_field() ?>
	<?php wp_nonce_field('qwim_settingsform_update','qwim_settingsform'); ?>
	<input type="hidden" value="<?php echo $url; ?>" id="url">
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="qwim_purchasecode">Purchase Code</label></th>
				<td><input name="qwim_purchasecode" type="text" id="qwim_purchasecode" class="regular-text"></td>
			</tr>
		</tbody>
	</table>
	<p class="submit"><input type="submit" data-url="<?php echo $url; ?>" name="submit" id="qwVerifyPurchase" class="button button-primary" value="Verify Purchase"></p>
</form>
<p id="qwAnswer"></p>