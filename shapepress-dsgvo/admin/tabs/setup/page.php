<h1><?php _e('Setup', 'shapepress-dsgvo'); ?></h1><hr>

<form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
	<input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOCreatePageAction::getActionName()); ?>">

	
		
</form>
