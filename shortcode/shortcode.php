<?php

/**
 * Plugin Name:       ShortCode Plugin 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Arif
 * Author URI:        https://arif.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * This is main class
 * 
 */
Final Class Short_Code_Test {

    private $version = '1.0';

    /**
    * The constructor function
    */
    private function __construct() {

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );

    }


    /**
     * Thie is the 
     *
     * @return void
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * This
     *
     * @return void
     */
    public function init_plugin() {

        add_shortcode( 'me-code', [ $this, 'Call_me_here' ] );

    }

    /**
     * This is the activation function
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'short_code_test' );

        if ( ! $installed ) {
            update_option( 'short_code_test', time() );
        }

        update_option( 'short_code_test_version', $this->version );
    }

    public function call_me_here( $atts ) {
        

        
        $arr = shortcode_atts( array(
            'type'=> 'radio',
            'name'=> 'First Name',
            'value'=> ''
        ), $atts);

        $values= $atts['value'];
        $values= explode(',',$values);
        
        ?>
        <form method = 'POST'>


        <?php 
         switch( $arr['type'] ) {
            case "Text" : 
                    text( $arr );
                    break;
            case "Radio" :
                    radio( $arr, $values );
                    break; 
            case "Dropdown" :
                    drop_down( $arr, $values );
                    break;
            }
        ?>

        </form>
        <?php
    }

    
}

/**
 * This is the main function
 *
 * @return void
 */
function short_code_test() {
     Short_Code_Test::init();
}

// kick off here
short_code_test();


function radio( $arr, $values ) {
    foreach( $values as $value) {
        ?>
        <div>
            <input type="radio" id="male" name="<?php echo esc_attr( $arr['name'] ) ; ?>" value="<?php if ( ! empty( $postdata['gender'] ) ) echo esc_attr($postdata['gender']); ?>">
            <label for="male"><?php echo esc_attr( $value ) ; ?></label><br>
        </div>
        <?php
    } 

}

function text( $arr ) {
    ?>
    <div>
        <p>
            <label for="tfield"><?php echo esc_attr( $arr['name'] ) ; ?> <span class="required">*</span> </label>
            <input type="text" name="fname" id="tfield" value="<?php if ( ! empty( $postdata['fname'] ) ) echo esc_attr($postdata['fname']); ?>" required="required" />
        </p>
    </div>
    <?php
}

function drop_down( $arr, $values ) {
    echo 'Choose a ' . esc_attr( $arr['name'] ) ; 
        ?>
        <div>
            <select name=" <?php echo esc_attr( $arr['name'] ) ; ?> " id="tfield">
                <?php foreach( $values as $value) : ?>
                <option value= "<?php $value ?>" > <?php echo esc_attr( $value ); ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
}