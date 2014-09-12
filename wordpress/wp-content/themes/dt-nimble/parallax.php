<?php
return;
$show = true;
$show_opt = of_get_option('mr_parallax-show');

if( ('home' == $show_opt && !dt_storage('is_homepage')) || ('ex_home' == $show_opt && dt_storage('is_homepage')) || 'nowhere' == $show_opt ) {
    $show = false;
}

if( of_get_option('mr_parallax-enable') && $show ) {

    $parallax_lvls = array( 'first_level', 'second_level', 'third_level', 'forth_level' );
    $animate = '';
    $anim_opt = of_get_option('mr_parallax-animate');

    if( ('home' == $anim_opt && !dt_storage('is_homepage')) ||
        ('ex_home' == $anim_opt && dt_storage('is_homepage')) ||
        'nowhere' == $anim_opt ) {
            $animate = '{ xparallax: false, yparallax: false }';
    }
?>

    <script type="text/javascript">
        jQuery(document).ready( function() {
            initiate_parallax(<?php echo $animate; ?>);
        });
    </script>

<ul id="parallax">

<?php foreach( $parallax_lvls as $lvl_name ):

$style = sprintf( 'background-image: %s',
    dt_style_options_get_image( array(),
        of_get_option($lvl_name . '-bg_image', 'none'),
        of_get_option($lvl_name . '-bg_custom'),
        of_get_option($lvl_name . '-bg_upload')
    )
);

$style .= sprintf( 'background-position: %s',
    dt_style_options_get_bg_position(
        of_get_option($lvl_name . '-bg_horizontal_pos'),
        'top'
    )
);

$style .= sprintf( 'background-repeat: %s;',
    of_get_option($lvl_name . '-bg_repeat')
);

?>
    <li style="<?php echo $style; ?>"></li>
<?php endforeach; ?>

</ul>

<?php } ?>
