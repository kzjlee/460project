<?php
// Followed options typography tutorial on http://theme.fm/2011/08/providing-typography-options-in-your-wordpress-themes-1576/

add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
    add_theme_page( 'My Theme Options', 'My Theme Options', 'edit_theme_options', 'my-theme-options', 'my_theme_options' );
}
function my_theme_options() {
?>
    <div class="wrap">
        <div><br></div>
        <h2>Coffee Toffee Theme Options</h2>

        <form method="post" action="options.php">
            <?php wp_nonce_field( 'update-options' ); ?>
            <?php settings_fields( 'my-options' ); ?>
            <?php do_settings_sections( 'my-options' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

add_action( 'admin_init', 'my_register_admin_settings' );
function my_register_admin_settings() {
    register_setting( 'my-options', 'my-options' );

    // Settings fields and sections
    add_settings_section( 
        'section_typography', //the id
        'Typography Options', // section title
        'my_section_typography', // $callback function 
        'my-options' ); //page (matches menu_slug set in add_submenu_page)

     //the function created in the add_settings_section
    add_settings_field( 'primary-font', 'Primary Font', 'my_field_primary_font', 'my-options', 'section_typography' );
}

function my_section_typography() {
    echo 'Choose your font here.';
}

function my_field_primary_font() {
    $options = (array) get_option( 'my-options' );
    $fonts = get_my_available_fonts();
    $current_font = 'Roboto';

    if ( isset( $options['primary-font'] ) )
        $current_font = $options['primary-font'];

    ?>
        <select name="my-options[primary-font]">
        <?php foreach( $fonts as $font_key => $font ): ?>
            <option <?php selected( $font_key == $current_font ); ?> value="<?php echo $font_key; ?>"><?php echo $font['name']; ?></option>
        <?php endforeach; ?>
        </select>
    <?php
}
function get_my_available_fonts() {
    $fonts = array(
        'open-sans' => array(
            'name' => 'Cabin Sketch',
            'import' => '',
            'css' => "font-family: 'Cabin Sketch', cursive;"
        ),
        'lato' => array(
            'name' => 'Roboto',
            'import' => '',
            'css' => "font-family: 'Roboto', sans-serif;"
        ),
        'arial' => array(
            'name' => 'Arial',
            'import' => '',
            'css' => "font-family: Arial, sans-serif;"
        )
    );

    return apply_filters( 'my_available_fonts', $fonts );
}



add_action( 'wp_head', 'my_wp_head' );
function my_wp_head() {
    $options = (array) get_option( 'my-options' );
    $fonts = get_my_available_fonts();
    $current_font_key = 'arial';

    if ( isset( $options['primary-font'] ) )
        $current_font_key = $options['primary-font'];

    if ( isset( $fonts[ $current_font_key ] ) ) {
        $current_font = $fonts[ $current_font_key ];

        echo '<style>';
        echo $current_font['import'];
        echo 'body * { ' . $current_font['css'] . ' } ';
        echo '</style>';
    }
}