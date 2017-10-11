<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text
 * @package fewbricks\bricks
 */
class text extends project_brick {

	protected $label = 'Text';

	public function set_fields() {
		$this->add_field(new acf_fields\text('Title', 'title', '093412052017a'));
		$this->add_field(new acf_fields\wysiwyg('Text', 'text', '093412052017b'));
	}

	public function get_brick_html() {
		$data = array(
			'title' => $this->get_field('title'),
			'text' => $this->get_field('text')
		);
		return \Timber::compile('bricks/text.twig', $data);
	}

}
