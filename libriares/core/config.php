<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Class with preconfigured values used as glogals
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC, Configuration
 * @package    YMVC System
 * @subpackage Config
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    3.0.0
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.0.0
 
 */
abstract class Config {
	public static $data;
	public static function Init() {
		
		self::$data = array(
		'tmp_data'=>array(
		),
		'site_data'=>array(
		),
		'template'=>array(
			'index'=>'new',
			'default'=>'default',
			'system'=>'default',
			'application'=>'default',
			'any'=>'new',
			'admin'=>'admin',
			'user'=>'default'
		),
		'default'=>array(
				'group'=>'any',
				'layout'=>'any',
				'allowregister'=>true,
				'loginlen'=>3,
				'passlen'=>5,
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
		'layouts'=>array(
		)
		);
	}
}

?>