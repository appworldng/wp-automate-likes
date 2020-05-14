<select name="automate_styling" id="automate_styling">
	<?php 
		$positions = ['top', 'bottom'] ;
		foreach($positions as $position):
	?>
	<option <?php if(get_option('automate_styling') == $position): ?>selected<?php endif; ?> value="<?php echo $position ?>"><?php echo $position; ?></option>
	<?php
		endforeach;
	?>
</select>