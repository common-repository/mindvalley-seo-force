<?php

class MVSF_Editor extends MVSF_Utils {
	
	function __construct(){
		parent::__construct();
		add_action('admin_init', array(&$this, 'add_custom_metabox'));
		add_action('admin_footer-post-new.php', array(&$this, 'seoforce_javascript'));
		add_action('admin_footer-post.php', array(&$this, 'seoforce_javascript'));
	}
	
	function add_custom_metabox(){
		$args=array(
		  'show_ui'   => true
		); 
		
		if(function_exists('get_post_types')){
			$post_types=get_post_types($args);
			foreach($post_types as $pt){
				add_meta_box( 'mvsf_todo', __( 'SEO To-Do List', 'mindvalley' ), 
						array(&$this, 'show_todolist'), $pt, 'side', 'high' );
			
			}
		}else{
			add_meta_box( 'mvsf_todo', __( 'SEO To-Do List', 'mindvalley' ), 
					array(&$this, 'show_todolist'), 'post', 'side', 'high' );
		}
	}
	
	function show_todolist(){
		global $post;
		
		if($post){
			$mvsf = get_post_meta($post->ID,'_mvsf',true);
			$done = $mvsf['done'];
		}
		if(empty($done)){
			$done = array();
		}

		if(!empty($this->settings['todo'])){
			$todos = explode("\n", $this->settings['todo']);
			$i = 1;
			echo '<ul class="mvsf todo">';
			foreach($todos as $todo){
				$checked = "";
				foreach($done as $d){
					if(trim($todo) == trim($d)){
						$checked = "checked";
						break;
					}
				}
				?>
				<li><input type="checkbox" name="mvsf[done][]" value="<?php echo $todo?>" <?php echo $checked?>> <?php echo $todo;?></li>
				<?php
			}
			echo '</ul>';
		}
		?>
		<style type="text/css">
			ul.mvsf.todo li {
				list-style:none;
			}
		</style>
		<?php
	}
	
	function seoforce_javascript(){
		?>
		<script>
		jQuery(document).ready(function(){
			jQuery('input#publish').click(function(){
				var t = jQuery(this);
				if( jQuery('div#aiosp').length > 0 ){
					var allok = true;

					if(jQuery('input[name=aiosp_title]').val() == ""){
						allok = false;
					}
					if(jQuery('textarea[name=aiosp_description]').val() == ""){
						allok = false;
					}
					if(jQuery('input[name=aiosp_keywords]').val() == ""){
						allok = false;
					}
					
					jQuery('.mvsf.todo input').each(function(){
						if(!this.checked){
							allok = false;
						}
					});
					
					if(!allok){
						<?php if($this->settings['stop_from_publish']) {?>
							alert("SEO Force Notice\n===========\nPost Status will remain as Draft before SEO TO-DO, SEO Title, SEO Descriptions or Keywords are completed");
						<?php }else{?>
							alert("SEO Force Notice\n===========\nSEO TO-DO, SEO Title, SEO Descriptions or Keywords are not completed.");
						<?php } ?>
					}
				}
			});

			function ucwords (str) {
			    // http://kevin.vanzonneveld.net
			    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
			    // +   improved by: Waldo Malqui Silva
			    // +   bugfixed by: Onno Marsman
			    // +   improved by: Robin
			    // +      input by: James (http://www.james-bell.co.uk/)
			    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
			    // *     example 1: ucwords('kevin van  zonneveld');
			    // *     returns 1: 'Kevin Van  Zonneveld'
			    // *     example 2: ucwords('HELLO WORLD');
			    // *     returns 2: 'HELLO WORLD'
			    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
			        return $1.toUpperCase();
			    });
			}

			var data = [];
			var data_uc = [];
			jQuery.each( "<?php echo str_replace("\r",'',str_replace("\n",'',$this->settings['keywords']))?>".split(",") ,function(){
				data.push(jQuery.trim(this));
				data_uc.push(ucwords(jQuery.trim(this)));
			});
			
			jQuery('input[name=aiosp_title], input#title').autocomplete(data_uc,{
						minChars: 0,
						multipleSeparator: ' ',
						multiple: true
			});
			jQuery('input[name=aiosp_keywords]').autocomplete(data,{
						minChars: 0,
						multiple: true
			});
		});
		</script>
		<?php
	}
}