<?php
if(class_exists('WP_Widget') && !class_exists('SteedCOM_widget_AdvanceText')):
	class SteedCOM_widget_AdvanceText extends WP_Widget {
		
		function __construct() {
			parent::__construct(
				'SteedCOM_widget_AdvanceText', // Base ID of your widget
				__('(SC) Advance Text', 'steed-companion'), // Widget name will appear in UI
				array( 'description' => __( 'Advance Text widget which will help to build some sections', 'steed-companion' ), ) // Widget description
			);
			
			add_action( 'admin_enqueue_scripts', array($this, 'widgets_scripts') );
		}
		
		
		// Creating widget front-end
		public function widget( $args, $instance ) {		
			$title = (!empty($instance['title'])) ? apply_filters( 'widget_title', $instance['title'] ) : NULL;
			$color_mood = (!empty($instance['color_mood'])) ? 'color-'.$instance['color_mood'] : NULL;
		
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
				echo '<div class="scw-warp">';
					echo '<div class="scw-warp-in">'; 
						if(!empty($instance['img'])){ echo '<div class="scw-img"><img src="'.esc_url($instance['img']).'" alt="'.$title.'"></div>'; }
						if(!empty($instance['img'])){ echo '<div class="scw-img-bg" style="background-image:url('.esc_url($instance['img']).');"></div>'; }
						if(!empty($instance['link1'])){ echo '<a class="scw-link" href="'.esc_url($instance['link1']).'">&nbsp;</a>'; }
						echo '<div class="scw-content">';
							echo '<div class="scw-content-in">';
								if(!empty($title)){ echo $args['before_title'] . $title . $args['after_title'];}
								if(!empty($instance['subtitle'])){ echo '<h5 class="scw-subtitle">'.wp_kses_post($instance['subtitle']).'</h5>'; }
								if(!empty($instance['text'])){ echo '<div class="scw-text">'.wp_kses_post($instance['text']).'</div>'; }
								if(!empty($instance['link1'])){ echo '<a class="scw-button scw-button-1" href="'.esc_url($instance['link1']).'">'.wp_kses_post($instance['button1']).'</a>'; }
								if(!empty($instance['link2'])){ echo '<a class="scw-button scw-button-2" href="'.esc_url($instance['link2']).'">'.wp_kses_post($instance['button2']).'</a>'; }
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo $args['after_widget'];
		}
		
		
		
		// Widget Backend 
		public function form( $instance ) {
			if( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}else{
				$title = __( 'New title', 'wpb_widget_domain' );
			}
			
			$subtitle = (!empty($instance['subtitle'])) ? $instance['subtitle'] : NULL;
			$text = (!empty($instance['text'])) ? $instance['text'] : NULL;
			$link1 = (!empty($instance['link1'])) ? $instance['link1'] : NULL;
			$link2 = (!empty($instance['link2'])) ? $instance['link2'] : NULL;
			$button1 = (!empty($instance['button1'])) ? $instance['button1'] : NULL;
			$button2 = (!empty($instance['button2'])) ? $instance['button2'] : NULL;
			$img = (!empty($instance['img'])) ? $instance['img'] : NULL;
			$color_mood = (!empty($instance['color_mood'])) ? $instance['color_mood'] : NULL;
			$bg_color = (!empty($instance['bg_color'])) ? $instance['bg_color'] : NULL;
			$bg_hover_color = (!empty($instance['bg_hover_color'])) ? $instance['bg_hover_color'] : NULL;
			
			// Widget admin form
			?>
			<p class="scw-title">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
            <p class="scw-subtitle">
				<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Sub-Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo wp_kses_post( $subtitle ); ?>" />
			</p>
            <p class="scw-text">
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label> 
                <textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" style="height:150px;"><?php echo wp_kses_post( $text ); ?></textarea> 
			</p>
            <p class="scw-img">
				<label for="<?php echo $this->get_field_id( 'img' ); ?>"><?php _e( 'Image:' ); ?></label> 
                <table>
                	<tr>
                    	<td><input class="widefat" id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" type="text" value="<?php echo esc_url( $img ); ?>" /></td>
                        <td><input type="button" class="button button-primary" id="<?php echo $this->get_field_id( 'img' ); ?>-btn" value="Upload"  /></td>
                        <td><a href="#" class="button" id="<?php echo $this->get_field_id( 'img' ); ?>-remove">X</a></td>
                    </tr>
                </table>
                <?php 
					if ( $img == '' ){ $img_src = STEEDCOM_URL.'/assets/img/no-img.png'; }else{ $img_src = $img; }
					echo '<img src="' . $img_src . '" style="max-width:100%;" id="'.$this->get_field_id( 'img' ).'-src" /><br />'; 
				?>
                
			</p>
            <p class="scw-link1">
				<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e( 'Link:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" type="text" value="<?php echo esc_url( $link1 ); ?>" />
			</p>
            <p class="scw-button1">
				<label for="<?php echo $this->get_field_id( 'button1' ); ?>"><?php _e( 'Link Text:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'button1' ); ?>" name="<?php echo $this->get_field_name( 'button1' ); ?>" type="text" value="<?php echo wp_kses_post( $button1 ); ?>" />
			</p>
            <p class="scw-link2">
				<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e( 'Link #2:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" type="text" value="<?php echo esc_url( $link2 ); ?>" />
			</p>
            <p class="scw-button2">
				<label for="<?php echo $this->get_field_id( 'button2' ); ?>"><?php _e( 'Link #2 Text:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'button2' ); ?>" name="<?php echo $this->get_field_name( 'button2' ); ?>" type="text" value="<?php echo wp_kses_post( $button2 ); ?>" />
			</p>
            <p class="scw-color_mood">
				<label for="<?php echo $this->get_field_id( 'color_mood' ); ?>"><?php _e( 'Color Mood:' ); ?></label> 
                <select class="widefat" id="<?php echo $this->get_field_id( 'color_mood' ); ?>" name="<?php echo $this->get_field_name( 'color_mood' ); ?>">
                	<option <?php selected( $color_mood, 'dark' ); ?> value="dark">Dark</option>
                    <option <?php selected( $color_mood, 'light' ); ?> value="light">Light</option>
                </select>
			</p>
            <p class="scw-bg_color">
				<label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php _e( 'Background Color:' ); ?></label> <br>
				<input class="widefat scw-color-picker" id="<?php echo $this->get_field_id( 'bg_color' ); ?>" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo sanitize_hex_color( $bg_color ); ?>" />
			</p>
            <p class="scw-bg_hover_color">
				<label for="<?php echo $this->get_field_id( 'bg_hover_color' ); ?>"><?php _e( 'Background Hover Color:' ); ?></label> <br>
				<input class="widefat scw-color-picker" id="<?php echo $this->get_field_id('bg_hover_color'); ?>" name="<?php echo $this->get_field_name('bg_hover_color'); ?>" type="text" value="<?php echo sanitize_hex_color($bg_hover_color); ?>" />
			</p>
            
            <script type="text/javascript">
				jQuery(document).ready(function($) { 
					jQuery('.scw-color-picker').wpColorPicker()
				});
				jQuery(document).ready( function($) {
					function media_upload(button_class) {
						var _custom_media = true,
						_orig_send_attachment = wp.media.editor.send.attachment;
				
						$('body').on('click', button_class, function(e) {
							var button_id ='#'+$(this).attr('id');
							var self = $(button_id);
							var send_attachment_bkp = wp.media.editor.send.attachment;
							var button = $(button_id);
							var id = button.attr('id').replace('_button', '');
							_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
								if ( _custom_media  ) {
									$('#<?php echo $this->get_field_id( 'img' ); ?>').val(attachment.url);
									$('#<?php echo $this->get_field_id( 'img' ); ?>-src').attr('src',attachment.url).css('display','block');
								} else {
									return _orig_send_attachment.apply( button_id, [props, attachment] );
								}
							}
							wp.media.editor.open(button);
								return false;
						});
					}
					media_upload('#<?php echo $this->get_field_id( 'img' ); ?>-btn');
					
					$('body').on('click', '#<?php echo $this->get_field_id( 'img' ); ?>-remove', function(e) {
						$('#<?php echo $this->get_field_id( 'img' ); ?>').attr('value', '');
						$('#<?php echo $this->get_field_id( 'img' ); ?>-src').attr('src', '');
						return false;
					});
				});
			</script>
			<?php 
		}
		
		
		
		
		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['subtitle'] = ( ! empty( $new_instance['subtitle'] ) ) ? wp_kses_post( $new_instance['subtitle'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? wp_kses_post( $new_instance['text'] ) : '';
			$instance['link1'] = ( ! empty( $new_instance['link1'] ) ) ? esc_url( $new_instance['link1'] ) : '';
			$instance['link2'] = ( ! empty( $new_instance['link2'] ) ) ? esc_url( $new_instance['link2'] ) : '';
			$instance['button1'] = ( ! empty( $new_instance['button1'] ) ) ? wp_kses_post( $new_instance['button1'] ) : '';
			$instance['button2'] = ( ! empty( $new_instance['button2'] ) ) ? wp_kses_post( $new_instance['button2'] ) : '';
			$instance['img'] = ( ! empty( $new_instance['img'] ) ) ? esc_url( $new_instance['img'] ) : '';
			$instance['color_mood'] = ( ! empty( $new_instance['color_mood'] ) ) ? esc_attr( $new_instance['color_mood'] ) : '';
			$instance['bg_color'] = ( ! empty( $new_instance['bg_color'] ) ) ? sanitize_hex_color( $new_instance['bg_color'] ) : '';
			$instance['bg_hover_color'] = ( ! empty( $new_instance['bg_hover_color'] ) ) ? sanitize_hex_color( $new_instance['bg_hover_color'] ) : '';
			
			return $instance;
		}
		
		
		function widgets_scripts( $hook ) {
			if ( 'widgets.php' != $hook ) {
				return;
			}
			wp_enqueue_style( 'wp-color-picker' );        
			wp_enqueue_script( 'wp-color-picker' ); 
			wp_enqueue_media();
		}
	
	}
endif;