CREATE TABLE `dkp_items` (
`id`  mediumint(8) UNSIGNED NOT NULL ,
`quality`  tinyint(3) UNSIGNED NOT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`unique`  tinyint(4) NULL DEFAULT 0 COMMENT '0 = Nicht einzigartig, 1 = Einzigartig' ,
`heroic`  tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '1 = Heroic/Heroisch' ,
`displayid`  mediumint(8) NOT NULL ,
`icon`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '' COMMENT 'icon-title' ,
`category`  tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '0 = Sonstiges, 1 = Rüstung, 2 = Waffe' ,
`subcategory`  tinyint(3) UNSIGNED NULL DEFAULT NULL ,
`place`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Kopf, Brust, Hals etc.' ,
`binding`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '0 = Nich gebunden, 1 = Aufheben Gebunden, 2 = Anlegen Gebunden, 3 = Accountgebunden' ,
`armor`  smallint(5) UNSIGNED NULL DEFAULT NULL ,
`agility`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Beweglichkeit' ,
`intellect`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Intelligenz' ,
`spirit`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Willenskraft' ,
`stamina`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Ausdauer' ,
`strength`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Stärke' ,
`hit`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Trefferwertung' ,
`crit`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'kritische Trefferwertung' ,
`haste`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Tempowertung' ,
`block`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Blockwertung' ,
`dodge`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Ausweichwertung' ,
`parry`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Parierwertung' ,
`defense`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Verteidigungswertung' ,
`attack_power`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Angriffskraft' ,
`armor_penetration`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Rüstungsdurchschlag' ,
`expertise`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Waffenkunde' ,
`resilience`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Abhärtung' ,
`spell_power`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Zaubermacht' ,
`manareg`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Alle 5 Sekunden x Mana' ,
`arcane_res`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Arkanwiderstand' ,
`fire_res`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Feuerwiderstand' ,
`frost_res`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Frostwiderstand' ,
`nature_res`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Naturwiderstand' ,
`shadow_res`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Schattenwiderstand' ,
`blue_socket`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Anzahl blaue Sockel' ,
`red_socket`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Anzahl rote Sockel' ,
`yellow_socket`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Anzahl gelber Sockel' ,
`prism_socket`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Anzahl prismatischer Sockel' ,
`meta_socket`  tinyint(3) UNSIGNED NULL DEFAULT NULL ,
`socket_bonus`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT 'Sockelbonus' ,
`durability`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'Haltbarkeit' ,
`required_level`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Benötigtes Level' ,
`item_level`  tinyint(3) UNSIGNED NULL DEFAULT NULL ,
`min_dmg`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'nur bei Waffen' ,
`max_dmg`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'nur bei Waffen' ,
`dmg_type`  tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Wir bei Zauberstäben gebraucht' ,
`speed`  tinyint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'nur bei Waffen' ,
`dps`  smallint(5) UNSIGNED NULL DEFAULT NULL COMMENT 'nur bei Waffen' ,
`use`  text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT 'Effekt beim Benutzen' ,
`setboni`  text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT 'Setbonus' ,
`gearscore`  float UNSIGNED NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=COMPACT
;

