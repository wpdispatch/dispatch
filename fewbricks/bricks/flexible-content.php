<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;
use fewbricks\acf\layout;

/**
 * Class flexible_content
 * @package fewbricks\bricks
 */
class flexible_content extends project_brick
{

    /**
     * @var string
     */
    protected $label = 'Flexible Content';

    /**
     *
     */
    public function set_fields()
    {

        $fc = new acf_fields\flexible_content('Bricks', 'bricks', '201708301459a', [
            'button_label' => 'Add Brick',
            'layout' => 'row'
        ]);

        $this->add_flexible_content($fc);

    }

    protected function get_brick_html() {
        $html = '';
        while ($this->have_rows('bricks')) {
            $this->the_row();

            $html .= acf_fields\flexible_content::get_sub_field_brick_instance()->get_html();
        }
        return $html;
    }

}
