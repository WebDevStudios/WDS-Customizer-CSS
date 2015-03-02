<?php
class WDS_Custom_CSS_Textarea_Control extends WP_Customize_Control {

	public $type = 'wds_custom_css';

	/**
	 * Creates a longer textarea
	 */
	public function render_content() {
		?>
		<textarea rows="20" style="width:100%;padding:5px 8px;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		<?php
	}
	public function enqueue() {
		wp_enqueue_script( 'motif-codemirror', plugins_url( "libs/codemirror/motif-codemirror.js", __FILE__ ), array(), '2.25' );
		wp_enqueue_style( 'motif-codemirror', plugins_url( "libs/codemirror/lib/codemirror.css", __FILE__ ), array(), '2.25' );

		wp_enqueue_script( 'motif', plugins_url( "js/motif.js", __FILE__ ), array( 'customize-controls', 'motif-codemirror' ), '20150301', true );
		wp_enqueue_style( 'motif', plugins_url( "css/motif.css", __FILE__ ), array( 'customize-controls', 'motif-codemirror' ), '20150301' );
	}
}

