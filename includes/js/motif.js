(function( $ ) {
	var isRtl = 'rtl' === document.body.parentNode.dir,
		MotifControl, sidebar;

	// SIDEBAR
	sidebar = function( width ) {
		var margin = 'margin' + ( isRtl ? 'Right' : 'Left' );

		$('.wp-full-overlay').css( margin, width );
		$('.wp-full-overlay-sidebar').css( margin, -1 * width ).width( width );
	};

	MotifControl = wp.customize.Control.extend({
		ready: function() {
			var control  = this,
				setting  = this.setting,
				textarea = this.container.find( 'textarea' )[0],
				editor;

			// When the setting changes...
			setting.bind( function( to ) {
				// ...and the editor doesn't already have the CSS
				// update the editor's value.
				if ( to !== editor.getValue() )
					editor.setValue( to );
			});

			// Set our codemirror options.
			this.codemirror = $.extend( true, {}, this.codemirror, {
				// Get the current value to send to codemirror
				value: setting.get(),
				// When the editor finds a change...
				onChange: function() {
					// ...update the setting to that value.
					setting.set( editor.getValue() );
				}
			} );

			// Create the editor from the textarea.
			this.editor = editor = CodeMirror.fromTextArea( textarea, this.codemirror );
		},

		// focus: function() {
		// 	this.editor.focus();
		// 	this.editor.setCursor( this.editor.lineCount() );
		// },

		codemirror: {
			mode: 'text/css',
			lineNumbers: true,
			lineWrapping: true,
			matchBrackets: true,
			indentUnit: 4,
			indentWithTabs: true,
			enterMode: 'keep'
		}
	});

	// Controls with the type 'motif' should made into
	// MotifControls
	wp.customize.controlConstructor.wds_custom_css = MotifControl;

	// SIDEBAR
	wp.customize.bind( 'ready', function() {
		var section = $('#accordion-section-wds_custom_css_section'),
			originalSidebarWidth = $('.wp-full-overlay-sidebar').width();

		$('.customize-section-title').click( function() {
			sidebar( section.hasClass('open') ? 400 : originalSidebarWidth );
		});
	});
}( jQuery ));
