<?php
if(class_exists('WP_Widget') && !class_exists('SteedCOM_widget_SliderItem')):
	class SteedCOM_widget_SliderItem extends WP_Widget {
		
		function __construct() {
			parent::__construct(
				'SteedCOM_widget_SliderItem', // Base ID of your widget
				__('(SC) Slider Item,', 'steed-companion'), // Widget name will appear in UI
				array( 
					'description' => __( 'Use it for slider item', 'steed-companion' ), 
					//'customize_selective_refresh' => true
				)
				
			);
			
			add_action( 'admin_enqueue_scripts', array($this, 'widgets_scripts') );
			add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
		}
		
		
		// Creating widget front-end
		public function widget( $args, $instance ) {		
			$title = (!empty($instance['title'])) ? apply_filters( 'widget_title', $instance['title'] ) : NULL;
			$color_mood = (!empty($instance['color_mood'])) ? 'color-'.$instance['color_mood'] : NULL;
			$img = (!empty($instance['img'])) ? $instance['img'] : NULL;
			$bg_color = (!empty($instance['bg_color'])) ? $instance['bg_color'] : NULL;
			$overlay = (!empty($instance['overlay'])) ? $instance['overlay'] : NULL;
		
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
				echo '<div class="scw-warp SteedCOM_widget_SliderItem '.esc_attr($color_mood).'" style="background-image:url('.esc_url($img).'); background-color:'.sanitize_hex_color($bg_color).';">';
					if(!empty($overlay)){ echo'<span class="scw-overlay" style="background-color:'.sanitize_hex_color($bg_color).'; opacity:'.esc_attr($overlay).';"></span>';}
					echo '<div class="scw-warp-in">'; 
						echo '<div class="scw-content">';
							echo '<div class="scw-content-in">';
								if(!empty($title)){ echo'<h2 class="scw-title">' . $title . '</h2>';}
								if(!empty($instance['subtitle'])){ echo '<h5 class="scw-subtitle">'.wp_kses_post($instance['subtitle']).'</h5>'; }
								if(!empty($instance['text'])){ echo '<div class="scw-text">'.wp_kses_post($instance['text']).'</div>'; }
								if(!empty($instance['link1'])){ echo '<a class="scw-button scw-button-1 pc-button" href="'.esc_url($instance['link1']).'">'.wp_kses_post($instance['button1']).'</a>'; }
								if(!empty($instance['link2'])){ echo '<a class="scw-button scw-button-2 pc-button-o" href="'.esc_url($instance['link2']).'">'.wp_kses_post($instance['button2']).'</a>'; }
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
			$overlay = (!empty($instance['overlay'])) ? $instance['overlay'] : NULL;
			
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
                <?php
				$src = (!empty($img)) ? $img : 'https://www.placehold.it/115x115';
				echo '
					<div class="upload" style="max-width:400px;">
						<img data-src="https://www.placehold.it/115x115" src="' . $src . '" style="max-width:100%; height:auto;"/>
						<div>
							<input id="'.$this->get_field_id( 'img' ).'" type="hidden" name="' . $this->get_field_name( 'img' ) . '" value="' . $img . '" />
							<button type="submit" class="scw-image-upload-btn button" title="Upload Image">' . __('Upload', 'igsosd') . '</button>
							<button type="submit" class="scw-image-remove-btn button" title="Remove Image">&times;</button>
						</div>
					</div>
				';
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
<p class="scw-overlay">
				<label for="<?php echo $this->get_field_id( 'overlay' ); ?>"><?php _e( 'Background Overlay:' ); ?></label> 
                <select class="widefat" id="<?php echo $this->get_field_id( 'overlay' ); ?>" name="<?php echo $this->get_field_name( 'overlay' ); ?>">
                	<option <?php selected( $overlay, '0' ); ?> value="0">0</option>
                    <option <?php selected( $overlay, '0.1' ); ?> value="0.1">0.1</option>
                    <option <?php selected( $overlay, '0.2' ); ?> value="0.2">0.2</option>
                    <option <?php selected( $overlay, '0.3' ); ?> value="0.3">0.3</option>
                    <option <?php selected( $overlay, '0.4' ); ?> value="0.4">0.4</option>
                    <option <?php selected( $overlay, '0.5' ); ?> value="0.5">0.5</option>
                    <option <?php selected( $overlay, '0.6' ); ?> value="0.6">0.6</option>
                    <option <?php selected( $overlay, '0.7' ); ?> value="0.7">0.7</option>
                    <option <?php selected( $overlay, '0.8' ); ?> value="0.8">0.8</option>
                    <option <?php selected( $overlay, '0.9' ); ?> value="0.9">0.9</option>
                    <option <?php selected( $overlay, '1' ); ?> value="1">1</option>
                </select>
			</p>
            
            <script type="text/javascript">
				jQuery(document).ready(function($) { 
					//jQuery('.scw-color-picker').wpColorPicker()
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
			$instance['overlay'] = ( ! empty( $new_instance['overlay'] ) ) ? esc_attr( $new_instance['overlay'] ) : '';
			
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
		
		
		function print_scripts() {
	                ?>
	                <script>
	                        ( function( $ ){
	                                function initColorPicker( widget ) {
	                                        widget.find( '.scw-color-picker' ).wpColorPicker( {
	                                                change: _.throttle( function() { // For Customizer
	                                                        $(this).trigger( 'change' );
	                                                }, 3000 )
	                                        });
	                                }
	
	                                function onFormUpdate( event, widget ) {
	                                        initColorPicker( widget );
	                                }
	
	                                $( document ).on( 'widget-added widget-updated', onFormUpdate );
	
	                                $( document ).ready( function() {
	                                        $( '#widgets-right .widget:has(.scw-color-picker)' ).each( function () {
	                                                initColorPicker( $( this ) );
	                                        } );
	                                } );
	                        }( jQuery ) );
	                </script>
	                <?php
	        }
	
	}
endif;