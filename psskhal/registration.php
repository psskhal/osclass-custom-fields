<?php foreach($detail as $k=>$v) {?>
<div class="control-group">
    <label for="field_<?php echo $v['pk_i_id']; ?>" class="control-label"><?php echo $v['s_field'];?></label>
    <div class="controls">
    <?php if($v['s_field_type'] == "TEXT") { ?>
    <input type="text" value="" name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>" />          
    <?php } else if($v['s_field_type'] == "TEXTAREA") { ?>
    <textarea name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>"></textarea>
    <?php } else if($v['s_field_type'] == "DROPDOWN") { ?>
    <select name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>">
    <?php $vals = explode(",", $v['s_field_type_value']);
	foreach($vals as $val) {?>
    <?php $val = trim($val);?>
   <option value="<?php echo $val;?>"><?php echo $val;?></option>
``	<?php } ?>
    </select>
    <?php } else if($v['s_field_type'] == "RADIO") { ?>
    <input type="radio" name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>" />
    <?php } else if($v['s_field_type'] == "CHECKBOX") { ?>
    <input type="checkbox" name="field_<?php echo $v['pk_i_id']; ?>" id="field_<?php echo $v['pk_i_id']; ?>" />
    <?php } ?>      
    </div> 
</div>
<?php } ?>

