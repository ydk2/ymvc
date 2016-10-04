<?php

/**
 *
 */

class Router {

	static function app_from_get($array = array()) {
		if ($_GET != NULL) {
			try {
				$core = NULL;
				$retstr = "";
				foreach ($_GET as $key => $value) {
					$p = "\\application\\controller\\" . str_replace(',', '\\', $key);
					if (class_exists($p) && !in_array($key, $array)) {
						$core = new $p(MODEL, VIEW . str_replace(',', '/', $value));
						$retstr .= $core -> showin();
					}
				}
				unset($core);
				return $retstr;
			} catch (Exception $e) {
				echo 'Caught exception: ', $e -> getMessage(), "\n";
			}
			//return $_GET[$val];
		} else {
			return false;
		}
	}

	static function app_from_array($array) {
		if ($array != NULL) {
			try {
				$core = NULL;
				$retstr = "";
				foreach ($array as $key => $value) {
					$p = "\\application\\controller\\$key";
					if (class_exists($p)) {
						$core = new $p(MODEL, VIEW . $value);
						$retstr .= $core -> showin();
					}
				}
				unset($core);
				return $retstr;
			} catch (Exception $e) {
				echo 'Caught exception: ', $e -> getMessage(), "\n";
			}
			//return $_GET[$val];
		} else {
			return false;
		}
	}

	static function sys_from_get($array = array()) {
		if ($_GET != NULL) {
			try {
				$core = NULL;
				$retstr = "";
				foreach ($_GET as $key => $value) {
					$p = "\\system\\controller\\" . str_replace(',', '\\', $key);
					//echo "$p<br>";
					if (class_exists($p) && !in_array($key, $array)) {
						$core = new $p(SMODEL, SVIEW . str_replace(',', '/', $value));
						$retstr .= $core -> showin();
					}
				}
				unset($core);
				return $retstr;
			} catch (Exception $e) {
				echo 'Caught exception: ', $e -> getMessage(), "\n";
			}
		} else {
			return false;
		}
	}

	static function sys_from_array($array) {
		if ($array != NULL) {
			try {
				$core = NULL;
				$retstr = '';
				foreach ($array as $key => $value) {
					$p = "\\system\\controller\\$key";
					if (class_exists($p)) {
						$core = new $p(SMODEL, SVIEW . $value);
						$retstr .= $core -> showin();
					}
				}
				unset($core);
				return $retstr;
			} catch (Exception $e) {
				echo 'Caught exception: ', $e -> getMessage(), "\n";
			}
		} else {
			return false;
		}
	}

	static function from_array($array) {
		if ($array != NULL) {
			try {
				$retstr = '';
				$core = NULL;
				foreach ($array as $key => $value) {
					$p = str_replace('/', '\\', $value[0]);
					$m = str_replace('/', '\\', $value[1]);
					if (class_exists($p) && class_exists($m)) {
						$core = new $p($m, $value[2]);
						$retstr .= $core -> showin();
					}
				}
				unset($core);
				return $retstr;
			} catch (Exception $e) {
				echo 'Caught exception: ', $e -> getMessage(), "\n";
			}
		} else {
			return false;
		}
	}

	static function from_get($array = array()) {
		if ($_GET != NULL) {
			try {
				$core = NULL;
				$retstr = "";
				foreach ($_GET as $key => $value) {
					$p = "\\application\\controller\\" . str_replace(',', '\\', $key);
					$s = "\\System\\controller\\" . str_replace(',', '\\', $key);
					if (class_exists($p) && !in_array($key, $array)) {
						$core = new $p(MODEL, VIEW . str_replace(',', '/', $value));
						$retstr .= $core -> showin();
					} elseif (class_exists($s) && !in_array($key, $array)) {
						$core = new $s(SMODEL, SVIEW . str_replace(',', '/', $value));
						$retstr .= $core -> showin();
					}
				}
				unset($core);
				return $retstr;
			} catch (Exception $e) {
				echo 'Caught exception: ', $e -> getMessage(), "\n";
			}
		} else {
			return false;
		}
	}

}
?>