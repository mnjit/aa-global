<?php
$logos = array(
	'logo' 			=> dt_get_uploaded_logo( of_get_option( 'branding-header_logo', array() ) ),
	'logo_retina'	=> dt_get_uploaded_logo( of_get_option( 'branding-retina_header_logo', array() ), 'retina' ),
	'mobile' 		=> dt_get_uploaded_logo( of_get_option( 'branding-header_mobile_logo', array() ) ),
	'mobile_retina' => dt_get_uploaded_logo( of_get_option( 'branding-retina_header_mobile_logo', array() ), 'retina' )
);
$default_logo = null;
$alt = get_bloginfo( 'name' );

// get default logo
foreach ( $logos as $logo ) {
	if ( $logo ) { $default_logo = $logo; break; }
}
?>
<header id="header">
	<div id="logo">

		<?php
		if ( $default_logo ):
			$logo = dt_get_retina_sensible_image( $logos['logo'], $logos['logo_retina'], $default_logo, 'id="dt-top-logo" class="dt-top-logo" alt="' . $alt . '"' );
			$logo_mob = dt_get_retina_sensible_image( $logos['mobile'], $logos['mobile_retina'], $default_logo, 'class="dt-top-logo-mobile" alt="' . $alt . '"' );
		?>
			
			<a href="<?php echo home_url(); ?>" class="logo"><?php echo $logo, $logo_mob; ?></a>
			
		<?php endif; ?>

	</div>

	<nav>

		<?php
		dt_menu( array(
			'menu_wraper' 	=> '<ul id="nav">%MENU_ITEMS%</ul>',
			'menu_items'	=> '<li %IS_FIRST%><a class="%ITEM_CLASS%" href="%ITEM_HREF%"%ESC_ITEM_TITLE%>%ITEM_TITLE%</a>%SUBMENU%</li>',
			'submenu' 		=> '<div><ul>%ITEM%</ul></div>'
		) );
		?>

	</nav>
</header>