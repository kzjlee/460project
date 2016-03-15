<?php

//Followed a typography options tutorial at http://theme.fm/2011/08/providing-typography-options-in-your-wordpress-themes-1576/
function cd_add_submenu() {
		add_submenu_page( 'themes.php', 'Coffee Toffee Options Page', 'Theme Options', 'manage_options', 'my-theme-options', 'my_theme_options_page');
	}
add_action( 'admin_menu', 'cd_add_submenu' );


function cd_settings_init() { 
	register_setting( 'theme_options', 'cd_options_settings' );
	
	add_settings_section(
		'cd_options_page_section', //the id
		'Your section description',  // section title
		'cd_options_page_section_callback', // $callback function 
		'theme_options' //page (matches menu_slug set in add_submenu_page)
	);
	
	function cd_options_page_section_callback() { 
		echo 'Change options in this page';
	} //the function created in the add_settings_section

	add_settings_field( 
		'cd_text_field', 
		'Enter your text', 
		'cd_text_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);

	add_settings_field( 
		'cd_checkbox_field', 
		'Check your preference', 
		'cd_checkbox_field_render', 
		'theme_options', 
		'cd_options_page_section'  
	);

	add_settings_field( 
		'cd_radio_field', 
		'Choose an option', 
		'cd_radio_field_render', 
		'theme_options', 
		'cd_options_page_section'  
	);
	
	add_settings_field( 
		'cd_textarea_field', 
		'Enter content in the textarea', 
		'cd_textarea_field_render', 
		'theme_options', 
		'cd_options_page_section'  
	);
	
	add_settings_field( 
		'cd_select_field', 
		'Choose from the dropdown', 
		'cd_select_field_render', 
		'theme_options', 
		'cd_options_page_section'  
	);

//Font control add_settings adapted to our options page
    add_settings_field( 
    	'primary-font', 
    	'Choose your primary font', 
    	'my_field_primary_font', 
    	'theme_options',
    	'cd_options_page_section' 
    	);



//Function to get available fonts
function get_my_available_fonts() {
    $fonts = array(
        'Cabin Sketch' => array(
            'name' => 'Cabin Sketch',
            'import' => '',
            'css' => "font-family: 'Cabin Sketch', cursive;"
        ),
        'Roboto' => array(
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

//Creating the callback function
    function my_field_primary_font() {
    $options = (array) get_option( 'cd_options_settings' );
    $fonts = get_my_available_fonts();
    $current_font = 'Roboto';

    if ( isset( $options['primary-font'] ) )
        $current_font = $options['primary-font'];

    ?>
        <select name="cd_options_settings[primary-font]">
        <?php foreach( $fonts as $font_key => $font ): ?>
            <option <?php selected( $font_key == $current_font ); ?> value="<?php echo $font_key; ?>"><?php echo $font['name']; ?></option>
        <?php endforeach; ?>
        </select>
    <?php
}

	function cd_text_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="text" name="cd_options_settings[cd_text_field]" value="<?php if (isset($options['cd_text_field'])) echo $options['cd_text_field']; ?>" />
		<?php
	}
	
	function cd_checkbox_field_render() { 
		$options = get_option( 'cd_options_settings' );
	?>
		<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" <?php if (isset($options['cd_checkbox_field'])) checked( 'on', ($options['cd_checkbox_field']) ) ; ?> value="on" />
		<label>Turn it On</label> 
		<?php	
	}
	
	function cd_radio_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="radio" name="cd_options_settings[cd_radio_field]" <?php if (isset($options['cd_radio_field'])) checked( $options['cd_radio_field'], 1 ); ?> value="1" /> <label>Option One</label><br />
		<input type="radio" name="cd_options_settings[cd_radio_field]" <?php if (isset($options['cd_radio_field'])) checked( $options['cd_radio_field'], 2 ); ?> value="2" /> <label>Option Two</label><br />
		<input type="radio" name="cd_options_settings[cd_radio_field]" <?php if (isset($options['cd_radio_field'])) checked( $options['cd_radio_field'], 3 ); ?> value="3" /> <label>Option Three</label>
		<?php
	}
	
	function cd_textarea_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<textarea cols="40" rows="5" name="cd_options_settings[cd_textarea_field]"><?php if (isset($options['cd_textarea_field'])) echo $options['cd_textarea_field']; ?></textarea>
		<?php
	}

	function cd_select_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<select name="cd_options_settings[cd_select_field]">
			<option value="1" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 1 ); ?>>Option 1</option>
			<option value="2" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 2 ); ?>>Option 2</option>
		</select>
	<?php
	}
}
	
	function my_theme_options_page(){ 
		?>
		<form action="options.php" method="post">
			<h2>Coffee Toffee Options Page</h2>
			<?php
			settings_fields( 'theme_options' );
			do_settings_sections( 'theme_options' );
			submit_button();
			?>
		</form>
		<?php
	}

add_action( 'admin_init', 'cd_settings_init' );


