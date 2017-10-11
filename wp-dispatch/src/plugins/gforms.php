<?php

namespace Dispatch\Plugins;

use GFAPI;
use Timber\Helper as TimberHelper;

class GForms {

    public function __construct() {

        add_filter('pre_option_rg_gforms_disable_css', '__return_true');
        add_filter( 'gform_field_css_class', [$this, 'gform_field_custom_class'], 10, 3 );
        add_filter( 'gform_field_container', [$this, 'field_container'], 10, 6 );
        add_filter( 'gform_field_content', [$this, 'field_content'], 10, 2 );
        add_filter( 'gform_submit_button', [$this, 'form_submit_button'] , 10, 2 );
        add_filter( 'gform_field_input', [$this, 'gform_field_input'], 10, 5 );
        add_filter( 'gform_ajax_spinner_url', [$this, 'spinner_url'], 10, 2 );

        add_filter( 'dispatch_add_to_context', [$this, 'add_to_context'] );

    }

    public function has_class( $class, $classes ) {
        $classes = explode( ' ', $classes );
        return in_array( $class, $classes );
    }

    public function gform_field_custom_class( $classes, $field, $form ) {
        switch( $field->type ) {
            case 'name':
            case 'fileupload':
            case 'html':
            case 'radio':
            case 'checkbox':
                if ( strpos( $field['cssClass'], 'gfield-small' ) === false &&
                     strpos( $field['cssClass'], 'gfield-medium' ) === false &&
                     strpos( $field['cssClass'], 'gfield-large' ) === false ) {
                    $classes .= " gfield-large";
                }
                break;
            case 'textarea':
                    $classes .= " gfield-textarea";
                break;
              break;
            default:
                $classes .= " gfield-{$field->size}";
        }
        return $classes .= ' form-group';
    }

    public function field_container( $field_container, $field, $form, $css_class, $style, $field_content ) {
        if ( IS_ADMIN ) {
            return $field_container;
        }

        if ( $field['type'] == 'section' && strpos( $field['cssClass'], 'row-start' ) !== false ) {
            $field_container = '<li class="form-row" ><ul>';
        } elseif ( $field['type'] == 'section' && strpos( $field['cssClass'], 'row-end' ) !== false ) {
            $field_container = '</ul></li>';
        }

        return ( $field_container );
    }

    public function field_content( $field_content, $field ) {
        if ( $field->type == 'textarea' ) {
            return str_replace( "rows='10'", "rows='3'", $field_content );
        }

        return $field_content;
    }

    public function form_submit_button( $button, $form ) {
        // var_dump( $form );
        return "<button class='btn btn-lg btn-primary' id='gform_submit_button_{$form['id']}'>{$form['button']['text']}</button>";
    }

    public function spinner_url( $image_src, $form ) {
        return get_stylesheet_directory_uri().'/assets/img/ripple-xs.svg';
    }

    public function gform_field_input( $input, $field, $value, $lead_id, $form_id ) {
        if ( $field->type == 'checkbox' && $this->has_class( 'custom-checkbox', $field->cssClass ) ) {
            ob_start(); ?>
                <?php $index = 1; ?>
                <?php foreach( $field->choices as $choice ) { ?>
                    <label class="form-check-label">
                      <input type="checkbox" name="input_<?php echo $field->id ?>.<?php echo $index; ?>" value="<?php echo $choice['value']; ?>" <?php if ( $choice['isSelected'] ) { ?>checked="checked"<?php } ?> class="form-check-input"><span></span>
                      <span class="checkbox-selection"><?php echo $choice['text']; ?></span>
                    </label>
                    <?php $index++; ?>
                <?php } ?>
            <?php
            $input = ob_get_clean();
        }

        return $input;

    }

    public function add_to_context( $context ) {

        TimberHelper::function_wrapper( [$this, 'get_gform_title'], array( false) );
        TimberHelper::function_wrapper( [$this, 'get_gform_description'], array( false) );

        return $context;
    }

    public static function get_gform_title( $form_id = false ) {
        if ( !$form_id ) return '';
        $form = GFAPI::get_form($form_id);
        return isset($form['title']) ? $form['title'] : '';
    }

    public static function get_gform_description( $form_id = false ) {
        if ( !$form_id ) return '';
        $form = GFAPI::get_form($form_id);
        return isset($form['description']) ? $form['description'] : '';
    }

}
