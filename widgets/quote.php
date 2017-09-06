<?php
if(class_exists('WP_Widget') && !class_exists('SteedCOM_widget_quote')):
	class SteedCOM_widget_quote extends WP_Widget {
		
		function __construct() {
			parent::__construct(
				'SteedCOM_widget_quote', // Base ID of your widget
				__('(SC) Quote', 'steed-companion'), // Widget name will appear in UI
				array( 
					'description' => __( 'Use it for Testimonials', 'steed-companion' ), 
					//'customize_selective_refresh' => true
				)
				
			);
			
			add_action( 'admin_enqueue_scripts', array($this, 'widgets_scripts') );
		}
		
		
		// Creating widget front-end
		public function widget( $args, $instance ) {		
			$title = (!empty($instance['title'])) ? apply_filters( 'widget_title', $instance['title'] ) : NULL;
			$link_start = '';
			$link_end = '';
			if(!empty($instance['link'])){ 
				$link_start = '<a class="scw-website-link" href="'.esc_url($instance['link']).'" target="_blank" rel="nofollow">';
				$link_end = '</a>';
			}
			
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
				echo '<div class="scw-warp SteedCOM_widget_quote">';
					echo '<div class="scw-warp-in">'; 
						
						if(!empty($instance['text'])){ echo '<div class="scw-text">'.wp_kses_post($instance['text']).'</div>'; }
						
						echo '<div class="scw-meta">';
							if(!empty($instance['img'])){ echo '<div class="scw-image"><span style="background-image:url('.esc_url($instance['img']).');"></span></div>'; }
							echo '<div class="scw-names">';
								if(!empty($title)){ echo '<h4>'. $link_start . $title . $link_end .'</h4>';}
								if(!empty($instance['position'])){ echo '<strong>'. $link_start . $instance['position'] . $link_end .'</strong>';}
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
				$title = __( 'Name', 'steed-companion' );
			}
			
			$position = (!empty($instance['position'])) ? $instance['position'] : NULL;
			$text = (!empty($instance['text'])) ? $instance['text'] : NULL;
			$link = (!empty($instance['link'])) ? $instance['link'] : NULL;
			$img = (!empty($instance['img'])) ? $instance['img'] : NULL;
			
			
			// Widget admin form
			?>
			<p class="scw-title">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Name:' , 'steed-companion'); ?></label> 
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
            <p class="scw-link">
				<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
			</p>
			<?php 
		}
		
		
		
		
		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['position'] = ( ! empty( $new_instance['position'] ) ) ? wp_kses_post( $new_instance['position'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? wp_kses_post( $new_instance['text'] ) : '';
			$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? esc_url( $new_instance['link'] ) : '';
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