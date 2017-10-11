<?php

namespace Dispatch\Functions;

class MetaBox {

  public function __construct() {

  }

  public function taxonomy_radio_meta_box( $post, $meta_box_properties ) {
    $taxonomy = $meta_box_properties['args']['taxonomy'];
    $tax = get_taxonomy($taxonomy);
    $terms = get_terms($taxonomy, array('hide_empty' => 0));
    $name = 'tax_input[' . $taxonomy . ']';
    $postterms = get_the_terms( $post->ID, $taxonomy );
    $current = ($postterms ? array_pop($postterms) : false);
    $current = ($current ? $current->term_id : 0);
    ?>
    <div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
      <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
        <li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
      </ul>

      <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
        <input name="tax_input[<?php echo $taxonomy; ?>][]" value="0" type="hidden">
        <ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:symbol" class="categorychecklist form-no-clear">
          <?php foreach( $terms as $term ) {
            $id = $taxonomy.'-'.$term->term_id;?>
            <li id="<?php echo $id?>"><label class="selectit"><input value="<?php echo $term->term_id; ?>" name="tax_input[<?php echo $taxonomy; ?>][]" id="in-<?php echo $id; ?>"<?php if( $current === (int)$term->term_id ){?> checked="checked"<?php } ?> type="radio"> <?php echo $term->name; ?></label></li>
            <?php } ?>
        </ul>
      </div>
    </div>
    <?php
  }

}
