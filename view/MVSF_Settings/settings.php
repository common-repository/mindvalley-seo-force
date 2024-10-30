<script>
	jQuery(document).ready(function(){
		jQuery('.fade').delay('3000').fadeOut();
	})
</script>
<?php
	if ($message){
		echo "<div id=\"message\" class=\"updated fade\"><p>$message</p></div>";
	}

?>
	<div id="dropmessage" class="updated" style="display:none;"></div>
	<div class="wrap mvsf">
    	<div id="icon-tools" class="icon32"></div>
    	<h2><?php _e('Mindvalley SEO Force Settings', 'mindvalley'); ?></h2>
		<div class="clear"><br /></div>
        <form method="post" action="">
			<fieldset>
				<legend><strong>Notification Settings</strong></legend>
                <br />
				<input type="radio" name="settings[stop_from_publish]" value="1" <?php checked($mvsf_settings['stop_from_publish'],'1')?>> Alert &amp; Prevent From Publishing 
				<input type="radio" name="settings[stop_from_publish]" value="0" <?php checked($mvsf_settings['stop_from_publish'],'0')?>> Alert Only
            </fieldset>
            <br />
			<fieldset>
                <legend><strong>Emails to Notify</strong></legend>
                <br />
				<textarea name="settings[emails]" cols="65" rows="5"><?php echo $mvsf_settings['emails']?></textarea>
                <br />
                <em>* One email per line. An email will be sent to these emails when there's a new post / page creation. </em>
            </fieldset>
            <br />
            <fieldset>
                <legend><strong>Email Template</strong></legend>
                <br />
				<textarea name="settings[template]" cols="65" rows="5"><?php echo $mvsf_settings['template']?></textarea>
                <br />
                <em>* Post Edit Link - %post_edit_link% </em><br />
                <em>* Post URL - %post_url% </em><br />
                <em>* Post Title - %post_title% </em>
            </fieldset>
            <br />
            <fieldset>
                <legend><strong>Keywords Suggestions</strong></legend>
                <br />
				<textarea name="settings[keywords]" cols="65" rows="5"><?php echo $mvsf_settings['keywords']?></textarea>
                <br />
                <em>* Separate by comma.</em>
            </fieldset>
			<br />
            <fieldset>
                <legend><strong>SEO To-Do List</strong></legend>
                <br />
				<textarea name="settings[todo]" cols="65" rows="5"><?php echo $mvsf_settings['todo']?></textarea>
                <br />
                <em>* One Task per line.</em>
            </fieldset>
			<br />
            <input type="submit" name="mvsf_settings" value="Save Settings" />
            
        </form>
        
	</div>
	<script>
		jQuery(document).ready(function(){
			jQuery('.mvsf textarea').autoGrow();
		});
	</script>