<?php foreach($detail as $k=>$v) {?>
<div class="control-group">
    <label for="field_<?php echo $v['pk_i_id']; ?>" class="control-label"><?php echo $v['s_field'];?></label>
    <div class="controls">
    <?php $fv=psskhal_field_value($v['pk_i_id'], osc_user_id()); ?>
    <?php //echo "<pre>"; print_r($fv); echo "</pre>";?>
    <?php if($v['s_field_type'] == "TEXT") { ?>
    <input type="text" value="<?php echo $fv['s_value']; ?>" name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>" />          
    <?php } else if($v['s_field_type'] == "TEXTAREA") { ?>
    <textarea name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>"><?php echo $fv['s_value']; ?></textarea>
    <?php } else if($v['s_field_type'] == "DROPDOWN") { ?>
    <select name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>">
    <?php $vals = explode(",", $v['s_field_type_value']);
	foreach($vals as $val) {?>
    <?php $val = trim($val);?>
   <option value="<?php echo $val;?>" <?php if($fv['s_value'] == $val) {?> selected="selected" <?php } ?>><?php echo $val;?></option>
	<?php } ?>
    </select><label class="error" for="field_<?php echo $v['pk_i_id']; ?>" generated="false"></label>
    <?php } else if($v['s_field_type'] == "RADIO") { ?>
    <input type="radio" name="field_<?php echo $v['pk_i_id']; ?>" value="1" id="field_<?php echo $v['pk_i_id']; ?>" <?php if($fv['s_value'] == 1) {?> checked="checked" <?php } ?> />
    <?php } else if($v['s_field_type'] == "CHECKBOX") { ?>
    <input type="checkbox" name="field_<?php echo $v['pk_i_id']; ?>" value="1" id="field_<?php echo $v['pk_i_id']; ?>" <?php if($fv['s_value'] == 1) {?> checked="checked" <?php } ?> />
    <?php } ?>                
    </div> 
</div>
<?php } ?>


