<?php
namespace Common\Lib\Util;
//日志管理类
class LogUtil {
	
	private static $logDir = FILE_LOG_PATH;
	private static $logFile = 'app';
	private static $fileExt = '.log';
	
	/**
	 * 打印信息到指定日志
	 * @param mixed $message
	 */
	public static function info($message='',$fileName=''){
    	if(empty($fileName)){
        	$file = self::$logDir.self::$logFile.'-'.date('Ymd').self::$fileExt;
        }else{
        	$file = self::$logDir.$fileName.self::$fileExt;
        }
		
		$info = self::formatTimeStamp('Y-m-d H:i:s,x',self::getTimeStamp()).' : ';
		if(!is_null(json_decode($message))){
			$message = json_decode($message,true);
		}
		if (is_array($message)) {
			$message = var_export($message,true);
		}
		$info .= $message.chr(10);
		@file_put_contents($file, $info, FILE_APPEND);
	}
	
	/**
	 * 获取当前时间戳,精确到毫秒
	 * @return number
	 */
	private static function getTimeStamp(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	
	/**
	 * 格式化时间戳,精确到毫秒,x代表毫秒
	 * @param String $format:时间格式,比如:Y-m-d H:i:s,x
	 * @param String $time:时间戳
	 */
	private static function formatTimeStamp($format, $time) {
		if (strpos($time, '.') !== false) {
			list($usec, $sec) = explode(".", $time);
		}else{
			$usec = substr($time,0,10);
			$sec = str_replace($usec, '', $time);
		}
		$date = date($format,$usec);
		$sec = substr($sec, 0,3);
		return str_replace('x', $sec, $date);
	}
}

?>