<?php if ( of_get_option( 'misc-show_top_line' ) ): ?>

<div id="top-bg">
    
    <div class="top-cont">
	
	<?php
		$contact_fields = array(
			array(
				'prefix'    => 'address',
				'ico_class' => 'adress' 
			),
			array(
				'prefix'    => 'phone',
				'ico_class' => 'ico-phone' 
			),
			array(
				'prefix'    => 'email',
				'ico_class' => 'ico-mail' 
			),
			array(
				'prefix'    => 'skype',
				'ico_class' => 'ico-scype' 
			),
			array(
				'prefix'    => 'work_hours',
				'ico_class' => 'ico-clock' 
			)
		);
		if( of_get_option('misc-show_header_contacts', false) ): ?>
		
		<div class="contact-block">
		
		<?php
		foreach ( $contact_fields as $field ) {
			if ( $data = of_get_option( 'misc-contact_' . $field['prefix'], false ) ): 
				echo '<span class="' . esc_attr( $field['ico_class'] ) . '">' . $data . '</span>';
			endif;
		}
		?>
		
		</div>
		
		<?php endif; ?>
		
		
		
        <?php dt_get_soc_links(); ?>
		
		<?php
		if( of_get_option('misc-show_search_top') ) {
			get_search_form();
		}
		?>
		<?php
		// WPML Flags
		if ( defined('ICL_SITEPRESS_VERSION') ):
			language_selector_flags();
		endif;
		?>
    </div>

</div>

<?php endif; ?>