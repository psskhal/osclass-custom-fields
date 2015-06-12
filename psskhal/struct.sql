CREATE TABLE /*TABLE_PREFIX*/t_khal_fields (
  pk_i_id int(11) NOT NULL AUTO_INCREMENT,
  s_field varchar(100) CHARACTER SET utf8 NOT NULL,
  b_active tinyint(1) NOT NULL DEFAULT '0',
  b_field_required tinyint(1) NOT NULL DEFAULT '1',
  s_field_type varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'TEXT',
  s_field_type_value varchar(4000) CHARACTER SET utf8,
  PRIMARY KEY (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_khal_fields_value (
  pk_i_id int(11) NOT NULL AUTO_INCREMENT,
  fk_i_field_id int(11) NOT NULL,
  fk_i_user_id int(11) NOT NULL,
  s_value text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';