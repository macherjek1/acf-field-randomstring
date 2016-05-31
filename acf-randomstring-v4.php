<?php

class acf_field_randomstring extends acf_field {
	
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options
		
		
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'randomstring';
		$this->label = __('Random String');
		$this->category = __("Basic",'acf'); // Basic, Content, Choice, etc
		$this->defaults = array(
			// add default here to merge into your field. 
			// This makes life easy when creating the field options as you don't need to use any if( isset('') ) logic. eg:
			'used_character' => 'all',
			'length' => '5',
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like below) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// defaults?
		$field = array_merge($this->defaults, $field);
		
		// key is needed in the field names to correctly save the data
		$key = $field['name'];
		
		
		// Create Field Options HTML
		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Used Character",'acf'); ?></label>
				<p class="description"><?php _e("Used Characters for Random String",'acf'); ?></p>
			</td>
			<td>
				<?php
				
				do_action('acf/create_field', array(
					'type'		=>	'radio',
					'name'		=>	'fields['.$key.'][used_character]',
					'value'		=>	$field['used_character'],
					'layout'	=>	'horizontal',
					'choices'	=>	array(
						'all' => __('Letters and numbers (1-9, A-Z)'),
						'letter' => __('Only letters (A-Z)'),
						'number' => __('Only numbers (1-9)'),
					)
				));
				
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("String length",'acf'); ?></label>
				<p class="description"><?php _e("Number of characters",'acf'); ?></p>
			</td>
			<td>
				<?php
				
				do_action('acf/create_field', array(
					'type'		=>	'text',
					'name'		=>	'fields['.$key.'][length]',
					'value'		=>	$field['length'],
					'layout'	=>	'horizontal'
				));
				
				?>
			</td>
		</tr>
		<?php
		
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		global $post, $wpdb;
		
		// defaults?
		$field = array_merge($this->defaults, $field);
		
		$letters = 'abcdefghjklmnpqrstuvwxyz';
		$numbers = '123456789';
		$used = '';
		$length = 5;
		
		if($field['used_character'] == 'all') $used = $letters.$numbers;
		else if($field['used_character'] == 'letter') $used = $letters;
		else if($field['used_character'] == 'number') $used = $numbers;
		
		if(is_numeric(intval($field['length']))){
			if(intval($field['length']) <= 0) $length = 1;
			else if(intval($field['length']) > 40) $length = 40;
			else $length = intval($field['length']);
		}
		
		if(empty($field['value'])):
			$randString = self::generateRandomString($used, $length);
		?>
			<input type="text" id="<?php echo $field['key']; ?>" class="<?php echo $field['class']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo $randString; ?>" readonly="readonly" />
		<?php
		endif;
		
		if(!empty($field['value'])):
		?>
			<input type="text" id="<?php echo $field['key']; ?>" class="<?php echo $field['class']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" readonly="readonly" />
		<?php
		endif;
	}	
	
	
	/*
	*  format_value()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value( $value, $post_id, $field )
	{
		return strtolower(trim($value));
	}
	
	
	/*
	*  format_value_for_api()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is passed back to the API functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value_for_api( $value, $post_id, $field )
	{
		return strtolower(trim($value));
	}
	
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*/
	function input_admin_enqueue_scripts()
	{
		
		// register scripts
		wp_register_script( 'acf-input-randstring', $this->settings['dir'] . 'js/input.js', array('acf-input', ''), $this->settings['version'] );
		
		// enqueu scripts
		wp_enqueue_script(array(
			'acf-input-randstring',	
		));
		
	}
	
	
	/*
	* Get the Random String
	*/
	function generateRandomString($chars, $len) {
	    global $wpdb;
	    $randomString = '';
	    for ($i = 0; $i < $len; $i++) {
	        $randomString .= $chars[rand(0, strlen($chars) - 1)];
	    }
	    $results = $wpdb->get_results( "SELECT * FROM '.$wpdb->prefix.'postmeta WHERE meta_value= '$randomString'", ARRAY_A );
		if($wpdb->num_rows > 0) $randomString = self::generateRandomString($chars, $len);
		else return $randomString;
	}

	
}


// create field
new acf_field_randomstring();

?>
