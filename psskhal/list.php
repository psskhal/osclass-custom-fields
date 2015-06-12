<?php $detail=psskhal_list_field();?>
<?php if(count($detail)>0) {?>
<h2 class="render-title"><?php echo "Existing Fields"; ?></h2>

<table cellspacing="0" cellpadding="0" class="table" width="30%">
<tr>
	<th style='width:25px;'>S.N</th>
    <th style='width:150px;'>Field Name</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php $sn=1;?>
<?php foreach($detail as $k=>$v)
{
	if($sn%2==0)
	{
	?>
    <tr>
    <?php
	}
	else
	{
	?>
    <tr style="background-color: #EDFFDF;">
    <?php
	}
	?>
    	<td><?php echo $sn++;?></td>
    	<td><?php echo $v['s_field']; ?></td>
        <td><?php echo $v['b_active']==1?"Active":"InActive"; ?></td>
        <td><a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=psskhal/admin.php&fieldId='.$v['pk_i_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a> | <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=psskhal/admin.php&mode=edit&fieldId='.$v['pk_i_id']; ?>" >Edit</a></td>
    </tr>
    <?php
}
?>
</table>
<?php } ?>