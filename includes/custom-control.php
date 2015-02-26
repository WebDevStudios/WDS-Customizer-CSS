<?php
class WDS_Custom_CSS_Textarea_Control extends WP_Customize_Control {

	public $type = 'textarea';

	/**
	 * Creates a longer textarea
	 */
	public function render_content() {
		?>
		<textarea rows="20" style="width:100%;padding:5px 8px;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		<?php
	}
}

