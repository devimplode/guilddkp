CREATE TABLE `dkp_user` (
`user_id`  smallint(5) NOT NULL AUTO_INCREMENT ,
`user_name`  varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`user_displayname`  varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`user_password`  varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`user_decrypt_password`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`user_email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`dkp`  smallint(5) NOT NULL DEFAULT 0 ,
`dkp_get`  smallint(5) NOT NULL DEFAULT 0 ,
`dkp_put`  smallint(5) NOT NULL DEFAULT 0 ,
`dkp_rm`  smallint(5) NOT NULL DEFAULT 0 ,
`user_rank`  smallint(5) UNSIGNED NOT NULL DEFAULT 1 ,
`user_style`  smallint(5) UNSIGNED NOT NULL DEFAULT 1 ,
`user_lang`  varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'de_de' ,
`user_key`  varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
`user_lastvisit`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`user_lastip`  varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`user_lastpage`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`user_active`  bit(1) NOT NULL DEFAULT b'0' ,
`user_newpassword`  bit(1) NOT NULL DEFAULT b'0' ,
`user_icon`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`first_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`last_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`country`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`town`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`state`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`ZIP_code`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`phone`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`cellphone`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`address`  text CHARACTER SET utf8 COLLATE utf8_bin NULL ,
`facebook_name`  varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`game_acc`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`icq`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`skype`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`msn`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`gender`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`birthday`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' ,
`privacy_settings`  blob NOT NULL ,
PRIMARY KEY (`user_id`),
FOREIGN KEY (`user_rank`) REFERENCES `dkp_ranks` (`rank_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
UNIQUE INDEX `user_name` USING BTREE (`user_name`) ,
UNIQUE INDEX `user_id` USING BTREE (`user_id`) ,
UNIQUE INDEX `user_displayname` USING BTREE (`user_displayname`) ,
INDEX `user_rank` USING BTREE (`user_rank`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_bin
AUTO_INCREMENT=1
ROW_FORMAT=COMPACT
;
