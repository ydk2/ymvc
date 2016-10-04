<?php

/**
 * 
 */
abstract class Config {
	public static $data;
	public static function Init() {
		
		self::$data = array(
		'site_data'=>array(
		),
		'template'=>array(
			'index'=>'new',
			'any'=>'new',
			'admin'=>'admin',
			'system'=>'new',
			'default'=>'default',
			'user'=>'default'
		),
		'default'=>array(
				'language'=>'en',
				'database'=>array(
							'type'=>'mysql',
							'name'=>'database',
							'host'=>'localhost',
							'user'=>'root',
							'pass'=>'',
							'dbprefix'=>'',
							'dbpostfix'=>''),
				'theme'=>'main'
		),
		'actions'=>array(
		'data','item','items','action','actions'),
		'models'=> array(
		NULL,NULL),
		'languages'=>array(
		'en',
		'pl'
		),
		'disabled'=>array(
		),
		'enabled'=>array(
		),
		);
	}
}

?>