<?php

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;

use Dispatch\Plugins\ACF as ACF;

$fewbricks_fg_location = [
	[
		[
			'param' => 'page_type',
			'operator' => '==',
			'value' => 'front_page',
		],
	]
];

// ACF::show_on_screen( $fewbricks_fg_location, ['the_content'] );
ACF::hide_on_screen( $fewbricks_fg_location, ['the_content'] );
// ACF::hide_on_screen( $fewbricks_fg_location );

?>
