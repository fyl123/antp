<?php
include_once dirname(__FILE__).'/define.php';
$config_base = include_once dirname(__FILE__).'/base.config.php';
$config_route_rules = include_once dirname(__FILE__).'/route_rules.config.php';
$config_database = include_once dirname(__FILE__).'/database.config.php';
$config_mail = include_once dirname(__FILE__).'/mail.config.php';
$configs = array_merge($config_base,$config_route_rules,$config_database,$config_mail);
return $configs;