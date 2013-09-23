DELIMITER ;
/*fungsi numericToRom*/
/*membuat view*/

DROP TABLE IF EXISTS `view_parent_menu`; 
DROP TABLE IF EXISTS `view_menu`; 
DROP TABLE IF EXISTS `view_all_menu`;  
DROP TABLE IF EXISTS `view_ref_profiles`; 
DROP TABLE IF EXISTS `view_ref_drugs`; 

/*1/27/2009*/
DROP VIEW IF EXISTS `view_parent_menu`; 
CREATE VIEW `view_parent_menu` AS 
select `ref_menu`.`id` AS `id`,`ref_menu`.`parent_id` AS `parent_id`,`ref_menu`.`name` AS `name`,`ref_menu`.`url` AS `url`,`ref_menu`.`ordering` AS `ordering` from `ref_menu` where isnull(`ref_menu`.`parent_id`);


DROP VIEW IF EXISTS `view_menu`; 
CREATE VIEW `view_menu` AS 
select `menu_child`.`parent_id` AS `parent_id`,`menu_child`.`id` AS `id`,`menu_parent`.`name` AS `parent_name`,`menu_child`.`name` AS `name`,`menu_parent`.`url` AS `parent_url`,`menu_child`.`url` AS `url`,`menu_parent`.`ordering` AS `parent_ordering`,`menu_child`.`ordering` AS `child_ordering` from ((`ref_menu` `menu_child` join `view_parent_menu` `menu_parent` on((`menu_parent`.`id` = `menu_child`.`parent_id`))) join `group_menu` `gm` on((`gm`.`menu_id` = `menu_child`.`id`))) group by `menu_child`.`id` order by `menu_parent`.`ordering`,`menu_child`.`ordering`;

DROP VIEW IF EXISTS `view_ref_profiles`; 
CREATE VIEW `view_ref_profiles` AS 
select `rp`.`name` AS `name`,`rp`.`spesialisasi` AS `spesialisasi`,`rp`.`no_str` AS `no_str`,date_format(`rp`.`awal_berlaku_str`,'%d/%m/%Y') AS `awal_str`,date_format(`rp`.`akhir_berlaku_str`,'%d/%m/%Y') AS `akhir_str`,`rp`.`no_sip` AS `no_sip`,date_format(`rp`.`awal_berlaku_sip`,'%d/%m/%Y') AS `awal_sip`,date_format(`rp`.`akhir_berlaku_sip`,'%d/%m/%Y') AS `akhir_sip`,`rp`.`address` AS `address`,`rp`.`phone` AS `phone`,`rp`.`photo` AS `photo`,`rp`.`screensaver` AS `screensaver`,`rp`.`screensaver_delay` AS `screensaver_delay`,`rp`.`report_header_1` AS `report_header_1` from `ref_profiles` `rp`;


DROP VIEW IF EXISTS `view_ref_drugs`; 
CREATE VIEW `view_ref_drugs` AS 
select `rd`.`id` AS `drug_id`,`rd`.`name` AS `drug`,`rd`.`code` AS `code`,`rd`.`unit` AS `unit` from `ref_drugs` `rd` group by `rd`.`id`;
