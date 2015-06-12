<?php if($_GET['action']=="profile") { ?>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('../../../oc-includes/osclass/assets/js/jquery.validate.min.js');?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Code for form validation
        $("form").validate({});
    });
</script>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function(){
		<?php foreach($detail as $k=>$v) {?>
		<?php if($v['b_field_required'] == "1") { ?>
        $("#field_<?php echo $v['pk_i_id']; ?>").rules("add", {required: true, messages: { required: "<?php echo $v['s_field'];?> is required" }});
		<?php } ?>
		<?php } ?>
    }); 	
</Script>