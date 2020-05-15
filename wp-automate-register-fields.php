<?php
	add_settings_section(
		"section", 
		"", 
		null, 
		"automate-options"
	);

	add_settings_field(
		"automate_likes", 
		"Automate Likes/Smiles", 
        array(get_called_class(), "admin_automate_likes"),
		"automate-options", 
		"section"
	);

	add_settings_field(
		"automate_increment", 
		"Automate Increment", 
        array(get_called_class(), "admin_automate_increment"),
		"automate-options", 
		"section"
	);

	add_settings_field(
		"automate_css", 
		"Automate Styling (CSS)", 
        array(get_called_class(), "admin_automate_styling"),
		"automate-options", 
		"section"
	);

	register_setting(
		"section", "automate_value"
	);

	register_setting(
		"section", "automate_increment"
	);

	register_setting(
		"section", "automate_styling"
	);

?>