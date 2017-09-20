<?php
if(class_exists('WP_Widget') && !class_exists('SteedCOM_widget_service')):
	class SteedCOM_widget_service extends WP_Widget {
		
		function __construct() {
			parent::__construct(
				'steedcom_widget_service', // Base ID of your widget
				__('(SC) Service', 'steed-companion'), // Widget name will appear in UI
				array( 
					'description' => __( 'Use it for Services', 'steed-companion' ), 
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
				$link_start = '<a href="'.esc_url($instance['button_link']).'">';
				$link_end = '</a>';
			}
			
			$button_link = (!empty($instance['button_link'])) ? $instance['button_link'] : NULL;
			$button_text = (!empty($instance['button_text'])) ? $instance['button_text'] : NULL;
			$text = (!empty($instance['text'])) ? $instance['text'] : NULL;
			$subtitle = (!empty($instance['subtitle'])) ? $instance['subtitle'] : NULL;
			$img = (!empty($instance['img'])) ? $instance['img'] : NULL;
			
			$button_size = (!empty($instance['button_size'])) ? $instance['button_size'] : NULL;
			$button_radius = (!empty($instance['button_radius'])) ? $instance['button_radius'] : NULL;
			$button_style = (!empty($instance['button_style'])) ? $instance['button_style'] : NULL;
			$button_color = (!empty($instance['button_color'])) ? $instance['button_color'] : NULL;
			
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
				echo '<div class="scw-warp SteedCOM_widget_service">';
					echo '<div class="scw-warp-in">'; 
						
						if(!empty($instance['img'])){ 
							echo '<div class="scw-image-bg">'.$link_start.'<span style="background-image:url('.esc_url($img).');"></span>'.$link_end.'</div>';
							echo '<div class="scw-image">'.$link_start.'<img src="'.esc_url($img).'" alt="'.$title.'">'.$link_end.'</div>';
						}
						
						echo '<div class="scw-content">';
							echo '<div class="scw-headings">';
								if(!empty($title)){ echo '<h4>' . $link_start . $title . $link_end .'</h4>';}
								if(!empty($instance['subtitle'])){ echo '<strong>'.$subtitle .'</strong>';}
							echo '</div>';
							if(!empty($text)){ echo '<div class="scw-text">'.wp_kses_post($text).'</div>'; }
						echo '</div>';
						
						if($button_link){
							$button1_class = 'pc-btn';
							if($button_size){ $button1_class .= ' pc-btn-'.$button_size; }
							if($button_radius){ $button1_class .= ' pc-btn-'.$button_radius; }
							if($button_style && $button_color){ $button1_class .= ' pc-btn-'.$button_style.'-'.$button_color.''; }
							echo '<a class="'.$button1_class.'" href="'.esc_url($button_link).'" target="_blank" rel="nofollow">'.wp_kses_post($button_text).'</a>';
						}
						
					echo '</div>';
				echo '</div>';
			echo $args['after_widget'];
		}
		
		
		
		// Widget Backend 
		public function form( $instance ) {
			if( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}else{
				$title = __( 'Service Name', 'steed-companion' );
			}
			
			$subtitle = (!empty($instance['subtitle'])) ? $instance['subtitle'] : NULL;
			$text = (!empty($instance['text'])) ? $instance['text'] : NULL;
			$button_link = (!empty($instance['button_link'])) ? $instance['button_link'] : NULL;
			$button_text = (!empty($instance['button_text'])) ? $instance['button_text'] : NULL;
			$img = (!empty($instance['img'])) ? $instance['img'] : NULL;
			
			$button_size = (!empty($instance['button_size'])) ? $instance['button_size'] : NULL;
			$button_radius = (!empty($instance['button_radius'])) ? $instance['button_radius'] : NULL;
			$button_style = (!empty($instance['button_style'])) ? $instance['button_style'] : NULL;
			$button_color = (!empty($instance['button_color'])) ? $instance['button_color'] : NULL;
			
			
			// Widget admin form
			?>
			<p class="scw-title">
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Name:' , 'steed-companion'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
            <p class="scw-subtitle">
				<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Sub-Title:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo wp_kses_post( $subtitle ); ?>" />
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
            <p class="scw-button_link">
				<label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e( 'Button Link:', 'steed-companion' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo esc_url( $button_link ); ?>" />
			</p>
            <p class="scw-button_text">
				<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text:' , 'steed-companion'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
			</p>
            <div class="scw-button" style="border:solid 1px #eee; box-sizing:border-box; padding:10px; margin-bottom:20px;">
            	<strong>Button Style</strong>
                <table>
                	<tr>
                    	<td style="width:50%;">
                        	<label for="<?php echo $this->get_field_id( 'button_style' ); ?>">Style:</label>
                        	<select class="widefat" id="<?php echo $this->get_field_id( 'button_style' ); ?>" name="<?php echo $this->get_field_name( 'button_style' ); ?>">
                             	<option <?php selected( $button_style, '' ); ?> value=""></option>
                                <option <?php selected( $button_style, 'fill' ); ?> value="fill">Fill</option>
         						<option <?php selected( $button_style, 'border' ); ?> value="border">Border</option>
                            </select>
                        </td>
                        <td style="width:50%;">
                        	<label for="<?php echo $this->get_field_id( 'button_color' ); ?>">Color:</label>
                        	<select class="widefat" id="<?php echo $this->get_field_id( 'button_color' ); ?>" name="<?php echo $this->get_field_name( 'button_color' ); ?>">
                            	<option <?php selected( $button_style, '' ); ?> value=""></option>
                                <option <?php selected( $button_color, 'primary' ); ?> value="primary">primary</option>
         						<option <?php selected( $button_color, 'light' ); ?> value="light">light</option>
                                <option <?php selected( $button_color, 'dark' ); ?> value="dark">dark</option>
                                <option <?php selected( $button_color, 'green' ); ?> value="green">green</option>
                                <option <?php selected( $button_color, 'red' ); ?> value="red">red</option>
                            </select>
                        </td>
					</table>
                    <table>
                        <td style="width:50%;">
                        	<label for="<?php echo $this->get_field_id( 'button_size' ); ?>">Size:</label>
                        	<select class="widefat" id="<?php echo $this->get_field_id( 'button_size' ); ?>" name="<?php echo $this->get_field_name( 'button_size' ); ?>">
                            	<option <?php selected( $button_style, '' ); ?> value=""></option>
                                <option <?php selected( $button_size, 'md' ); ?> value="md">default</option>
                                <option <?php selected( $button_size, 'xl' ); ?> value="xl">xl</option>
         						<option <?php selected( $button_size, 'lg' ); ?> value="lg">lg</option>
                                <option <?php selected( $button_size, 'sm' ); ?> value="sm">sm</option>
                                <option <?php selected( $button_size, 'xs' ); ?> value="xs">xs</option>
                            </select>
                        </td>
                        <td style="width:50%;">
                        	<label for="<?php echo $this->get_field_id( 'button_radius' ); ?>">Radius:</label>
                        	<select class="widefat" id="<?php echo $this->get_field_id( 'button_radius' ); ?>" name="<?php echo $this->get_field_name( 'button_radius' ); ?>">
                            	<option <?php selected( $button_style, '' ); ?> value=""></option>
                                <option <?php selected( $button_radius, 'round' ); ?> value="round">round</option>
         						<option <?php selected( $button_radius, 'squire' ); ?> value="squire">squire</option>
                                <option <?php selected( $button_radius, 'pill' ); ?> value="pill">pill</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
			<?php 
		}
		
		
		
		
		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['subtitle'] = ( ! empty( $new_instance['subtitle'] ) ) ? wp_kses_post( $new_instance['subtitle'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? wp_kses_post( $new_instance['text'] ) : '';
			$instance['button_text'] = ( ! empty( $new_instance['button_text'] ) ) ? wp_kses_post( $new_instance['button_text'] ) : '';
			$instance['button_link'] = ( ! empty( $new_instance['button_link'] ) ) ? esc_url( $new_instance['button_link'] ) : '';
			$instance['img'] = ( ! empty( $new_instance['img'] ) ) ? esc_url( $new_instance['img'] ) : '';
			
			$instance['button_size'] = ( ! empty( $new_instance['button_size'] ) ) ? esc_attr( $new_instance['button_size'] ) : '';
			$instance['button_radius'] = ( ! empty( $new_instance['button_radius'] ) ) ? esc_attr( $new_instance['button_radius'] ) : '';
			$instance['button_style'] = ( ! empty( $new_instance['button_style'] ) ) ? esc_attr( $new_instance['button_style'] ) : '';
			$instance['button_color'] = ( ! empty( $new_instance['button_color'] ) ) ? esc_attr( $new_instance['button_color'] ) : '';
			
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