<?php

/* Web fonts ajax fonts list refresh
 * Javascript function dtWebfontsRefresh located in js/options-custom.js
 **/
function dt_theme_options_web_fonts_refresh_ajax () {
	$nonce = ! empty( $_POST['nonce'] ) ? $_POST['nonce'] : '';

	$fonts_list = '';
	if ( wp_verify_nonce( $nonce, 'dt_webfonts_refresh' ) ) {
		// clear fonts cache
		delete_transient( 'dt_admin_fonts_list' );
		
		// get fresh fonts list or default one (if there is some errors)
		$fonts_list_raw = dt_get_google_fonts_list();
		
		// form new list options
		foreach ( $fonts_list_raw as $value=>$title ) {
			$fonts_list .= '<option value="' . esc_attr( $value ) . '">' . esc_html( $title ) . '</option>';
		}
		
		$fonts_list = '<select>' . $fonts_list . '</select>';
		
		$errors = dt_get_google_fonts_errors();
	}
	?><div id="fonts-list"><?php echo $fonts_list; ?></div><div id="errors"><?php echo $errors; ?></div><?php
	// IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_dt_refresh_web_fonts', 'dt_theme_options_web_fonts_refresh_ajax' );

// TODO: remove
// function that get array of cufon fonts
function dt_get_fonts_in( $dir = 'fonts' ){
    $res = array();
    $dirname = dirname(__FILE__). '/../../../' .$dir;
    if ($handle = opendir( $dirname ) ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $f_name = preg_split( '/\.[^.]+$/', $file );
                $f_name = str_replace( array('_', '.font'), array(' ', ''), ucfirst(strtolower($f_name[0])) );
                $res['/' . $dir . '/' .$file] = $f_name;
            }
        }
        closedir($handle);
    }
    if( empty($res) ){
        $res['none'] = _x( 'no fonts', 'backend', LANGUAGE_ZONE );
    }
    return $res;
}

function dt_get_websafe_fonts() {
	$fonts = array(
		'Andale_Mono'                   => 'Andale Mono',
		'Arial'                         => 'Arial',
		'Arial_Bold'                    => 'Arial Bold',
		'Arial_Italic'                  => 'Arial Italic',
		'Arial_Bold_Italic'             => 'Arial Bold Italic',
		'Arial_Black'                   => 'Arial Black',
		'Comic_Sans_MS'                 => 'Comic Sans MS',
		'Comic_Sans_MS_Bold'            => 'Comic Sans MS Bold',
		'Courier_New'                   => 'Courier New',
		'Courier_New_Bold'              => 'Courier New Bold',
		'Courier_New_Italic'            => 'Courier New Italic',
		'Courier_New_Bold_Italic'       => 'Courier New Bold Italic',
		'Georgia'                       => 'Georgia',
		'Georgia_Bold'                  => 'Georgia Bold',
		'Georgia_Italic'                => 'Georgia Italic',
		'Georgia_Bold_Italic'           => 'Georgia Bold Italic',
		'Impact_Lucida_Console'         => 'Impact Lucida Console',
		'Lucida_Sans_Unicode'           => 'Lucida Sans Unicode',
		'Marlett'                       => 'Marlett',
		'Minion_Web'                    => 'Minion Web',
		'Symbol'                        => 'Symbol',
		'Times_New_Roman'               => 'Times New Roman',
		'Times_New_Roman_Bold'          => 'Times New Roman Bold',
		'Times_New_Roman_Italic'        => 'Times New Roman Italic',
		'Times_New_Roman_Bold_Italic'   => 'Times New Roman Bold Italic',
		'Tahoma'                        => 'Tahoma',
		'Trebuchet_MS'                  => 'Trebuchet MS',
		'Trebuchet_MS_Bold'             => 'Trebuchet MS Bold',
		'Trebuchet_MS_Italic'           => 'Trebuchet MS Italic',
		'Trebuchet_MS_Bold_Italic'      => 'Trebuchet MS Bold Italic',
		'Verdana'                       => 'Verdana',
		'Verdana_Bold'                  => 'Verdana Bold',
		'Verdana_Italic'                => 'Verdana Italic',
		'Verdana_Bold_Italic'           => 'Verdana Bold Italic',
		'Webdings'                      => 'Webdings'
	);
	return $fonts;
}

// get google fonts list and cache it
function dt_get_google_fonts_list( $get_defaults = false ) {
	$default_lst = array (
	  'ABeeZee' => 'ABeeZee',
	  'ABeeZee:400italic' => 'ABeeZee  italic',
	  'Abel' => 'Abel',
	  'Abril Fatface' => 'Abril Fatface',
	  'Aclonica' => 'Aclonica',
	  'Acme' => 'Acme',
	  'Actor' => 'Actor',
	  'Adamina' => 'Adamina',
	  'Advent Pro:100' => 'Advent Pro bold (100) ',
	  'Advent Pro:200' => 'Advent Pro bold (200) ',
	  'Advent Pro:300' => 'Advent Pro bold (300) ',
	  'Advent Pro' => 'Advent Pro',
	  'Advent Pro:500' => 'Advent Pro bold (500) ',
	  'Advent Pro:600' => 'Advent Pro bold (600) ',
	  'Advent Pro:700' => 'Advent Pro bold (700) ',
	  'Aguafina Script' => 'Aguafina Script',
	  'Akronim' => 'Akronim',
	  'Aladin' => 'Aladin',
	  'Aldrich' => 'Aldrich',
	  'Alegreya' => 'Alegreya',
	  'Alegreya:400italic' => 'Alegreya  italic',
	  'Alegreya:700' => 'Alegreya bold (700) ',
	  'Alegreya:700italic' => 'Alegreya bold (700) italic',
	  'Alegreya:900' => 'Alegreya bold (900) ',
	  'Alegreya:900italic' => 'Alegreya bold (900) italic',
	  'Alegreya SC' => 'Alegreya SC',
	  'Alegreya SC:400italic' => 'Alegreya SC  italic',
	  'Alegreya SC:700' => 'Alegreya SC bold (700) ',
	  'Alegreya SC:700italic' => 'Alegreya SC bold (700) italic',
	  'Alegreya SC:900' => 'Alegreya SC bold (900) ',
	  'Alegreya SC:900italic' => 'Alegreya SC bold (900) italic',
	  'Alex Brush' => 'Alex Brush',
	  'Alfa Slab One' => 'Alfa Slab One',
	  'Alice' => 'Alice',
	  'Alike' => 'Alike',
	  'Alike Angular' => 'Alike Angular',
	  'Allan' => 'Allan',
	  'Allan:700' => 'Allan bold (700) ',
	  'Allerta' => 'Allerta',
	  'Allerta Stencil' => 'Allerta Stencil',
	  'Allura' => 'Allura',
	  'Almendra' => 'Almendra',
	  'Almendra:400italic' => 'Almendra  italic',
	  'Almendra:700' => 'Almendra bold (700) ',
	  'Almendra:700italic' => 'Almendra bold (700) italic',
	  'Almendra SC' => 'Almendra SC',
	  'Amarante' => 'Amarante',
	  'Amaranth' => 'Amaranth',
	  'Amaranth:400italic' => 'Amaranth  italic',
	  'Amaranth:700' => 'Amaranth bold (700) ',
	  'Amaranth:700italic' => 'Amaranth bold (700) italic',
	  'Amatic SC' => 'Amatic SC',
	  'Amatic SC:700' => 'Amatic SC bold (700) ',
	  'Amethysta' => 'Amethysta',
	  'Anaheim' => 'Anaheim',
	  'Andada' => 'Andada',
	  'Andika' => 'Andika',
	  'Angkor' => 'Angkor',
	  'Annie Use Your Telescope' => 'Annie Use Your Telescope',
	  'Anonymous Pro' => 'Anonymous Pro',
	  'Anonymous Pro:400italic' => 'Anonymous Pro  italic',
	  'Anonymous Pro:700' => 'Anonymous Pro bold (700) ',
	  'Anonymous Pro:700italic' => 'Anonymous Pro bold (700) italic',
	  'Antic' => 'Antic',
	  'Antic Didone' => 'Antic Didone',
	  'Antic Slab' => 'Antic Slab',
	  'Anton' => 'Anton',
	  'Arapey' => 'Arapey',
	  'Arapey:400italic' => 'Arapey  italic',
	  'Arbutus' => 'Arbutus',
	  'Arbutus Slab' => 'Arbutus Slab',
	  'Architects Daughter' => 'Architects Daughter',
	  'Archivo Black' => 'Archivo Black',
	  'Archivo Narrow' => 'Archivo Narrow',
	  'Archivo Narrow:400italic' => 'Archivo Narrow  italic',
	  'Archivo Narrow:700' => 'Archivo Narrow bold (700) ',
	  'Archivo Narrow:700italic' => 'Archivo Narrow bold (700) italic',
	  'Arimo' => 'Arimo',
	  'Arimo:400italic' => 'Arimo  italic',
	  'Arimo:700' => 'Arimo bold (700) ',
	  'Arimo:700italic' => 'Arimo bold (700) italic',
	  'Arizonia' => 'Arizonia',
	  'Armata' => 'Armata',
	  'Artifika' => 'Artifika',
	  'Arvo' => 'Arvo',
	  'Arvo:400italic' => 'Arvo  italic',
	  'Arvo:700' => 'Arvo bold (700) ',
	  'Arvo:700italic' => 'Arvo bold (700) italic',
	  'Asap' => 'Asap',
	  'Asap:400italic' => 'Asap  italic',
	  'Asap:700' => 'Asap bold (700) ',
	  'Asap:700italic' => 'Asap bold (700) italic',
	  'Asset' => 'Asset',
	  'Astloch' => 'Astloch',
	  'Astloch:700' => 'Astloch bold (700) ',
	  'Asul' => 'Asul',
	  'Asul:700' => 'Asul bold (700) ',
	  'Atomic Age' => 'Atomic Age',
	  'Aubrey' => 'Aubrey',
	  'Audiowide' => 'Audiowide',
	  'Autour One' => 'Autour One',
	  'Average' => 'Average',
	  'Average Sans' => 'Average Sans',
	  'Averia Gruesa Libre' => 'Averia Gruesa Libre',
	  'Averia Libre:300' => 'Averia Libre bold (300) ',
	  'Averia Libre:300italic' => 'Averia Libre bold (300) italic',
	  'Averia Libre' => 'Averia Libre',
	  'Averia Libre:400italic' => 'Averia Libre  italic',
	  'Averia Libre:700' => 'Averia Libre bold (700) ',
	  'Averia Libre:700italic' => 'Averia Libre bold (700) italic',
	  'Averia Sans Libre:300' => 'Averia Sans Libre bold (300) ',
	  'Averia Sans Libre:300italic' => 'Averia Sans Libre bold (300) italic',
	  'Averia Sans Libre' => 'Averia Sans Libre',
	  'Averia Sans Libre:400italic' => 'Averia Sans Libre  italic',
	  'Averia Sans Libre:700' => 'Averia Sans Libre bold (700) ',
	  'Averia Sans Libre:700italic' => 'Averia Sans Libre bold (700) italic',
	  'Averia Serif Libre:300' => 'Averia Serif Libre bold (300) ',
	  'Averia Serif Libre:300italic' => 'Averia Serif Libre bold (300) italic',
	  'Averia Serif Libre' => 'Averia Serif Libre',
	  'Averia Serif Libre:400italic' => 'Averia Serif Libre  italic',
	  'Averia Serif Libre:700' => 'Averia Serif Libre bold (700) ',
	  'Averia Serif Libre:700italic' => 'Averia Serif Libre bold (700) italic',
	  'Bad Script' => 'Bad Script',
	  'Balthazar' => 'Balthazar',
	  'Bangers' => 'Bangers',
	  'Basic' => 'Basic',
	  'Battambang' => 'Battambang',
	  'Battambang:700' => 'Battambang bold (700) ',
	  'Baumans' => 'Baumans',
	  'Bayon' => 'Bayon',
	  'Belgrano' => 'Belgrano',
	  'Belleza' => 'Belleza',
	  'BenchNine:300' => 'BenchNine bold (300) ',
	  'BenchNine' => 'BenchNine',
	  'BenchNine:700' => 'BenchNine bold (700) ',
	  'Bentham' => 'Bentham',
	  'Berkshire Swash' => 'Berkshire Swash',
	  'Bevan' => 'Bevan',
	  'Bigshot One' => 'Bigshot One',
	  'Bilbo' => 'Bilbo',
	  'Bilbo Swash Caps' => 'Bilbo Swash Caps',
	  'Bitter' => 'Bitter',
	  'Bitter:400italic' => 'Bitter  italic',
	  'Bitter:700' => 'Bitter bold (700) ',
	  'Black Ops One' => 'Black Ops One',
	  'Bokor' => 'Bokor',
	  'Bonbon' => 'Bonbon',
	  'Boogaloo' => 'Boogaloo',
	  'Bowlby One' => 'Bowlby One',
	  'Bowlby One SC' => 'Bowlby One SC',
	  'Brawler' => 'Brawler',
	  'Bree Serif' => 'Bree Serif',
	  'Bubblegum Sans' => 'Bubblegum Sans',
	  'Bubbler One' => 'Bubbler One',
	  'Buda:300' => 'Buda bold (300) ',
	  'Buenard' => 'Buenard',
	  'Buenard:700' => 'Buenard bold (700) ',
	  'Butcherman' => 'Butcherman',
	  'Butterfly Kids' => 'Butterfly Kids',
	  'Cabin' => 'Cabin',
	  'Cabin:400italic' => 'Cabin  italic',
	  'Cabin:500' => 'Cabin bold (500) ',
	  'Cabin:500italic' => 'Cabin bold (500) italic',
	  'Cabin:600' => 'Cabin bold (600) ',
	  'Cabin:600italic' => 'Cabin bold (600) italic',
	  'Cabin:700' => 'Cabin bold (700) ',
	  'Cabin:700italic' => 'Cabin bold (700) italic',
	  'Cabin Condensed' => 'Cabin Condensed',
	  'Cabin Condensed:500' => 'Cabin Condensed bold (500) ',
	  'Cabin Condensed:600' => 'Cabin Condensed bold (600) ',
	  'Cabin Condensed:700' => 'Cabin Condensed bold (700) ',
	  'Cabin Sketch' => 'Cabin Sketch',
	  'Cabin Sketch:700' => 'Cabin Sketch bold (700) ',
	  'Caesar Dressing' => 'Caesar Dressing',
	  'Cagliostro' => 'Cagliostro',
	  'Calligraffitti' => 'Calligraffitti',
	  'Cambo' => 'Cambo',
	  'Candal' => 'Candal',
	  'Cantarell' => 'Cantarell',
	  'Cantarell:400italic' => 'Cantarell  italic',
	  'Cantarell:700' => 'Cantarell bold (700) ',
	  'Cantarell:700italic' => 'Cantarell bold (700) italic',
	  'Cantata One' => 'Cantata One',
	  'Cantora One' => 'Cantora One',
	  'Capriola' => 'Capriola',
	  'Cardo' => 'Cardo',
	  'Cardo:400italic' => 'Cardo  italic',
	  'Cardo:700' => 'Cardo bold (700) ',
	  'Carme' => 'Carme',
	  'Carrois Gothic' => 'Carrois Gothic',
	  'Carrois Gothic SC' => 'Carrois Gothic SC',
	  'Carter One' => 'Carter One',
	  'Caudex' => 'Caudex',
	  'Caudex:400italic' => 'Caudex  italic',
	  'Caudex:700' => 'Caudex bold (700) ',
	  'Caudex:700italic' => 'Caudex bold (700) italic',
	  'Cedarville Cursive' => 'Cedarville Cursive',
	  'Ceviche One' => 'Ceviche One',
	  'Changa One' => 'Changa One',
	  'Changa One:400italic' => 'Changa One  italic',
	  'Chango' => 'Chango',
	  'Chau Philomene One' => 'Chau Philomene One',
	  'Chau Philomene One:400italic' => 'Chau Philomene One  italic',
	  'Chela One' => 'Chela One',
	  'Chelsea Market' => 'Chelsea Market',
	  'Chenla' => 'Chenla',
	  'Cherry Cream Soda' => 'Cherry Cream Soda',
	  'Cherry Swash' => 'Cherry Swash',
	  'Cherry Swash:700' => 'Cherry Swash bold (700) ',
	  'Chewy' => 'Chewy',
	  'Chicle' => 'Chicle',
	  'Chivo' => 'Chivo',
	  'Chivo:400italic' => 'Chivo  italic',
	  'Chivo:900' => 'Chivo bold (900) ',
	  'Chivo:900italic' => 'Chivo bold (900) italic',
	  'Cinzel' => 'Cinzel',
	  'Cinzel:700' => 'Cinzel bold (700) ',
	  'Cinzel:900' => 'Cinzel bold (900) ',
	  'Cinzel Decorative' => 'Cinzel Decorative',
	  'Cinzel Decorative:700' => 'Cinzel Decorative bold (700) ',
	  'Cinzel Decorative:900' => 'Cinzel Decorative bold (900) ',
	  'Coda' => 'Coda',
	  'Coda:800' => 'Coda bold (800) ',
	  'Coda Caption:800' => 'Coda Caption bold (800) ',
	  'Codystar:300' => 'Codystar bold (300) ',
	  'Codystar' => 'Codystar',
	  'Combo' => 'Combo',
	  'Comfortaa:300' => 'Comfortaa bold (300) ',
	  'Comfortaa' => 'Comfortaa',
	  'Comfortaa:700' => 'Comfortaa bold (700) ',
	  'Coming Soon' => 'Coming Soon',
	  'Concert One' => 'Concert One',
	  'Condiment' => 'Condiment',
	  'Content' => 'Content',
	  'Content:700' => 'Content bold (700) ',
	  'Contrail One' => 'Contrail One',
	  'Convergence' => 'Convergence',
	  'Cookie' => 'Cookie',
	  'Copse' => 'Copse',
	  'Corben' => 'Corben',
	  'Corben:700' => 'Corben bold (700) ',
	  'Courgette' => 'Courgette',
	  'Cousine' => 'Cousine',
	  'Cousine:400italic' => 'Cousine  italic',
	  'Cousine:700' => 'Cousine bold (700) ',
	  'Cousine:700italic' => 'Cousine bold (700) italic',
	  'Coustard' => 'Coustard',
	  'Coustard:900' => 'Coustard bold (900) ',
	  'Covered By Your Grace' => 'Covered By Your Grace',
	  'Crafty Girls' => 'Crafty Girls',
	  'Creepster' => 'Creepster',
	  'Crete Round' => 'Crete Round',
	  'Crete Round:400italic' => 'Crete Round  italic',
	  'Crimson Text' => 'Crimson Text',
	  'Crimson Text:400italic' => 'Crimson Text  italic',
	  'Crimson Text:600' => 'Crimson Text bold (600) ',
	  'Crimson Text:600italic' => 'Crimson Text bold (600) italic',
	  'Crimson Text:700' => 'Crimson Text bold (700) ',
	  'Crimson Text:700italic' => 'Crimson Text bold (700) italic',
	  'Crushed' => 'Crushed',
	  'Cuprum' => 'Cuprum',
	  'Cuprum:400italic' => 'Cuprum  italic',
	  'Cuprum:700' => 'Cuprum bold (700) ',
	  'Cuprum:700italic' => 'Cuprum bold (700) italic',
	  'Cutive' => 'Cutive',
	  'Cutive Mono' => 'Cutive Mono',
	  'Damion' => 'Damion',
	  'Dancing Script' => 'Dancing Script',
	  'Dancing Script:700' => 'Dancing Script bold (700) ',
	  'Dangrek' => 'Dangrek',
	  'Dawning of a New Day' => 'Dawning of a New Day',
	  'Days One' => 'Days One',
	  'Delius' => 'Delius',
	  'Delius Swash Caps' => 'Delius Swash Caps',
	  'Delius Unicase' => 'Delius Unicase',
	  'Delius Unicase:700' => 'Delius Unicase bold (700) ',
	  'Della Respira' => 'Della Respira',
	  'Devonshire' => 'Devonshire',
	  'Didact Gothic' => 'Didact Gothic',
	  'Diplomata' => 'Diplomata',
	  'Diplomata SC' => 'Diplomata SC',
	  'Doppio One' => 'Doppio One',
	  'Dorsa' => 'Dorsa',
	  'Dosis:200' => 'Dosis bold (200) ',
	  'Dosis:300' => 'Dosis bold (300) ',
	  'Dosis' => 'Dosis',
	  'Dosis:500' => 'Dosis bold (500) ',
	  'Dosis:600' => 'Dosis bold (600) ',
	  'Dosis:700' => 'Dosis bold (700) ',
	  'Dosis:800' => 'Dosis bold (800) ',
	  'Dr Sugiyama' => 'Dr Sugiyama',
	  'Droid Sans' => 'Droid Sans',
	  'Droid Sans:700' => 'Droid Sans bold (700) ',
	  'Droid Sans Mono' => 'Droid Sans Mono',
	  'Droid Serif' => 'Droid Serif',
	  'Droid Serif:400italic' => 'Droid Serif  italic',
	  'Droid Serif:700' => 'Droid Serif bold (700) ',
	  'Droid Serif:700italic' => 'Droid Serif bold (700) italic',
	  'Duru Sans' => 'Duru Sans',
	  'Dynalight' => 'Dynalight',
	  'EB Garamond' => 'EB Garamond',
	  'Eagle Lake' => 'Eagle Lake',
	  'Eater' => 'Eater',
	  'Economica' => 'Economica',
	  'Economica:400italic' => 'Economica  italic',
	  'Economica:700' => 'Economica bold (700) ',
	  'Economica:700italic' => 'Economica bold (700) italic',
	  'Electrolize' => 'Electrolize',
	  'Emblema One' => 'Emblema One',
	  'Emilys Candy' => 'Emilys Candy',
	  'Engagement' => 'Engagement',
	  'Enriqueta' => 'Enriqueta',
	  'Enriqueta:700' => 'Enriqueta bold (700) ',
	  'Erica One' => 'Erica One',
	  'Esteban' => 'Esteban',
	  'Euphoria Script' => 'Euphoria Script',
	  'Ewert' => 'Ewert',
	  'Exo:100' => 'Exo bold (100) ',
	  'Exo:100italic' => 'Exo bold (100) italic',
	  'Exo:200' => 'Exo bold (200) ',
	  'Exo:200italic' => 'Exo bold (200) italic',
	  'Exo:300' => 'Exo bold (300) ',
	  'Exo:300italic' => 'Exo bold (300) italic',
	  'Exo' => 'Exo',
	  'Exo:400italic' => 'Exo  italic',
	  'Exo:500' => 'Exo bold (500) ',
	  'Exo:500italic' => 'Exo bold (500) italic',
	  'Exo:600' => 'Exo bold (600) ',
	  'Exo:600italic' => 'Exo bold (600) italic',
	  'Exo:700' => 'Exo bold (700) ',
	  'Exo:700italic' => 'Exo bold (700) italic',
	  'Exo:800' => 'Exo bold (800) ',
	  'Exo:800italic' => 'Exo bold (800) italic',
	  'Exo:900' => 'Exo bold (900) ',
	  'Exo:900italic' => 'Exo bold (900) italic',
	  'Expletus Sans' => 'Expletus Sans',
	  'Expletus Sans:400italic' => 'Expletus Sans  italic',
	  'Expletus Sans:500' => 'Expletus Sans bold (500) ',
	  'Expletus Sans:500italic' => 'Expletus Sans bold (500) italic',
	  'Expletus Sans:600' => 'Expletus Sans bold (600) ',
	  'Expletus Sans:600italic' => 'Expletus Sans bold (600) italic',
	  'Expletus Sans:700' => 'Expletus Sans bold (700) ',
	  'Expletus Sans:700italic' => 'Expletus Sans bold (700) italic',
	  'Fanwood Text' => 'Fanwood Text',
	  'Fanwood Text:400italic' => 'Fanwood Text  italic',
	  'Fascinate' => 'Fascinate',
	  'Fascinate Inline' => 'Fascinate Inline',
	  'Faster One' => 'Faster One',
	  'Fasthand' => 'Fasthand',
	  'Federant' => 'Federant',
	  'Federo' => 'Federo',
	  'Felipa' => 'Felipa',
	  'Fenix' => 'Fenix',
	  'Finger Paint' => 'Finger Paint',
	  'Fjord One' => 'Fjord One',
	  'Flamenco:300' => 'Flamenco bold (300) ',
	  'Flamenco' => 'Flamenco',
	  'Flavors' => 'Flavors',
	  'Fondamento' => 'Fondamento',
	  'Fondamento:400italic' => 'Fondamento  italic',
	  'Fontdiner Swanky' => 'Fontdiner Swanky',
	  'Forum' => 'Forum',
	  'Francois One' => 'Francois One',
	  'Fredericka the Great' => 'Fredericka the Great',
	  'Fredoka One' => 'Fredoka One',
	  'Freehand' => 'Freehand',
	  'Fresca' => 'Fresca',
	  'Frijole' => 'Frijole',
	  'Fugaz One' => 'Fugaz One',
	  'GFS Didot' => 'GFS Didot',
	  'GFS Neohellenic' => 'GFS Neohellenic',
	  'GFS Neohellenic:400italic' => 'GFS Neohellenic  italic',
	  'GFS Neohellenic:700' => 'GFS Neohellenic bold (700) ',
	  'GFS Neohellenic:700italic' => 'GFS Neohellenic bold (700) italic',
	  'Galdeano' => 'Galdeano',
	  'Galindo' => 'Galindo',
	  'Gentium Basic' => 'Gentium Basic',
	  'Gentium Basic:400italic' => 'Gentium Basic  italic',
	  'Gentium Basic:700' => 'Gentium Basic bold (700) ',
	  'Gentium Basic:700italic' => 'Gentium Basic bold (700) italic',
	  'Gentium Book Basic' => 'Gentium Book Basic',
	  'Gentium Book Basic:400italic' => 'Gentium Book Basic  italic',
	  'Gentium Book Basic:700' => 'Gentium Book Basic bold (700) ',
	  'Gentium Book Basic:700italic' => 'Gentium Book Basic bold (700) italic',
	  'Geo' => 'Geo',
	  'Geo:400italic' => 'Geo  italic',
	  'Geostar' => 'Geostar',
	  'Geostar Fill' => 'Geostar Fill',
	  'Germania One' => 'Germania One',
	  'Give You Glory' => 'Give You Glory',
	  'Glass Antiqua' => 'Glass Antiqua',
	  'Glegoo' => 'Glegoo',
	  'Gloria Hallelujah' => 'Gloria Hallelujah',
	  'Goblin One' => 'Goblin One',
	  'Gochi Hand' => 'Gochi Hand',
	  'Gorditas' => 'Gorditas',
	  'Gorditas:700' => 'Gorditas bold (700) ',
	  'Goudy Bookletter 1911' => 'Goudy Bookletter 1911',
	  'Graduate' => 'Graduate',
	  'Gravitas One' => 'Gravitas One',
	  'Great Vibes' => 'Great Vibes',
	  'Griffy' => 'Griffy',
	  'Gruppo' => 'Gruppo',
	  'Gudea' => 'Gudea',
	  'Gudea:400italic' => 'Gudea  italic',
	  'Gudea:700' => 'Gudea bold (700) ',
	  'Habibi' => 'Habibi',
	  'Hammersmith One' => 'Hammersmith One',
	  'Handlee' => 'Handlee',
	  'Hanuman' => 'Hanuman',
	  'Hanuman:700' => 'Hanuman bold (700) ',
	  'Happy Monkey' => 'Happy Monkey',
	  'Headland One' => 'Headland One',
	  'Henny Penny' => 'Henny Penny',
	  'Herr Von Muellerhoff' => 'Herr Von Muellerhoff',
	  'Holtwood One SC' => 'Holtwood One SC',
	  'Homemade Apple' => 'Homemade Apple',
	  'Homenaje' => 'Homenaje',
	  'IM Fell DW Pica' => 'IM Fell DW Pica',
	  'IM Fell DW Pica:400italic' => 'IM Fell DW Pica  italic',
	  'IM Fell DW Pica SC' => 'IM Fell DW Pica SC',
	  'IM Fell Double Pica' => 'IM Fell Double Pica',
	  'IM Fell Double Pica:400italic' => 'IM Fell Double Pica  italic',
	  'IM Fell Double Pica SC' => 'IM Fell Double Pica SC',
	  'IM Fell English' => 'IM Fell English',
	  'IM Fell English:400italic' => 'IM Fell English  italic',
	  'IM Fell English SC' => 'IM Fell English SC',
	  'IM Fell French Canon' => 'IM Fell French Canon',
	  'IM Fell French Canon:400italic' => 'IM Fell French Canon  italic',
	  'IM Fell French Canon SC' => 'IM Fell French Canon SC',
	  'IM Fell Great Primer' => 'IM Fell Great Primer',
	  'IM Fell Great Primer:400italic' => 'IM Fell Great Primer  italic',
	  'IM Fell Great Primer SC' => 'IM Fell Great Primer SC',
	  'Iceberg' => 'Iceberg',
	  'Iceland' => 'Iceland',
	  'Imprima' => 'Imprima',
	  'Inconsolata' => 'Inconsolata',
	  'Inconsolata:700' => 'Inconsolata bold (700) ',
	  'Inder' => 'Inder',
	  'Indie Flower' => 'Indie Flower',
	  'Inika' => 'Inika',
	  'Inika:700' => 'Inika bold (700) ',
	  'Irish Grover' => 'Irish Grover',
	  'Istok Web' => 'Istok Web',
	  'Istok Web:400italic' => 'Istok Web  italic',
	  'Istok Web:700' => 'Istok Web bold (700) ',
	  'Istok Web:700italic' => 'Istok Web bold (700) italic',
	  'Italiana' => 'Italiana',
	  'Italianno' => 'Italianno',
	  'Jacques Francois' => 'Jacques Francois',
	  'Jacques Francois Shadow' => 'Jacques Francois Shadow',
	  'Jim Nightshade' => 'Jim Nightshade',
	  'Jockey One' => 'Jockey One',
	  'Jolly Lodger' => 'Jolly Lodger',
	  'Josefin Sans:100' => 'Josefin Sans bold (100) ',
	  'Josefin Sans:100italic' => 'Josefin Sans bold (100) italic',
	  'Josefin Sans:300' => 'Josefin Sans bold (300) ',
	  'Josefin Sans:300italic' => 'Josefin Sans bold (300) italic',
	  'Josefin Sans' => 'Josefin Sans',
	  'Josefin Sans:400italic' => 'Josefin Sans  italic',
	  'Josefin Sans:600' => 'Josefin Sans bold (600) ',
	  'Josefin Sans:600italic' => 'Josefin Sans bold (600) italic',
	  'Josefin Sans:700' => 'Josefin Sans bold (700) ',
	  'Josefin Sans:700italic' => 'Josefin Sans bold (700) italic',
	  'Josefin Slab:100' => 'Josefin Slab bold (100) ',
	  'Josefin Slab:100italic' => 'Josefin Slab bold (100) italic',
	  'Josefin Slab:300' => 'Josefin Slab bold (300) ',
	  'Josefin Slab:300italic' => 'Josefin Slab bold (300) italic',
	  'Josefin Slab' => 'Josefin Slab',
	  'Josefin Slab:400italic' => 'Josefin Slab  italic',
	  'Josefin Slab:600' => 'Josefin Slab bold (600) ',
	  'Josefin Slab:600italic' => 'Josefin Slab bold (600) italic',
	  'Josefin Slab:700' => 'Josefin Slab bold (700) ',
	  'Josefin Slab:700italic' => 'Josefin Slab bold (700) italic',
	  'Judson' => 'Judson',
	  'Judson:400italic' => 'Judson  italic',
	  'Judson:700' => 'Judson bold (700) ',
	  'Julee' => 'Julee',
	  'Julius Sans One' => 'Julius Sans One',
	  'Junge' => 'Junge',
	  'Jura:300' => 'Jura bold (300) ',
	  'Jura' => 'Jura',
	  'Jura:500' => 'Jura bold (500) ',
	  'Jura:600' => 'Jura bold (600) ',
	  'Just Another Hand' => 'Just Another Hand',
	  'Just Me Again Down Here' => 'Just Me Again Down Here',
	  'Kameron' => 'Kameron',
	  'Kameron:700' => 'Kameron bold (700) ',
	  'Karla' => 'Karla',
	  'Karla:400italic' => 'Karla  italic',
	  'Karla:700' => 'Karla bold (700) ',
	  'Karla:700italic' => 'Karla bold (700) italic',
	  'Kaushan Script' => 'Kaushan Script',
	  'Kelly Slab' => 'Kelly Slab',
	  'Kenia' => 'Kenia',
	  'Khmer' => 'Khmer',
	  'Kite One' => 'Kite One',
	  'Knewave' => 'Knewave',
	  'Kotta One' => 'Kotta One',
	  'Koulen' => 'Koulen',
	  'Kranky' => 'Kranky',
	  'Kreon:300' => 'Kreon bold (300) ',
	  'Kreon' => 'Kreon',
	  'Kreon:700' => 'Kreon bold (700) ',
	  'Kristi' => 'Kristi',
	  'Krona One' => 'Krona One',
	  'La Belle Aurore' => 'La Belle Aurore',
	  'Lancelot' => 'Lancelot',
	  'Lato:100' => 'Lato bold (100) ',
	  'Lato:100italic' => 'Lato bold (100) italic',
	  'Lato:300' => 'Lato bold (300) ',
	  'Lato:300italic' => 'Lato bold (300) italic',
	  'Lato' => 'Lato',
	  'Lato:400italic' => 'Lato  italic',
	  'Lato:700' => 'Lato bold (700) ',
	  'Lato:700italic' => 'Lato bold (700) italic',
	  'Lato:900' => 'Lato bold (900) ',
	  'Lato:900italic' => 'Lato bold (900) italic',
	  'League Script' => 'League Script',
	  'Leckerli One' => 'Leckerli One',
	  'Ledger' => 'Ledger',
	  'Lekton' => 'Lekton',
	  'Lekton:400italic' => 'Lekton  italic',
	  'Lekton:700' => 'Lekton bold (700) ',
	  'Lemon' => 'Lemon',
	  'Life Savers' => 'Life Savers',
	  'Lilita One' => 'Lilita One',
	  'Limelight' => 'Limelight',
	  'Linden Hill' => 'Linden Hill',
	  'Linden Hill:400italic' => 'Linden Hill  italic',
	  'Lobster' => 'Lobster',
	  'Lobster Two' => 'Lobster Two',
	  'Lobster Two:400italic' => 'Lobster Two  italic',
	  'Lobster Two:700' => 'Lobster Two bold (700) ',
	  'Lobster Two:700italic' => 'Lobster Two bold (700) italic',
	  'Londrina Outline' => 'Londrina Outline',
	  'Londrina Shadow' => 'Londrina Shadow',
	  'Londrina Sketch' => 'Londrina Sketch',
	  'Londrina Solid' => 'Londrina Solid',
	  'Lora' => 'Lora',
	  'Lora:400italic' => 'Lora  italic',
	  'Lora:700' => 'Lora bold (700) ',
	  'Lora:700italic' => 'Lora bold (700) italic',
	  'Love Ya Like A Sister' => 'Love Ya Like A Sister',
	  'Loved by the King' => 'Loved by the King',
	  'Lovers Quarrel' => 'Lovers Quarrel',
	  'Luckiest Guy' => 'Luckiest Guy',
	  'Lusitana' => 'Lusitana',
	  'Lusitana:700' => 'Lusitana bold (700) ',
	  'Lustria' => 'Lustria',
	  'Macondo' => 'Macondo',
	  'Macondo Swash Caps' => 'Macondo Swash Caps',
	  'Magra' => 'Magra',
	  'Magra:700' => 'Magra bold (700) ',
	  'Maiden Orange' => 'Maiden Orange',
	  'Mako' => 'Mako',
	  'Marcellus' => 'Marcellus',
	  'Marcellus SC' => 'Marcellus SC',
	  'Marck Script' => 'Marck Script',
	  'Marko One' => 'Marko One',
	  'Marmelad' => 'Marmelad',
	  'Marvel' => 'Marvel',
	  'Marvel:400italic' => 'Marvel  italic',
	  'Marvel:700' => 'Marvel bold (700) ',
	  'Marvel:700italic' => 'Marvel bold (700) italic',
	  'Mate' => 'Mate',
	  'Mate:400italic' => 'Mate  italic',
	  'Mate SC' => 'Mate SC',
	  'Maven Pro' => 'Maven Pro',
	  'Maven Pro:500' => 'Maven Pro bold (500) ',
	  'Maven Pro:700' => 'Maven Pro bold (700) ',
	  'Maven Pro:900' => 'Maven Pro bold (900) ',
	  'McLaren' => 'McLaren',
	  'Meddon' => 'Meddon',
	  'MedievalSharp' => 'MedievalSharp',
	  'Medula One' => 'Medula One',
	  'Megrim' => 'Megrim',
	  'Meie Script' => 'Meie Script',
	  'Merienda One' => 'Merienda One',
	  'Merriweather:300' => 'Merriweather bold (300) ',
	  'Merriweather' => 'Merriweather',
	  'Merriweather:700' => 'Merriweather bold (700) ',
	  'Merriweather:900' => 'Merriweather bold (900) ',
	  'Metal' => 'Metal',
	  'Metal Mania' => 'Metal Mania',
	  'Metamorphous' => 'Metamorphous',
	  'Metrophobic' => 'Metrophobic',
	  'Michroma' => 'Michroma',
	  'Miltonian' => 'Miltonian',
	  'Miltonian Tattoo' => 'Miltonian Tattoo',
	  'Miniver' => 'Miniver',
	  'Miss Fajardose' => 'Miss Fajardose',
	  'Modern Antiqua' => 'Modern Antiqua',
	  'Molengo' => 'Molengo',
	  'Molle:400italic' => 'Molle  italic',
	  'Monofett' => 'Monofett',
	  'Monoton' => 'Monoton',
	  'Monsieur La Doulaise' => 'Monsieur La Doulaise',
	  'Montaga' => 'Montaga',
	  'Montez' => 'Montez',
	  'Montserrat' => 'Montserrat',
	  'Montserrat:700' => 'Montserrat bold (700) ',
	  'Montserrat Alternates' => 'Montserrat Alternates',
	  'Montserrat Alternates:700' => 'Montserrat Alternates bold (700) ',
	  'Montserrat Subrayada' => 'Montserrat Subrayada',
	  'Montserrat Subrayada:700' => 'Montserrat Subrayada bold (700) ',
	  'Moul' => 'Moul',
	  'Moulpali' => 'Moulpali',
	  'Mountains of Christmas' => 'Mountains of Christmas',
	  'Mountains of Christmas:700' => 'Mountains of Christmas bold (700) ',
	  'Mr Bedfort' => 'Mr Bedfort',
	  'Mr Dafoe' => 'Mr Dafoe',
	  'Mr De Haviland' => 'Mr De Haviland',
	  'Mrs Saint Delafield' => 'Mrs Saint Delafield',
	  'Mrs Sheppards' => 'Mrs Sheppards',
	  'Muli:300' => 'Muli bold (300) ',
	  'Muli:300italic' => 'Muli bold (300) italic',
	  'Muli' => 'Muli',
	  'Muli:400italic' => 'Muli  italic',
	  'Mystery Quest' => 'Mystery Quest',
	  'Neucha' => 'Neucha',
	  'Neuton:200' => 'Neuton bold (200) ',
	  'Neuton:300' => 'Neuton bold (300) ',
	  'Neuton' => 'Neuton',
	  'Neuton:400italic' => 'Neuton  italic',
	  'Neuton:700' => 'Neuton bold (700) ',
	  'Neuton:800' => 'Neuton bold (800) ',
	  'News Cycle' => 'News Cycle',
	  'News Cycle:700' => 'News Cycle bold (700) ',
	  'Niconne' => 'Niconne',
	  'Nixie One' => 'Nixie One',
	  'Nobile' => 'Nobile',
	  'Nobile:400italic' => 'Nobile  italic',
	  'Nobile:700' => 'Nobile bold (700) ',
	  'Nobile:700italic' => 'Nobile bold (700) italic',
	  'Nokora' => 'Nokora',
	  'Nokora:700' => 'Nokora bold (700) ',
	  'Norican' => 'Norican',
	  'Nosifer' => 'Nosifer',
	  'Nothing You Could Do' => 'Nothing You Could Do',
	  'Noticia Text' => 'Noticia Text',
	  'Noticia Text:400italic' => 'Noticia Text  italic',
	  'Noticia Text:700' => 'Noticia Text bold (700) ',
	  'Noticia Text:700italic' => 'Noticia Text bold (700) italic',
	  'Nova Cut' => 'Nova Cut',
	  'Nova Flat' => 'Nova Flat',
	  'Nova Mono' => 'Nova Mono',
	  'Nova Oval' => 'Nova Oval',
	  'Nova Round' => 'Nova Round',
	  'Nova Script' => 'Nova Script',
	  'Nova Slim' => 'Nova Slim',
	  'Nova Square' => 'Nova Square',
	  'Numans' => 'Numans',
	  'Nunito:300' => 'Nunito bold (300) ',
	  'Nunito' => 'Nunito',
	  'Nunito:700' => 'Nunito bold (700) ',
	  'Odor Mean Chey' => 'Odor Mean Chey',
	  'Offside' => 'Offside',
	  'Old Standard TT' => 'Old Standard TT',
	  'Old Standard TT:400italic' => 'Old Standard TT  italic',
	  'Old Standard TT:700' => 'Old Standard TT bold (700) ',
	  'Oldenburg' => 'Oldenburg',
	  'Oleo Script' => 'Oleo Script',
	  'Oleo Script:700' => 'Oleo Script bold (700) ',
	  'Open Sans:300' => 'Open Sans bold (300) ',
	  'Open Sans:300italic' => 'Open Sans bold (300) italic',
	  'Open Sans' => 'Open Sans',
	  'Open Sans:400italic' => 'Open Sans  italic',
	  'Open Sans:600' => 'Open Sans bold (600) ',
	  'Open Sans:600italic' => 'Open Sans bold (600) italic',
	  'Open Sans:700' => 'Open Sans bold (700) ',
	  'Open Sans:700italic' => 'Open Sans bold (700) italic',
	  'Open Sans:800' => 'Open Sans bold (800) ',
	  'Open Sans:800italic' => 'Open Sans bold (800) italic',
	  'Open Sans Condensed:300' => 'Open Sans Condensed bold (300) ',
	  'Open Sans Condensed:300italic' => 'Open Sans Condensed bold (300) italic',
	  'Open Sans Condensed:700' => 'Open Sans Condensed bold (700) ',
	  'Oranienbaum' => 'Oranienbaum',
	  'Orbitron' => 'Orbitron',
	  'Orbitron:500' => 'Orbitron bold (500) ',
	  'Orbitron:700' => 'Orbitron bold (700) ',
	  'Orbitron:900' => 'Orbitron bold (900) ',
	  'Oregano' => 'Oregano',
	  'Oregano:400italic' => 'Oregano  italic',
	  'Orienta' => 'Orienta',
	  'Original Surfer' => 'Original Surfer',
	  'Oswald:300' => 'Oswald bold (300) ',
	  'Oswald' => 'Oswald',
	  'Oswald:700' => 'Oswald bold (700) ',
	  'Over the Rainbow' => 'Over the Rainbow',
	  'Overlock' => 'Overlock',
	  'Overlock:400italic' => 'Overlock  italic',
	  'Overlock:700' => 'Overlock bold (700) ',
	  'Overlock:700italic' => 'Overlock bold (700) italic',
	  'Overlock:900' => 'Overlock bold (900) ',
	  'Overlock:900italic' => 'Overlock bold (900) italic',
	  'Overlock SC' => 'Overlock SC',
	  'Ovo' => 'Ovo',
	  'Oxygen:300' => 'Oxygen bold (300) ',
	  'Oxygen' => 'Oxygen',
	  'Oxygen:700' => 'Oxygen bold (700) ',
	  'Oxygen Mono' => 'Oxygen Mono',
	  'PT Mono' => 'PT Mono',
	  'PT Sans' => 'PT Sans',
	  'PT Sans:400italic' => 'PT Sans  italic',
	  'PT Sans:700' => 'PT Sans bold (700) ',
	  'PT Sans:700italic' => 'PT Sans bold (700) italic',
	  'PT Sans Caption' => 'PT Sans Caption',
	  'PT Sans Caption:700' => 'PT Sans Caption bold (700) ',
	  'PT Sans Narrow' => 'PT Sans Narrow',
	  'PT Sans Narrow:700' => 'PT Sans Narrow bold (700) ',
	  'PT Serif' => 'PT Serif',
	  'PT Serif:400italic' => 'PT Serif  italic',
	  'PT Serif:700' => 'PT Serif bold (700) ',
	  'PT Serif:700italic' => 'PT Serif bold (700) italic',
	  'PT Serif Caption' => 'PT Serif Caption',
	  'PT Serif Caption:400italic' => 'PT Serif Caption  italic',
	  'Pacifico' => 'Pacifico',
	  'Paprika' => 'Paprika',
	  'Parisienne' => 'Parisienne',
	  'Passero One' => 'Passero One',
	  'Passion One' => 'Passion One',
	  'Passion One:700' => 'Passion One bold (700) ',
	  'Passion One:900' => 'Passion One bold (900) ',
	  'Patrick Hand' => 'Patrick Hand',
	  'Patua One' => 'Patua One',
	  'Paytone One' => 'Paytone One',
	  'Peralta' => 'Peralta',
	  'Permanent Marker' => 'Permanent Marker',
	  'Petit Formal Script' => 'Petit Formal Script',
	  'Petrona' => 'Petrona',
	  'Philosopher' => 'Philosopher',
	  'Philosopher:400italic' => 'Philosopher  italic',
	  'Philosopher:700' => 'Philosopher bold (700) ',
	  'Philosopher:700italic' => 'Philosopher bold (700) italic',
	  'Piedra' => 'Piedra',
	  'Pinyon Script' => 'Pinyon Script',
	  'Plaster' => 'Plaster',
	  'Play' => 'Play',
	  'Play:700' => 'Play bold (700) ',
	  'Playball' => 'Playball',
	  'Playfair Display' => 'Playfair Display',
	  'Playfair Display:400italic' => 'Playfair Display  italic',
	  'Playfair Display:700' => 'Playfair Display bold (700) ',
	  'Playfair Display:700italic' => 'Playfair Display bold (700) italic',
	  'Playfair Display:900' => 'Playfair Display bold (900) ',
	  'Playfair Display:900italic' => 'Playfair Display bold (900) italic',
	  'Playfair Display SC' => 'Playfair Display SC',
	  'Playfair Display SC:400italic' => 'Playfair Display SC  italic',
	  'Playfair Display SC:700' => 'Playfair Display SC bold (700) ',
	  'Playfair Display SC:700italic' => 'Playfair Display SC bold (700) italic',
	  'Playfair Display SC:900' => 'Playfair Display SC bold (900) ',
	  'Playfair Display SC:900italic' => 'Playfair Display SC bold (900) italic',
	  'Podkova' => 'Podkova',
	  'Podkova:700' => 'Podkova bold (700) ',
	  'Poiret One' => 'Poiret One',
	  'Poller One' => 'Poller One',
	  'Poly' => 'Poly',
	  'Poly:400italic' => 'Poly  italic',
	  'Pompiere' => 'Pompiere',
	  'Pontano Sans' => 'Pontano Sans',
	  'Port Lligat Sans' => 'Port Lligat Sans',
	  'Port Lligat Slab' => 'Port Lligat Slab',
	  'Prata' => 'Prata',
	  'Preahvihear' => 'Preahvihear',
	  'Press Start 2P' => 'Press Start 2P',
	  'Princess Sofia' => 'Princess Sofia',
	  'Prociono' => 'Prociono',
	  'Prosto One' => 'Prosto One',
	  'Puritan' => 'Puritan',
	  'Puritan:400italic' => 'Puritan  italic',
	  'Puritan:700' => 'Puritan bold (700) ',
	  'Puritan:700italic' => 'Puritan bold (700) italic',
	  'Quando' => 'Quando',
	  'Quantico' => 'Quantico',
	  'Quantico:400italic' => 'Quantico  italic',
	  'Quantico:700' => 'Quantico bold (700) ',
	  'Quantico:700italic' => 'Quantico bold (700) italic',
	  'Quattrocento' => 'Quattrocento',
	  'Quattrocento:700' => 'Quattrocento bold (700) ',
	  'Quattrocento Sans' => 'Quattrocento Sans',
	  'Quattrocento Sans:400italic' => 'Quattrocento Sans  italic',
	  'Quattrocento Sans:700' => 'Quattrocento Sans bold (700) ',
	  'Quattrocento Sans:700italic' => 'Quattrocento Sans bold (700) italic',
	  'Questrial' => 'Questrial',
	  'Quicksand:300' => 'Quicksand bold (300) ',
	  'Quicksand' => 'Quicksand',
	  'Quicksand:700' => 'Quicksand bold (700) ',
	  'Qwigley' => 'Qwigley',
	  'Racing Sans One' => 'Racing Sans One',
	  'Radley' => 'Radley',
	  'Radley:400italic' => 'Radley  italic',
	  'Raleway:100' => 'Raleway bold (100) ',
	  'Raleway:200' => 'Raleway bold (200) ',
	  'Raleway:300' => 'Raleway bold (300) ',
	  'Raleway' => 'Raleway',
	  'Raleway:500' => 'Raleway bold (500) ',
	  'Raleway:600' => 'Raleway bold (600) ',
	  'Raleway:700' => 'Raleway bold (700) ',
	  'Raleway:800' => 'Raleway bold (800) ',
	  'Raleway:900' => 'Raleway bold (900) ',
	  'Raleway Dots' => 'Raleway Dots',
	  'Rammetto One' => 'Rammetto One',
	  'Ranchers' => 'Ranchers',
	  'Rancho' => 'Rancho',
	  'Rationale' => 'Rationale',
	  'Redressed' => 'Redressed',
	  'Reenie Beanie' => 'Reenie Beanie',
	  'Revalia' => 'Revalia',
	  'Ribeye' => 'Ribeye',
	  'Ribeye Marrow' => 'Ribeye Marrow',
	  'Righteous' => 'Righteous',
	  'Rochester' => 'Rochester',
	  'Rock Salt' => 'Rock Salt',
	  'Rokkitt' => 'Rokkitt',
	  'Rokkitt:700' => 'Rokkitt bold (700) ',
	  'Romanesco' => 'Romanesco',
	  'Ropa Sans' => 'Ropa Sans',
	  'Ropa Sans:400italic' => 'Ropa Sans  italic',
	  'Rosario' => 'Rosario',
	  'Rosario:400italic' => 'Rosario  italic',
	  'Rosario:700' => 'Rosario bold (700) ',
	  'Rosario:700italic' => 'Rosario bold (700) italic',
	  'Rosarivo' => 'Rosarivo',
	  'Rosarivo:400italic' => 'Rosarivo  italic',
	  'Rouge Script' => 'Rouge Script',
	  'Ruda' => 'Ruda',
	  'Ruda:700' => 'Ruda bold (700) ',
	  'Ruda:900' => 'Ruda bold (900) ',
	  'Ruge Boogie' => 'Ruge Boogie',
	  'Ruluko' => 'Ruluko',
	  'Ruslan Display' => 'Ruslan Display',
	  'Russo One' => 'Russo One',
	  'Ruthie' => 'Ruthie',
	  'Rye' => 'Rye',
	  'Sail' => 'Sail',
	  'Salsa' => 'Salsa',
	  'Sanchez' => 'Sanchez',
	  'Sanchez:400italic' => 'Sanchez  italic',
	  'Sancreek' => 'Sancreek',
	  'Sansita One' => 'Sansita One',
	  'Sarina' => 'Sarina',
	  'Satisfy' => 'Satisfy',
	  'Scada' => 'Scada',
	  'Scada:400italic' => 'Scada  italic',
	  'Scada:700' => 'Scada bold (700) ',
	  'Scada:700italic' => 'Scada bold (700) italic',
	  'Schoolbell' => 'Schoolbell',
	  'Seaweed Script' => 'Seaweed Script',
	  'Sevillana' => 'Sevillana',
	  'Seymour One' => 'Seymour One',
	  'Shadows Into Light' => 'Shadows Into Light',
	  'Shadows Into Light Two' => 'Shadows Into Light Two',
	  'Shanti' => 'Shanti',
	  'Share' => 'Share',
	  'Share:400italic' => 'Share  italic',
	  'Share:700' => 'Share bold (700) ',
	  'Share:700italic' => 'Share bold (700) italic',
	  'Share Tech' => 'Share Tech',
	  'Share Tech Mono' => 'Share Tech Mono',
	  'Shojumaru' => 'Shojumaru',
	  'Short Stack' => 'Short Stack',
	  'Siemreap' => 'Siemreap',
	  'Sigmar One' => 'Sigmar One',
	  'Signika:300' => 'Signika bold (300) ',
	  'Signika' => 'Signika',
	  'Signika:600' => 'Signika bold (600) ',
	  'Signika:700' => 'Signika bold (700) ',
	  'Signika Negative:300' => 'Signika Negative bold (300) ',
	  'Signika Negative' => 'Signika Negative',
	  'Signika Negative:600' => 'Signika Negative bold (600) ',
	  'Signika Negative:700' => 'Signika Negative bold (700) ',
	  'Simonetta' => 'Simonetta',
	  'Simonetta:400italic' => 'Simonetta  italic',
	  'Simonetta:900' => 'Simonetta bold (900) ',
	  'Simonetta:900italic' => 'Simonetta bold (900) italic',
	  'Sirin Stencil' => 'Sirin Stencil',
	  'Six Caps' => 'Six Caps',
	  'Skranji' => 'Skranji',
	  'Skranji:700' => 'Skranji bold (700) ',
	  'Slackey' => 'Slackey',
	  'Smokum' => 'Smokum',
	  'Smythe' => 'Smythe',
	  'Sniglet:800' => 'Sniglet bold (800) ',
	  'Snippet' => 'Snippet',
	  'Sofadi One' => 'Sofadi One',
	  'Sofia' => 'Sofia',
	  'Sonsie One' => 'Sonsie One',
	  'Sorts Mill Goudy' => 'Sorts Mill Goudy',
	  'Sorts Mill Goudy:400italic' => 'Sorts Mill Goudy  italic',
	  'Source Code Pro:200' => 'Source Code Pro bold (200) ',
	  'Source Code Pro:300' => 'Source Code Pro bold (300) ',
	  'Source Code Pro' => 'Source Code Pro',
	  'Source Code Pro:600' => 'Source Code Pro bold (600) ',
	  'Source Code Pro:700' => 'Source Code Pro bold (700) ',
	  'Source Code Pro:900' => 'Source Code Pro bold (900) ',
	  'Source Sans Pro:200' => 'Source Sans Pro bold (200) ',
	  'Source Sans Pro:200italic' => 'Source Sans Pro bold (200) italic',
	  'Source Sans Pro:300' => 'Source Sans Pro bold (300) ',
	  'Source Sans Pro:300italic' => 'Source Sans Pro bold (300) italic',
	  'Source Sans Pro' => 'Source Sans Pro',
	  'Source Sans Pro:400italic' => 'Source Sans Pro  italic',
	  'Source Sans Pro:600' => 'Source Sans Pro bold (600) ',
	  'Source Sans Pro:600italic' => 'Source Sans Pro bold (600) italic',
	  'Source Sans Pro:700' => 'Source Sans Pro bold (700) ',
	  'Source Sans Pro:700italic' => 'Source Sans Pro bold (700) italic',
	  'Source Sans Pro:900' => 'Source Sans Pro bold (900) ',
	  'Source Sans Pro:900italic' => 'Source Sans Pro bold (900) italic',
	  'Special Elite' => 'Special Elite',
	  'Spicy Rice' => 'Spicy Rice',
	  'Spinnaker' => 'Spinnaker',
	  'Spirax' => 'Spirax',
	  'Squada One' => 'Squada One',
	  'Stalinist One' => 'Stalinist One',
	  'Stardos Stencil' => 'Stardos Stencil',
	  'Stardos Stencil:700' => 'Stardos Stencil bold (700) ',
	  'Stint Ultra Condensed' => 'Stint Ultra Condensed',
	  'Stint Ultra Expanded' => 'Stint Ultra Expanded',
	  'Stoke:300' => 'Stoke bold (300) ',
	  'Stoke' => 'Stoke',
	  'Strait' => 'Strait',
	  'Sue Ellen Francisco' => 'Sue Ellen Francisco',
	  'Sunshiney' => 'Sunshiney',
	  'Supermercado One' => 'Supermercado One',
	  'Suwannaphum' => 'Suwannaphum',
	  'Swanky and Moo Moo' => 'Swanky and Moo Moo',
	  'Syncopate' => 'Syncopate',
	  'Syncopate:700' => 'Syncopate bold (700) ',
	  'Tangerine' => 'Tangerine',
	  'Tangerine:700' => 'Tangerine bold (700) ',
	  'Taprom' => 'Taprom',
	  'Telex' => 'Telex',
	  'Tenor Sans' => 'Tenor Sans',
	  'The Girl Next Door' => 'The Girl Next Door',
	  'Tienne' => 'Tienne',
	  'Tienne:700' => 'Tienne bold (700) ',
	  'Tienne:900' => 'Tienne bold (900) ',
	  'Tinos' => 'Tinos',
	  'Tinos:400italic' => 'Tinos  italic',
	  'Tinos:700' => 'Tinos bold (700) ',
	  'Tinos:700italic' => 'Tinos bold (700) italic',
	  'Titan One' => 'Titan One',
	  'Titillium Web:200' => 'Titillium Web bold (200) ',
	  'Titillium Web:200italic' => 'Titillium Web bold (200) italic',
	  'Titillium Web:300' => 'Titillium Web bold (300) ',
	  'Titillium Web:300italic' => 'Titillium Web bold (300) italic',
	  'Titillium Web' => 'Titillium Web',
	  'Titillium Web:400italic' => 'Titillium Web  italic',
	  'Titillium Web:600' => 'Titillium Web bold (600) ',
	  'Titillium Web:600italic' => 'Titillium Web bold (600) italic',
	  'Titillium Web:700' => 'Titillium Web bold (700) ',
	  'Titillium Web:700italic' => 'Titillium Web bold (700) italic',
	  'Titillium Web:900' => 'Titillium Web bold (900) ',
	  'Trade Winds' => 'Trade Winds',
	  'Trocchi' => 'Trocchi',
	  'Trochut' => 'Trochut',
	  'Trochut:400italic' => 'Trochut  italic',
	  'Trochut:700' => 'Trochut bold (700) ',
	  'Trykker' => 'Trykker',
	  'Tulpen One' => 'Tulpen One',
	  'Ubuntu:300' => 'Ubuntu bold (300) ',
	  'Ubuntu:300italic' => 'Ubuntu bold (300) italic',
	  'Ubuntu' => 'Ubuntu',
	  'Ubuntu:400italic' => 'Ubuntu  italic',
	  'Ubuntu:500' => 'Ubuntu bold (500) ',
	  'Ubuntu:500italic' => 'Ubuntu bold (500) italic',
	  'Ubuntu:700' => 'Ubuntu bold (700) ',
	  'Ubuntu:700italic' => 'Ubuntu bold (700) italic',
	  'Ubuntu Condensed' => 'Ubuntu Condensed',
	  'Ubuntu Mono' => 'Ubuntu Mono',
	  'Ubuntu Mono:400italic' => 'Ubuntu Mono  italic',
	  'Ubuntu Mono:700' => 'Ubuntu Mono bold (700) ',
	  'Ubuntu Mono:700italic' => 'Ubuntu Mono bold (700) italic',
	  'Ultra' => 'Ultra',
	  'Uncial Antiqua' => 'Uncial Antiqua',
	  'Underdog' => 'Underdog',
	  'Unica One' => 'Unica One',
	  'UnifrakturCook:700' => 'UnifrakturCook bold (700) ',
	  'UnifrakturMaguntia' => 'UnifrakturMaguntia',
	  'Unkempt' => 'Unkempt',
	  'Unkempt:700' => 'Unkempt bold (700) ',
	  'Unlock' => 'Unlock',
	  'Unna' => 'Unna',
	  'VT323' => 'VT323',
	  'Varela' => 'Varela',
	  'Varela Round' => 'Varela Round',
	  'Vast Shadow' => 'Vast Shadow',
	  'Vibur' => 'Vibur',
	  'Vidaloka' => 'Vidaloka',
	  'Viga' => 'Viga',
	  'Voces' => 'Voces',
	  'Volkhov' => 'Volkhov',
	  'Volkhov:400italic' => 'Volkhov  italic',
	  'Volkhov:700' => 'Volkhov bold (700) ',
	  'Volkhov:700italic' => 'Volkhov bold (700) italic',
	  'Vollkorn' => 'Vollkorn',
	  'Vollkorn:400italic' => 'Vollkorn  italic',
	  'Vollkorn:700' => 'Vollkorn bold (700) ',
	  'Vollkorn:700italic' => 'Vollkorn bold (700) italic',
	  'Voltaire' => 'Voltaire',
	  'Waiting for the Sunrise' => 'Waiting for the Sunrise',
	  'Wallpoet' => 'Wallpoet',
	  'Walter Turncoat' => 'Walter Turncoat',
	  'Warnes' => 'Warnes',
	  'Wellfleet' => 'Wellfleet',
	  'Wire One' => 'Wire One',
	  'Yanone Kaffeesatz:200' => 'Yanone Kaffeesatz bold (200) ',
	  'Yanone Kaffeesatz:300' => 'Yanone Kaffeesatz bold (300) ',
	  'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
	  'Yanone Kaffeesatz:700' => 'Yanone Kaffeesatz bold (700) ',
	  'Yellowtail' => 'Yellowtail',
	  'Yeseva One' => 'Yeseva One',
	  'Yesteryear' => 'Yesteryear',
	  'Zeyada' => 'Zeyada',
	);
	$default_lst = apply_filters( 'dt_get_google_fonts_list_defaults', $default_lst );
	
	if ( $get_defaults ) { return $default_lst; }

	$errors = array();
	$fonts_lst = array();
	if ( false === ( $fonts_lst = get_transient( 'dt_admin_fonts_list' ) ) ) {
		$fonts_lst_json = wp_remote_fopen( 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyCtxwnjsDlqzoL9C9EsCG-NyR2HPMOfd08' );//&key=AIzaSyCtxwnjsDlqzoL9C9EsCG-NyR2HPMOfd08
		$json_decode_exists = function_exists( 'json_decode' );
		if ( $fonts_lst_json && $json_decode_exists ) {

			$fonts_lst_array = json_decode( $fonts_lst_json, true );
			
			if ( isset( $fonts_lst_array['items'] ) && is_array( $fonts_lst_array['items'] ) ) {
				foreach ( $fonts_lst_array['items'] as $font ) {
					$subsets = $variants = array();

					if ( isset( $font['variants'] ) ) {
						foreach( $font['variants'] as $v ) {
							if ( 'regular' == $v ) { $fonts_lst[ $font['family'] ] = $font['family']; continue; }

							$vars = explode( 'italic', $v );
							$bold = ! empty( $vars[0] ) ? 'bold (' . $vars[0] . ')' : '';
							$italic = isset( $vars[1] ) ? 'italic' : '';

							if ( $italic && ! $bold ) { $v = '400' . $v; }
							$variants[ $v ] = $bold . ' ' . $italic;

							$fonts_lst[ $font['family'] . ':' . $v ] = $font['family'] . ' ' . $variants[ $v ];
						}
					}

					if ( isset( $font['subsets'] ) && count( $font['subsets'] ) > 1 ) {
						foreach ( $font['subsets'] as $s ) {
							if ( 'latin' == $s ) { continue; }
							$fonts_lst[ $font['family'] . '&subset=' . $s ] = $font['family'] . ' ' . $s;
							$subsets[] = $s;
						}
					}

					foreach ( $variants as $v=>$str ) {
						foreach ( $subsets as $s ) {
							$fonts_lst[ $font['family']. ':'. $v. '&subset='. $s ] = $font['family'] . ' ' . $str . ' ' . $s;
						}
					}
				}
				delete_transient( 'dt_admin_fonts_list_errors' );
			} else {
				$errors['no_items'] = array( 'info' => _x( 'Fonts list is empty.', 'backend', LANGUAGE_ZONE ), 'respond_array' => $fonts_lst_array, 'respond_json' => $fonts_lst_json );
			}
		} else {
			$info = _x( 'No respond.', 'backend', LANGUAGE_ZONE );
			$info .= ' Json_decode : ' . ( $json_decode_exists ? 'excists' : 'none' ) . '.';
			$errors['empty_json'] = array( 'info' => $info );
		}

		$life_time = 604800; // week
		if ( empty( $fonts_lst ) ) {
			$fonts_lst = $default_lst;
			$life_time = 86400; // day
			
			$errors['fallback'] = array( 'info' => _x( 'Fallback to default fonts list (you can change it with <strong>dt_get_google_fonts_list_defaults</strong> filter).', 'backend', LANGUAGE_ZONE ) );
		}
		
		if ( $errors ) {
			// store some errors
			set_transient( 'dt_admin_fonts_list_errors', $errors, 86400 );
		}

		set_transient( 'dt_admin_fonts_list', $fonts_lst, $life_time );
	}
	return $fonts_lst;
}

/* Pocess web fonts errors */
function dt_get_google_fonts_errors () {
	$output = '<div class="dt-web-fonts-error-block">';
	
	$errors = get_transient( 'dt_admin_fonts_list_errors' );
	if ( is_array( $errors ) ) {
		foreach ( $errors as $error_id=>$error_body ) {
			
			if ( isset( $error_body['info'] ) ) {
				$output .= '<span class="dt-web-fonts-error-message">' . wp_kses( $error_body['info'], array( 'strong' => array() ) ) . '</span><br />';
			}
/*			
			if ( isset( $error_body['respond_array'] ) ) {
				$output .= '<code class="dt-web-fonts-error-code">';
				$output .= var_export( $error_body['respond_array'], true );
				$output .= '</code>';
			}
*/
		}
	}
	
	$output .= '</div>';
	
	return $output;
}

// get images for options framework
function dt_get_images_in( $dir = '', $one_img_dir = '' ) {
//    $noimage = get_stylesheet_directory_uri(). '/images/noimage_small.jpg';
    $noimage = '/images/noimage_small.jpg';
    $basedir = dirname(__FILE__). '/../../../';
    $dirname = $basedir .$dir;
    $res = $full_dir = $thumbs_dir = array();
    $res['none'] = $noimage;
    
    // full dir
    if ( file_exists($dirname. '/full') && $handle = opendir( $dirname. '/full') ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != 'Thumb.db' && $file != 'Thumbs.db' && $file !='.DS_Store' && preg_match('/[.jpeg|.jpg|.png|.gif]$/', $file)) {
                $f_name = preg_split( '/\.[^.]+$/', $file );
                $full_dir[$f_name[0]] = $file;
            }
        }
        closedir($handle);
    }
    unset($file);
    
    // thumbs dir
    if ( file_exists($dirname. '/thumbs') && $handle = opendir( $dirname. '/thumbs') ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != 'Thumb.db' && $file != 'Thumbs.db') {
                $f_name = preg_split( '/\.[^.]+$/', $file );
                $thumbs_dir[$f_name[0]] = $file;
            }
        }
        closedir($handle);
    }
    unset($file);
    asort($full_dir);
    
    foreach( $full_dir as $name=>$file ) {
        $full_link = '/' . $dir . '/full/' . $file;
        if( array_key_exists( $name, $thumbs_dir ) ){
            $thumb_link = '/' . $dir . '/thumbs/' . $thumbs_dir[$name];
        }else {
            $one_img = explode('_', $name);
            if( $one_img[0] != $name && $one_img_dir && file_exists($basedir.$one_img_dir.'/'.$one_img[0].'.png') )
                $thumb_link = '/'.$one_img_dir.'/'.$one_img[0].'.png';

            if( $one_img[0] != $name && $one_img_dir && file_exists($basedir.$one_img_dir.'/'.$one_img[0].'.jpg') )
                $thumb_link = '/'.$one_img_dir.'/'.$one_img[0].'.jpg';

            if( !isset($thumb_link) ) {
                $thumb_meta = dt_get_resized_img( array( get_template_directory_uri().$full_link, 1000, 1000 ), array( 'w' => 119, 'h' => 119, 'z' => 3 ) );
                $thumb_link = str_replace( get_template_directory_uri(), '', $thumb_meta[0] );
            }
        }

        $res[$full_link] = $thumb_link;
    }
    
    return $res;
}

/* find option pages in array */
function optionsframework_options_page_filter( $item ) {
    if( isset($item['type']) && 'page' == $item['type'] ) {
        return true;
    }
    return false;
}

/* find options for current page */
function optionsframework_options_for_page_filter( $item ) {
    static $bingo = false;
    static $found_main = false;

    if( !isset($_GET['page']) ) {
        if( !isset($_POST['_wp_http_referer']) ) {
            return true;
        }else {
            $arr = array();
            wp_parse_str($_POST['_wp_http_referer'], $arr);
            $current = current($arr);
        }
    }else {
        $current = $_GET['page'];
    }

    if( 'options-framework' == $current && !$found_main ) {
        $bingo = true;
        $found_main = true;
    }

    if( isset($item['type']) && 'page' == $item['type'] && $item['menu_slug'] == $current ) {
        $bingo = true;
        return false;
    }elseif( isset($item['type']) && 'page' == $item['type'] ) {
        $bingo = false;
    }

    return $bingo;
}

function optionsframework_get_presets_list () {

	// noimage - /images/noimage_small.jpg

	$presets = array(
		'blue'			=> '/images/backgrounds/blue.jpg',
		'kaleidoscope'	=> '/images/backgrounds/r.jpg',
		'green'			=> '/images/backgrounds/green.jpg',
		'miniwide'		=> '/images/backgrounds/w.jpg',
		'minty'			=> '/images/backgrounds/minty.jpg',
		'indigo'		=> '/images/backgrounds/indigo.jpg',
		'brown'			=> '/images/backgrounds/brown.jpg',
		'classical'		=> '/images/backgrounds/cl.jpg',
		'creamy'		=> '/images/backgrounds/creamy.jpg',
		'fabulous'		=> '/images/backgrounds/fab.jpg',
		'jeans'			=> '/images/backgrounds/jeans.jpg',
		'orchid'		=> '/images/backgrounds/orchid.jpg',
		'violet'		=> '/images/backgrounds/v.jpg',
		'citylife'		=> '/images/backgrounds/city.jpg',
		'organic'		=> '/images/backgrounds/organic.jpg',
		'miniboxed'		=> '/images/backgrounds/b.jpg',
	);

	return $presets;
}

function optionsframework_presets_data( $id ) {
    static $presets = array();

    if ( empty($presets) ) {
		foreach ( optionsframework_get_presets_list() as $fname=>$thumb ) {
			$file = dirname(__FILE__) . '/presets/' . $fname . '.php';
			if ( is_readable( $file ) ) {
				include $file;
			}
		}
	}

    if ( isset( $presets[$id] ) ) {
        return $presets[$id];
    }
    return array();
}

function optionsframework_create_stylesheet() {
	// get the upload directory
	$upload_dir = wp_upload_dir();
	$filename = trailingslashit( $upload_dir['basedir'] ) . 'dynamic-stylesheet.css';

	ob_start();
	get_template_part( 'static-stylesheet' );
	$content = ob_get_clean();
	$content_hash = sha1( $content );

	if ( false == ( $file_hash = get_option( 'dt_dinamiccss1_hash' ) ) ) {
		$file_hash = $content_hash;
		add_option( 'dt_dinamiccss1_hash', $file_hash );
	}
	
	if ( @file_exists( $filename ) && $file_hash == $content_hash ) {
		return false;
	}
	
	if ( ! isset( $_GET['page'] ) ) {
        if ( ! isset( $_POST['_wp_http_referer'] ) ) {
            return true;
        } else {
            $arr = array();
            wp_parse_str( $_POST['_wp_http_referer'], $arr );
            $current = current( $arr );
        }
    } else {
        $current = $_GET['page'];
    }

	$form_fields = array (); // this is a list of the form field contents I want passed along between page views
	$method = ''; // Normally you leave this an empty string and it figures it out by itself, but you can override the filesystem method here

	$url = wp_nonce_url( add_query_arg( array( 'page' => $current, 'settings-updated' => 'true' ), 'admin.php' ), 'optionsframework-options' );
	if (false === ($creds = request_filesystem_credentials($url, $method, false, false, $form_fields) ) ) {
		// if we get here, then we don't have credentials yet,
		// but have just produced a form for the user to fill in, 
		// so stop processing for now

		return true; // stop the normal page form from displaying
	}
	
	if ( ! $creds ) {
		check_admin_referer("optionsframework-options");
	}

	// now we have some credentials, try to get the wp_filesystem running
	if ( ! WP_Filesystem($creds) ) {
		// our credentials were no good, ask the user for them again
		request_filesystem_credentials($url, $method, true, false, $form_fields);
		return true;
	}
	
	// by this point, the $wp_filesystem global should be working, so let's use it to create a file
	global $wp_filesystem;
	if ( ! $wp_filesystem->put_contents( $filename, $content, FS_CHMOD_FILE) ) {
		add_settings_error( 'options-framework', 'save_file', _x( 'Error while file saving', 'optionsframework', LANGUAGE_ZONE ), 'updated fade' );
		return false;
	} else  {
		add_settings_error( 'options-framework', 'save_file', _x( 'File saved', 'optionsframework', LANGUAGE_ZONE ), 'updated fade' );
	}
	
	if ( $file_hash != $content_hash ) {
		update_option( 'dt_dinamiccss1_hash', $content_hash );
	}

	return false;
}
?>