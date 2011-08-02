<?php

/*
 * TF OPTIONS: MASTER FUNCTIONS
 * 
 */

// Validation

function tf_settings_validate($input) {
    
        $newinput['text_string'] = trim($input['text_string']);
        if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
        $newinput['text_string'] = '';
    }

return $newinput;
}

// Display Settings

function tf_display_settings($options) {

    foreach ($options as $value) {
        switch ( $value['type'] ) {

        case "title":
        ?>
        <h3><?php echo $value['name']; ?></h3>

        <?php break;    

        case "open":
        ?>

        <table>

        <?php break;

        case "close":
        ?>

        </table>

        <?php break;

        case 'text':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td><input name="<?php echo $value['id'] ?>" type="<?php echo 'tf[' . $value['type'] . ']'; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>"></td>
        </tr>

        <?php
        break;

        case 'textarea':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td><textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea></td>
        </tr>

        <?php
        break;

        case 'select':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
                <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['options'] as $option) { ?>
                    <option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
                </select>
            </td>
        </tr>

        <?php
        break;

        case "checkbox":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
                <input type="checkbox" name="<?php echo $value['id']; ?>" class="iphone" id="<?php echo $value['id']; ?>" <?php echo $checked; ?> />
            </td>
        </tr>

        <?php break;

        case "radio":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
            <?php foreach ($value['options'] as $option) { ?>
                <div><input type="radio" name="<?php echo $value['id']; ?>" <?php if (get_settings( $value['id'] ) == $option) { echo 'checked'; } ?> /><?php echo $option; ?></div><?php } ?>
            </td>
        </tr>

        <?php break;
        }
	}
	
	foreach( $options as $option ) 
		if( !empty( $option['id'] ) )
			$option_ids[] = $option['id'];
	
	?>
	
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="<?php echo implode(',', $option_ids) ?>" />
    <?php wp_nonce_field( 'update-options' ); ?>
	    
    <?php
}

?>