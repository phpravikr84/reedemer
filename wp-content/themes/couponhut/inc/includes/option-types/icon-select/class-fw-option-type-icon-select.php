<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class FW_Option_Type_Icon_Select extends FW_Option_Type
{
    public function get_type()
    {
        return 'icon-select';
    }

    /**
     * @internal
     */
    protected function _enqueue_static($id, $option, $data)
    {
        $uri = get_template_directory_uri() .'/inc/includes/option-types/'. $this->get_type() .'/static';

        wp_enqueue_style(
            'fw-option-'. $this->get_type(),
            $uri .'/css/jquery.fonticonpicker.min.css'
        );

        wp_enqueue_style(
            'fw-option-style-'. $this->get_type(),
            $uri .'/css/style.css'
        );

        wp_enqueue_script(
            'fw-option-'. $this->get_type(),
            $uri .'/js/jquery.fonticonpicker.min.js',
            array('fw-events', 'jquery')
        );

        wp_enqueue_script(
            'fw-option-'. $this->get_type() . '-script',
            $uri .'/js/input.js',
            array('fw-events', 'jquery',  'fw-option-'. $this->get_type())
        );
    }

    /**
     * @internal
     */
    protected function _render($id, $option, $data)
    {
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }
        /**
         * $data['value'] contains correct value returned by the _get_value_from_input()
         * You decide how to use it in html
         */
        $option['attr']['value'] = (string)$data['value'];

        /**
         * $option['attr'] contains all attributes.
         *
         * Main (wrapper) option html element should have "id" and "class" attribute.
         *
         * All option types should have in main element the class "fw-option-type-{$type}".
         * Every javascript and css in that option should use that class.
         *
         * Remaining attributes you can:
         *  1. use them all in main element (if option itself has no input elements)
         *  2. use them in input element (if option has input element that contains option value)
         *
         * In this case you will use second option.
         */

        $wrapper_attr = array(
            'id'    => $option['attr']['id'],
            'class' => $option['attr']['class'],
        );

        unset(
            $option['attr']['id'],
            $option['attr']['class']
        );

        $json_file =  get_template_directory() .'/inc/includes/option-types/'. $this->get_type() . '/icons/selection.json';


        if ( $wp_filesystem->exists($json_file) ) {

            $json_content = $wp_filesystem->get_contents($json_file);

            if(!$json_content) {
                return new WP_Error('reading_error', 'Error when reading file'); 
            }
            $json_content = json_decode( $json_content, true );


        } else {
            echo 'Error: JSON file not found'; 
            return false;
        }

        // icons SELECT input
        $html  = '<div '. fw_attr_to_html($wrapper_attr) .'>';
        $html .= '<select '. fw_attr_to_html($option['attr']) .' class="fonticonpicker">';
        $html .= '<option value="">'. __('None', 'fw').'</option>';
        foreach ( $json_content['icons'] as $icon ) {

            $glyph_full = $json_content['prefix'] . $icon;

            $html .= '<option value="'. $glyph_full .'" ' . selected(  $option['attr']['value'], $glyph_full, false ) . '>'. $glyph_full .'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    /**
     * @internal
     */
    protected function _get_value_from_input($option, $input_value)
    {
        /**
         * In this method you receive $input_value (from form submit or whatever)
         * and must return correct and safe value that will be stored in database.
         *
         * $input_value can be null.
         * In this case you should return default value from $option['value']
         */

        if (is_null($input_value)) {
            $input_value = $option['value'];
        }

        return (string)$input_value;
    }

    /**
     * @internal
     */
    protected function _get_defaults()
    {
        /**
         * These are default parameters that will be merged with option array.
         * They makes possible that any option has
         * only one required parameter array('type' => 'new').
         */

        return array(
            'value' => ''
        );
    }
}

FW_Option_Type::register('FW_Option_Type_Icon_Select');