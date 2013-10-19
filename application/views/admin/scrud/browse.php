<div class="container" >
		<h2><?php echo $conf['title']; ?></h2>
		<?php if (!empty($components)){	?>
		<ul class="nav nav-tabs" id="auth_tab" style="margin-bottom: 0px;">
            <?php foreach ($components as $com){
				$permissions = $this->crud_auth->getPermissionType($com['id']);
				if (!in_array(4, $permissions)) continue;
				
				if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$com['id']).'/'.$com['component_table'].'.php' )) continue;
				?>
			<li <?php if ($com['id'] == $_GET['com_id']){?> class="active" <?php }?>><a href="<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
			<?php } ?>
        </ul>
        <?php } ?>
		<?php echo $content; ?>
</div>