<?php

/*
Plugin Name: Khal Extra Fields
Plugin URI: http://www.psskhal.com/
Description: This plugin adds fields to registratiion form
Version: 1.0.0
Author: OSClass
Author URI: http://www.psskhal.com/
Short Name: psskhal
*/

    function psskhal_call_after_install() {
        $conn = getConnection() ;
        $conn->autocommit(false);
        try {
            $path = osc_plugin_resource('psskhal/struct.sql');
            $sql = file_get_contents($path);
            $conn->osc_dbImportSQL($sql);//die($sql);
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();die(0);
        }
        $conn->autocommit(true);
    }

    function psskhal_call_after_uninstall() {
        $conn = getConnection() ;
        $conn->autocommit(false);
        try {
            $conn->osc_dbExec("DELETE FROM %st_plugin_category WHERE s_plugin_name = 'psskhal'", DB_TABLE_PREFIX);
            $conn->osc_dbExec('DROP TABLE %st_khal_fields', DB_TABLE_PREFIX);
			$conn->osc_dbExec('DROP TABLE %st_khal_fields_value', DB_TABLE_PREFIX);
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
        $conn->autocommit(true);
    }
	
	function psskhal_actions() {
		if( Params::getParam('file') != 'psskhal/admin.php' ) {
            return '';
        }
		$conn = getConnection() ;
		$savefield=Params::getParam('savefield');
		$fieldId=Params::getParam('fieldId');
		$mode=Params::getParam('mode');
		
		if( $savefield == 'true' ) {
            $fieldName = Params::getParam('fieldName');
			$status=Params::getParam('status');		
			$isRequired=Params::getParam('isRequiredField');	
			$fieldType=Params::getParam('fieldType');
			$dropdownValue=	Params::getParam('dropdownValue');
			if($fieldType!="DROPDOWN")
			$dropdownValue = "";
			$conn->autocommit(false);
        	try {
				if(Params::getParam('hdmode')=="edit" && Params::getParam('hdfieldId')!="")
				{
					$conn->osc_dbExec("UPDATE %st_khal_fields set s_field = '%s', b_active = %d, b_field_required = %d, s_field_type = '%s', s_field_type_value = '%s' WHERE pk_i_id = %d", DB_TABLE_PREFIX, $fieldName, $status, $isRequired, $fieldType, $dropdownValue, (int)Params::getParam('hdfieldId'));	
				}
				else
				{
            		$conn->osc_dbExec("INSERT INTO %st_khal_fields (s_field, b_active, b_field_required, s_field_type, s_field_type_value) VALUES ('%s', %d, %d, '%s', '%s')", DB_TABLE_PREFIX, $fieldName, $status, $isRequired, $fieldType, $dropdownValue);	
				}
			} 
			catch (Exception $e) {
            	$conn->rollback();
            	echo $e->getMessage();
        	}
        	$conn->autocommit(true);
        }
		else if(is_numeric($fieldId) && $mode!='edit')
		{
			$conn->autocommit(false);
        	try {
            	$conn->osc_dbExec("DELETE FROM %st_khal_fields WHERE pk_i_id = %d", DB_TABLE_PREFIX, (int)$fieldId);	
				$conn->osc_dbExec("DELETE FROM %st_khal_fields_value WHERE fk_i_field_id = %d", DB_TABLE_PREFIX, (int)$fieldId);	
			} 
			catch (Exception $e) {
            	$conn->rollback();
            	echo $e->getMessage();
        	}
        	$conn->autocommit(true);
		}
    }
	
	function psskhal_field_detail(){
		$fieldId=Params::getParam('fieldId');
		$mode=Params::getParam('mode');
		if(is_numeric($fieldId) && $mode=='edit')
		{
			$conn = getConnection() ;
	        $psskhal_field_detail = $conn->osc_dbFetchResult("SELECT * FROM %st_khal_fields WHERE pk_i_id = %d", DB_TABLE_PREFIX, (int)$fieldId);
			return ($psskhal_field_detail);
		}
	}
	
	function psskhal_list_field(){
		$conn = getConnection() ;
		$detail = $conn->osc_dbFetchResults("SELECT * FROM %st_khal_fields", DB_TABLE_PREFIX);
		return ($detail);
	}
	
	function psskhal_list_active_field(){
		$conn = getConnection() ;
		$detail = $conn->osc_dbFetchResults("SELECT * FROM %st_khal_fields WHERE b_active=%d", DB_TABLE_PREFIX, 1);
		return ($detail);
	}
	
	osc_add_hook('init_admin', 'psskhal_actions');
	//osc_add_hook('init_admin', 'psskhal_field_value');
	function psskhal_admin_configuration() {
        osc_admin_render_plugin('psskhal/admin.php');
    }
	
	function psskhal_registration_form()
	{
		$detail=psskhal_list_active_field();
		include_once 'registration.php';
	}
	
	function psskhal_registration_form_validation_add()
	{
		if($_GET['action']=="register" || $_GET['action']=="profile")
		{
			$detail=psskhal_list_active_field();
			include_once 'validator.php';
		}
	}
	
	function psskhal_registration_form_post($userId =0)
	{
		$detail=psskhal_list_active_field();
		if($userId>0)
		{
			$conn = getConnection() ;
			foreach($detail as $k=>$v)
			{
				$conn->osc_dbExec("INSERT INTO %st_khal_fields_value (fk_i_field_id, fk_i_user_id, s_value) VALUES (%d, %d, '%s')", DB_TABLE_PREFIX, $v['pk_i_id'], $userId, Params::getParam('field_'.$v['pk_i_id']));	
			}
		}
	}
	
	function psskhal_user_form()
	{
		$detail=psskhal_list_active_field();
		include_once 'user.php';
	}
	
	function psskhal_field_value($fieldId = 0, $userId = 0)
	{ 
		if($fieldId>0 && $userId>0)
		{
			$conn = getConnection() ;
	        $psskhal_field_detail = $conn->osc_dbFetchResult("SELECT * FROM %st_khal_fields_value WHERE fk_i_field_id = %d && fk_i_user_id= %d", DB_TABLE_PREFIX, (int)$fieldId, (int)$userId);
			return $psskhal_field_detail;
		}
	}
	
	function psskhal_user_form_post($userId =0)
	{
		$detail=psskhal_list_active_field();
		if($userId>0)
		{
			$conn = getConnection() ;
			$conn->osc_dbExec("DELETE FROM %st_khal_fields_value WHERE fk_i_user_id = %d", DB_TABLE_PREFIX, $userId);	
			foreach($detail as $k=>$v)
			{
				$conn->osc_dbExec("INSERT INTO %st_khal_fields_value (fk_i_field_id, fk_i_user_id, s_value) VALUES (%d, %d, '%s')", DB_TABLE_PREFIX, $v['pk_i_id'], $userId, Params::getParam('field_'.$v['pk_i_id']));	
			}
		}
	}
	
	function psskhal_write_meta_data()
	{
		$itemId=Params::getParam('id');
		$userId=osc_user_id();
		if($itemId>0 && $userId>0)
		{
			$conn = getConnection() ;
	        $item_detail = $conn->osc_dbFetchResult("SELECT * FROM %st_item WHERE pk_i_id= %d", DB_TABLE_PREFIX, (int)$itemId);
			$userId=$item_detail['fk_i_user_id'];
			
			$psskhal_field_values_detail = $conn->osc_dbFetchResults("SELECT * FROM %st_khal_fields_value WHERE fk_i_user_id= %d", DB_TABLE_PREFIX, (int)$userId);
			//print_r($psskhal_field_values_detail);
			include_once 'meta.php';
		}
	}
	
	function psskhal_meta_data($item='')
	{
		osc_add_hook('header', 'psskhal_write_meta_data');
	}

    osc_register_plugin(osc_plugin_path(__FILE__), 'psskhal_call_after_install');
	osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'psskhal_admin_configuration');
	osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'psskhal_call_after_uninstall');
	osc_add_hook('user_register_form', 'psskhal_registration_form');
	osc_add_hook('user_register_completed', 'psskhal_registration_form_post');
	osc_add_hook('user_form', 'psskhal_user_form');
	osc_add_hook('user_edit_completed', 'psskhal_user_form_post');	
	osc_add_hook('show_item', 'psskhal_meta_data');
	osc_add_hook('after_html', 'psskhal_registration_form_validation_add');
?>
