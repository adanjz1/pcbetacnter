<?php
$_lang = $this->session->userdata('lang');
$_c_lang = $this->input->cookie('lang', true);

if(isset($_GET['lang'])){
	$defaultLang = $_GET['lang'];
}else if(!empty($_lang)){
	$defaultLang = $_lang;
}else if(!empty($_c_lang)){
	$defaultLang = $_c_lang;
}else{
	$this->db->select('*');
	$this->db->from('crud_settings');
	$this->db->where('setting_key',sha1('general'));
	$query = $this->db->get();
	$setting = $query->row_array();
	$setting = unserialize($setting['setting_value']);
	 
	if (!empty($setting['default_language']) && trim($setting['default_language']) != ''){
		$defaultLang = $setting['default_language'];
	}else{
		$defaultLang = '';
	}
}
?>
<br />
<br />
<br />
<div class="navbar navbar-fixed-bottom hidden-phone" id="status">
	<div class="btn-toolbar">
		<div class="btn-group pull-right" style="margin-top: 2px;">
			<p>
				<select onchange="change_language(this);"
					style="width: auto; display: inline-block; margin: 0px; padding: 0px; height: 22px; line-height: 22px;">
					<?php if (!empty($languages)){?>
					<?php foreach ($languages as $language){?>
					<option value="<?php echo $language['language_code']; ?>"
					<?php if ($language['language_code'] == $defaultLang){?>
						selected="selected" <?php }?>>
						<?php echo htmlspecialchars($language['language_name']); ?>
					</option>
					<?php }?>
					<?php }?>
				</select>
			</p>
		</div>

		<div class="btn-group" style="margin-top: 3px;">
			<?php echo $this->lang->line('copyright_company'); ?>
		</div>

	</div>
</div>

<script>
function change_language(obj) {
	var url = window.location.href;
	var n = url.indexOf("?");
<?php 
$q = array();
if (!empty($_SERVER['QUERY_STRING'])) {
	parse_str($_SERVER['QUERY_STRING'], $q);
}
if (isset($q['lang']))
	unset($q['lang']);

?>
<?php if (!empty($q)){?>
		window.location = window.location = "?<?php echo http_build_query($q, '', '&'); ?>&lang="+obj.value;
<?php }else{ ?>
		window.location = "?lang="+obj.value;
<?php } ?>
	
}
</script>
