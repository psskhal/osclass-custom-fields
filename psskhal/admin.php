<h2 class="render-title"><?php echo "Fields Configuration"; ?></h2>
<?php $psskhal_field_detail=psskhal_field_detail();?>
<?php //print_r($psskhal_field_detail);?>
<?php //echo "===>>>".Params::getParam('mode');?>
<form action="<?php echo osc_admin_render_plugin_url('psskhal/admin.php'); ?>" method="post">
    <input type="hidden" name="option" value="stepone" />
    <input type="hidden" name="savefield" value="true" />
    <input type="hidden" name="hdmode" value="<?php if(Params::getParam('mode')=='edit') { echo 'edit';}?>" />
    <input type="hidden" name="hdfieldId" value="<?php if(Params::getParam('mode')=='edit') { echo Params::getParam('fieldId');}?>" />
    <fieldset>
        <div class="form-horizontal">
        	<div class="form-row">
                <div class="form-label"><?php echo "Field Name"; ?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="fieldName" value="<?php echo $psskhal_field_detail['s_field'];?>" />&nbsp;&nbsp;<span style="color:#060; font-size:0px;">e.g. Permanent Address</div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php echo "Field Type"; ?></div>
                <div class="form-controls">
                <Select class="xlarge" name="fieldType" id="fieldType">
                <option value="TEXT" <?php if($psskhal_field_detail['s_field_type']=="TEXT") {?> selected="selected"<?php } ?>>TEXT</option>
                <option value="TEXTAREA" <?php if($psskhal_field_detail['s_field_type']=="TEXTAREA") {?> selected="selected"<?php } ?>>TEXTAREA</option>
                <option value="DROPDOWN" <?php if($psskhal_field_detail['s_field_type']=="DROPDOWN") {?> selected="selected"<?php } ?>>DROPDOWN</option>
                <?php /*?><option value="RADIO" <?php if($psskhal_field_detail['s_field_type']=="RADIO") {?> selected="selected"<?php } ?>>RADIO</option><?php */?>
                <option value="CHECKBOX" <?php if($psskhal_field_detail['s_field_type']=="CHECKBOX") {?> selected="selected"<?php } ?>>CHECKBOX</option>
                </Select> 
                </div>
            </div>
            <div class="form-row" id="selectValues" style="display:<?php if($psskhal_field_detail['s_field_type']=="DROPDOWN") {?> "block"<?php } else { ?> none<?php } ?>;">
                <div class="form-label"><?php echo "DropDown Values"; ?></div>
                <div class="form-controls">
                <input type="text" class="xlarge" name="dropdownValue" value="<?php echo $psskhal_field_detail['s_field_type_value'];?>" /> enter comma seperated values
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php echo "Is Required"; ?></div>
                <div class="form-controls">
                <Select class="xlarge" name="isRequiredField">
                <option value="1" <?php if($psskhal_field_detail['b_field_required']==1) {?> selected="selected"<?php } ?>>Yes</option>
                <option value="0" <?php if($psskhal_field_detail['b_field_required']==0) {?> selected="selected"<?php } ?>>No</option>
                </Select> 
                </div>
            </div>            
            <div class="form-row">
                <div class="form-controls">				
                <?php echo "InActive"; ?>&nbsp;<input type="radio" class="xlarge" name="status" value="0" <?php if($psskhal_field_detail['b_active']!=1) { echo 'checked="checked"';}?> />
                <?php echo "Active"; ?>&nbsp;<input type="radio" class="xlarge" name="status" value="1" <?php if($psskhal_field_detail['b_active']==1) { echo 'checked="checked"';}?> />
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" value="Save changes" class="btn btn-submit">
                <?php if(Params::getParam('mode')=='edit') {?>
                &nbsp;<a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=psskhal/admin.php'; ?>" class="btn btn-submit">Cancel</a>
                <?php } ?>
            </div>
        </div>
    </fieldset>
</form>
<?php include_once('list.php');?>
<script type="text/javascript">
    $(document).ready(function(){
	$("#fieldType").live("change", function(){
		if($('#fieldType').val() == "DROPDOWN")
		{
			$("#selectValues").show();
		}
		else
		{
			$("#selectValues").hide();
		}
	});
	}); 	
</Script>