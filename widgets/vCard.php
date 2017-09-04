<?php
if(class_exists('WP_Widget') && !class_exists('SteedCOM_widget_vCard')):
	class SteedCOM_widget_vCard extends WP_Widget {
		
		function __construct() {
			parent::__construct(
				'SteedCOM_widget_vCard', // Base ID of your widget
				__('(SC) vCard', 'steed-companion'), // Widget name will appear in UI
				array( 
					'description' => __( 'Use it for Team member', 'steed-companion' ), 
					//'customize_selective_refresh' => true
				)
				
			);
			
			add_action( 'admin_enqueue_scripts', array($this, 'widgets_scripts') );
		}
		
		
		// Creating widget front-end
		public function widget( $args, $instance ) {		
			$title = (!empty($instance['title'])) ? apply_filters( 'widget_title', $instance['title'] ) : NULL;
			
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
				echo '<div class="scw-warp SteedCOM_widget_vCard">';
					echo '<div class="scw-warp-in">'; 
						echo '<div class="scw-content">';
							echo '<div class="scw-image">';
								if(!empty($instance['img'])){
									echo '<img src="'.esc_url($instance['img']).'" alt="' . $title . '">';
								}
							echo '</div>';
							echo '<div class="scw-des">';
								echo '<div class="scw-name">';
									if(!empty($title)){ echo'<h3 class="scw-title">' . $title . '</h3>';}
									if(!empty($instance['position'])){ echo '<h5 class="scw-position">'.wp_kses_post($instance['position']).'</h5>'; }
								echo '</div>';
								if(!empty($instance['text'])){ echo '<div class="scw-text">'.wp_kses_post($instance['text']).'</div>'; }
								echo '<div class="scw-links">';
									if(!empty($instance['wedsite'])){ echo '<a class="scw-website-link" href="'.esc_url($instance['wedsite']).'">Website</a>'; }
									if(!empty($instance['facebook'])){ echo '<a class="scw-facebook-link" href="'.esc_url($instance['facebook']).'">Facebook</a>'; }
									if(!empty($instance['twitter'])){ echo '<a class="scw-twitter-link" href="'.esc_url($instance['twitter']).'">Twitter</a>'; }
									if(!empty($instance['phone'])){ echo '<a class="scw-phone-link" href="tel:'.esc_attr($instance['phone']).'">Call Now</a>'; }
								echo '</div>';
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
				$title = __( 'People Name', 'steed-companion' );
			}
			
			$position = (!empty($instance['position'])) ? $instance['position'] : NULL;
			$text = (!empty($instance['text'])) ? $instance['text'] : NULL;
			
			$wedsite = (!empty($instance['wedsite'])) ? $instance['wedsite'] : NULL;
			$facebook = (!empty($instance['facebook'])) ? $instance['facebook'] : NULL;
			$twitter = (!empty($instance['twitter'])) ? $instance['twitter'] : NULL;
			$phone = (!empty($instance['phone'])) ? $instance['phone'] : NULL;
			
			$img = (!empty($instance['img'])) ? $instance['img'] : NULL;
			
			
			// Widget admin form
			?>
			<p class="scw-title">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'steed-companion'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
            <p class="scw-position">
				<label for="<?php echo $this->get_field_id( 'position' ); ?>"><?php _e( 'Position:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'position' ); ?>" name="<?php echo $this->get_field_name( 'position' ); ?>" type="text" value="<?php echo wp_kses_post( $position ); ?>" />
			</p>
            <p class="scw-text">
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:', 'steed-companion' ); ?></label> 
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
            <p class="scw-wedsite">
				<label for="<?php echo $this->get_field_id( 'wedsite' ); ?>"><?php _e( 'Wedsite:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'wedsite' ); ?>" name="<?php echo $this->get_field_name( 'wedsite' ); ?>" type="text" value="<?php echo esc_url( $wedsite ); ?>" />
			</p>
            <p class="scw-facebook">
				<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_url( $facebook ); ?>" />
			</p>
            <p class="scw-twitter">
				<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_url( $twitter ); ?>" />
			</p>
            <p class="scw-phone">
				<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" />
			</p>

            
            <script type="text/javascript">
				
			</script>
			<?php 
		}
		
		
		
		
		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['position'] = ( ! empty( $new_instance['position'] ) ) ? wp_kses_post( $new_instance['position'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? wp_kses_post( $new_instance['text'] ) : '';
			
			$instance['wedsite'] = ( ! empty( $new_instance['wedsite'] ) ) ? esc_url( $new_instance['wedsite'] ) : '';
			$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? esc_url( $new_instance['facebook'] ) : '';
			$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? esc_url( $new_instance['twitter'] ) : '';
			$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? esc_attr( $new_instance['phone'] ) : '';
			
			$instance['img'] = ( ! empty( $new_instance['img'] ) ) ? esc_url( $new_instance['img'] ) : '';
			
			return $instance;
		}
		
		
		function widgets_scripts( $hook ) {
			if ( 'widgets.php' != $hook ) {
				return;
			}
			wp_enqueue_media();
		}
	
	}
endif;