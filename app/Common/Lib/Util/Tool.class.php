<?php
namespace Common\Lib\Util;

class Tool {
	
	/**
	 * 获取get或post参数值
	 * @param string $name 变量的名称 支持指定类型
	 * @param mixed $default 不存在的时候默认值
	 * @param mixed $filter 参数过滤方法
	 * @return mixed
	 */
	public static function getValue($name,$default='',$filter=null){
		return I($name,$default,$filter);
	}
	
	/**
	 * 实例化Action 格式：[项目://][分组/]模块
	 * @param string $name Action资源地址
	 * @param string $layer 控制层名称
	 * @param boolean $common 是否公共目录
	 * @return Action|false
	 */
	public static function getActionInstance($name,$layer='',$common=false){
		return A($name,$layer,$common);
	}
	
	/**
	 * D函数用于实例化Model 格式 项目://分组/模块
	 * @param string $name Model资源地址
	 * @param string $layer 业务层名称
	 * @return Model
	 */
	public static function getModelInstance($name='',$layer=''){
		return D($name,$layer);
	}
	
	/**
	 * 获取或设置配置参数
	 * @param unknown_type $name
	 * @param unknown_type $value
	 */
	public static function config($name=null, $value=null){
		return C($name,$value);
	}
	
	/**
	 * URL组装 支持不同URL模式
	 * @param string $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
	 * @param string|array $vars 传入的参数，支持数组和字符串
	 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
	 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
	 * @param boolean $domain 是否显示域名
	 * @return string
	 */
	public static function getUrl($url='',$vars='',$suffix=true,$redirect=false,$domain=false) {
		return U($url,$vars,$suffix,$redirect,$domain);
	}
	
	/**
	 * URL重定向
	 * @param string $url 重定向的URL地址
	 * @param string $msg 重定向前的提示信息
	 * @param integer $time 重定向的等待时间（秒）
	 * @return void
	 */
	public static function redirect($url,$msg='',$time=0) {
		if ($time == 0) {
			$time = C('APP_REDIRECT_TIME');
		}
		$time = $time ? $time : 0;
		redirect($url, $time, $msg);
	}
	
	/**
	 * 设置session
	 * @param string|array $name session名称 如果为数组则表示进行session设置
	 * @param mixed $value session值
	 * @return mixed
	 */
	public static function session($name,$value='') {
		session($name,$value);
	}
	
	/**
	 * 销毁session
	 * @param mixed $names
	 */
	public static function unsetSession($names=''){
		if (empty($names)) {
			unset($_SESSION);
       		session_destroy();
		}else{
			$keys = $names; 
			if (!is_array($names)) {
				$keys = array($names);
			}
			foreach ($keys as $key) {
				session($key,null);
			}
		}
	}
	
	/**
	 * Cookie 设置、获取、删除
	 * @param string $name cookie名称,为null时表示删除所有cookie
	 * @param mixed $value cookie值,为null时表示删除指定的cookie
	 * @param mixed $options cookie参数
	 * @return mixed
	 */
	public static function cookie($name, $value='', $option=null) {
		cookie($name, $value, $option);
	}
	
	/**
	 * 获取分页导航
	 * @param int $count:总记录数
	 * @param int $pageSize:每页记录数
	 * @param mixed $param:分页参数
	 * @param string $url:
	 * @return string
	 */
	public static function showPage($count=0,$pageSize=0,$param=null,$url=''){
		$page = self::initPage($count,$pageSize,$param,$url);
		return $page->show();
	}
	
	public static function initPage($count=0,$pageSize=0,$param=null,$url=''){
		import('Org.Util.Page');
		$page = new \Page((int)$count,(int)$pageSize,$param,$url);
		return $page;
	}
	
	/**
	 * 文件上传
	 * @param string $savePath:文件保存路径
	 * @param int $maxSize:允许上传的文件大小
	 * @param array $allowExts:允许上传的文件类型
	 * @param array $thumb:缩略图选项
	 * @return mixed
	 */
	public static function uploadFile($savePath,$maxSize=0,$allowExts=array(),$thumb=array()){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize  = $maxSize ;// 设置附件上传大小
		$upload->exts  = $allowExts;// 设置附件上传类型
		$upload->rootPath = $savePath; // 设置附件上传目录
		$upload->subName = ''; //子目录创建方式
		$result = $upload->upload();
		if(!$result) {// 上传错误提示错误信息
			return $upload->getError();
		}else{
			return $result;
		}
	}
	
	private static function initView(){
		return \Think::instance('View');
	}
	
	/**
	 * 模板显示 调用内置的模板引擎显示方法，
	 * @access protected
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $charset 输出编码
	 * @param string $contentType 输出类型
	 * @param string $content 输出内容
	 * @param string $prefix 模板缓存前缀
	 * @return void
	 */
	public static function display($templateFile='',$charset='',$contentType='',$content='',$prefix='') {
		self::initView()->display($templateFile,$charset,$contentType,$content,$prefix);
	}
	
	/**
	 *  获取输出页面内容
	 * 调用内置的模板引擎fetch方法，
	 * @access protected
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $content 模板输出内容
	 * @param string $prefix 模板缓存前缀
	 * @return string
	 */
	public static function fetch($templateFile='',$content='',$prefix='') {
		return self::initView()->fetch($templateFile,$content,$prefix);
	}
	
	/**
	 * 模板变量赋值
	 * @access protected
	 * @param mixed $name 要显示的模板变量
	 * @param mixed $value 变量的值
	 * @return Action
	 */
	public static function assign($name,$value='') {
		return self::initView()->assign($name,$value);
	}
	
	/**
	 * 取得模板显示变量的值
	 * @access protected
	 * @param string $name 模板显示变量
	 * @return mixed
	 */
	public static function get($name='') {
		return self::initView()->get($name);
	}
	
	/**
	 * 添加js文件
	 * @param mixed $js_uri
	 * @return void
	 */
	public static function addJS($js_uri) {
		global $js_files;
		$js_file = array();
		if (!isset($js_files)){
			$js_files = array();
		}
		if (!is_array($js_uri)) {
			$js_uri = array($js_uri);
		}
		foreach($js_uri as $js){
			$js_file[] = '<script type="text/javascript" src="'.$js.'"></script>';
		}
		// adding file to the big array...
		$js_files = array_unique(array_merge($js_files, $js_file));
		return true;
	}
	
	/**
	 * 添加css文件
	 * @param mixed $css_uri
	 * @param string $media_type
	 * @return true
	 */
	public static function addCSS($css_uri, $media_type = 'all') {
		global $css_files;
		$css_file = array();
		if (!isset($css_files)){
			$css_files = array();
		}
		if (!is_array($css_uri)) {
			$css_uri = array($css_uri);
		}
		foreach($css_uri as $css){
			$css_file[] = '<link href="'.$css.'" rel="stylesheet" type="text/css" media="'.$media_type.'">';
		}
		// adding file to the big array...
		$css_files = array_unique(array_merge($css_files, $css_file));
		return true;
	}
	
	public static function setTitle($title=''){
		$title = '<title>'.$title.'</title>';
		return $title;
	}
	
	public static function setKeywords($keywords=''){
		$keywords = '<meta name="Keywords" content="'.$keywords.'">';
		return $keywords;
	}
	
	public static function setDescription($description=''){
		$description = '<meta name="Description" content="'.$description.'">';
		return $description;
	}
	
	/**
	 * 获取二维数组中某个字段的集合
	 * @param array $data:二维数组
	 * @param string $field:字段
	 * @return array 返回一维数组
	 */
	public static function getFieldList($data,$field){
		return array_reduce($data, create_function('$result=array(),$item','$result[] = $item["'.$field.'"];return $result;'));
	}
	
	/**
	 * 获取csv文件内容
	 * @param String $filename:文件名,包含路径信息
	 * @param int $startRow:起始行
	 * @param String $titleRow:标题行
	 * @param String $separator:分隔符
	 * @return array
	 */
	public static function getCsvDatas($filename,$startRow = 1,$titleRow = 1,$separator = ','){
		$datas = array();
		$filename = iconv('UTF-8','GB2312',$filename);
		if ($startRow < $titleRow) {
			return $datas;
		}
		$row = 1;
		if(($handle = fopen($filename, "r")) !== false){
			while(($dataSrc = fgetcsv($handle,0,$separator)) !== false){
				$num = count($dataSrc);
				if($row == $titleRow){
					for ($i = 0; $i < $num; $i++){
						$title[] = $dataSrc[$i];
					}
				}
				if ($row>=$startRow) {
					if(!empty($dataSrc)){
						$data = array();
						foreach($title as $key => $value){
							$data[$value] = $dataSrc[$key];
						}
						$datas[] = $data;
					}
				}
				$row++;
			}
			fclose($handle);
		}
		return $datas;
	}
	
	/**
	 * 导出csv
	 * @param array $datas:csv所需数据,二维数组格式
	 * @param String $filename:默认的文件名
	 */
	public static function exportCsv($datas,$filename=''){
		$contents = '';
		$filename = iconv('UTF-8','GB2312',$filename);
		if ($filename == '' || empty($filename)) {
			$filename = date('YmdHis');
		}
		header("Content-Type:text/csv;charset=UTF-8");
		header("Content-Disposition:attachment;filename=$filename.csv");
		foreach ($datas as $row) {
			$str_row = array();
			foreach ($row as $column) {
				$str_row[] = '"'.str_replace('"', '""', $column).'"';
			}
			$contents .= implode(',', $str_row).PHP_EOL;
		}
		//$contents = "\xEF\xBB\xBF".$contents;
		echo $contents;
	}
	
	/**
	 * 将树形结构数组转换成html
	 * @param array $data
	 * @param string $key:子节点
	 * @param string $pKey:父节点
	 * @param string $node:节点内容
	 * @param int $pid:父节点值
	 * @param string $ptag:父节点标签
	 * @param string $tag:子节点标签
	 * @return string
	 */
	public static function treeToHtml($data,$key='id',$pKey='pid',$node='text',$pid=0,$ptag='ul',$tag='li'){
		$html = '';
		foreach ($data as $rk => $rv) {
			if($rv[$pKey] == $pid){
				$html .= '<'.$tag.'>'.$rv[$node];
				$html .= self::treeToHtml($data,$key,$pKey,$node,$rv[$key],$ptag,$tag);
				$html = $html.'</'.$tag.'>';
			}
		}
		return $html ? '<'.$ptag.'>'.$html.'</'.$ptag.'>' : $html;
	}
	
	/**
	 * 格式化日期
	 * @param $t：格式化类型
	 * 1：Y-m-d H:i:s
	 * 2：Y/m/d H:i:s
	 * 3：Y-m-d
	 * 4：Y/m/d
	 * 5：YmdHis
	 * 6：YmdHism
	 * @param $time:时间戳
	 */
	public static function formatDate($t=1,$time='') {
		$d = '';
		switch ($t) {
			case 1 :
				$d = $time ? date('Y-m-d H:i:s',$time) : date('Y-m-d H:i:s');
				break;
			case 2 :
				$d = $time ? date('Y/m/d H:i:s',$time) : date('Y/m/d H:i:s');
				break;
			case 3 :
				$d = $time ? date('Y-m-d',$time) : date('Y-m-d');
				break;
			case 4 :
				$d = $time ? date('Y/m/d',$time) : date('Y/m/d');
				break;
			case 5 :
				$d = $time ? date('YmdHis',$time) : date('YmdHis');
				break;
			case 5 :
				$d = $time ? date('YmdHism',$time) : date('YmdHism');
				break;
			default :
				$d = $time ? date('Y-m-d H:i:s',$time) : date('Y-m-d H:i:s');
		}
		return $d;
	}
	
	/**
	 * 计算时间差(秒数)
	 * @param String $begin_time
	 * @param String $end_time
	 * @return int
	 */
	public static function timediff($begin, $end) {
		$begin = is_int($begin) ? $begin : strtotime($begin);
		$end = is_int($end) ? $end : strtotime($end);
		$timediff = abs($end-$begin);
		return $timediff;
	}
	
	/**
	 * 获取当前时间戳,精确到毫秒
	 * @return number
	 */
	public static function getTimeStamp(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	
	/**
	 * 格式化时间戳,精确到毫秒,x代表毫秒
	 * @param String $format:时间格式,比如:Y-m-d H:i:s
	 * @param String $time:时间戳
	 */
	public static function formatTimeStamp($format, $time) {
		if (strpos($time, '.') !== false) {
			list($usec, $sec) = explode(".", $time);
		}else{
			$usec = substr($time,0,10);
			$sec = str_replace($usec, '', $time);
		}
		$date = date($format,$usec);
		return str_replace('x', $sec, $date);
	}
	
	public static function secToDate($time){
		$date = array(
			'years' => 0, 'days' => 0, 'hours' => 0,
			'minutes' => 0, 'seconds' => 0
		);
		if(is_numeric($time)){
			if($time >= 31556926){
				$date['years'] = floor($time/31556926);
				$time = ($time%31556926);
			}
			if($time >= 86400){
				$date['days'] = floor($time/86400);
				$time = ($time%86400);
			}
			if($time >= 3600){
				$date['hours'] = floor($time/3600);
				$time = ($time%3600);
			}
			if($time >= 60){
				$date['minutes'] = floor($time/60);
				$time = ($time%60);
			}
			$date['seconds'] = floor($time);
		}
		return $date;
	}
	
	public static function substr($str, $start, $length = false, $encoding = 'utf-8'){
		if (is_array($str)){
			return false;
		}
		if (function_exists('mb_substr')){
			return mb_substr($str, (int)($start), ($length === false ? self::strlen($str) : (int)($length)), $encoding);
		}
		return substr($str, $start, ($length === false ? self::strlen($str) : (int)($length)));
	}
	
	public static function strtolower($str){
		if (is_array($str)){
			return false;
		}
		if (function_exists('mb_strtolower')){
			return mb_strtolower($str, 'utf-8');
		}
		return strtolower($str);
	}
	
	public static function strlen($str, $encoding = 'UTF-8'){
		if (is_array($str)){
			return false;
		}
		$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
		if (function_exists('mb_strlen')){
			return mb_strlen($str, $encoding);
		}
		return strlen($str);
	}
	
	public static function stripslashes($string){
		if (_PS_MAGIC_QUOTES_GPC_){
			$string = stripslashes($string);
		}
		return $string;
	}
	
	public static function strtoupper($str){
		if (is_array($str)){
			return false;
		}
		if (function_exists('mb_strtoupper')){
			return mb_strtoupper($str, 'utf-8');
		}
		return strtoupper($str);
	}
	
	public static function getRemoteAddr(){
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND $_SERVER['HTTP_X_FORWARDED_FOR'] AND (!isset($_SERVER['REMOTE_ADDR']) OR preg_match('/^127\..*/i', trim($_SERVER['REMOTE_ADDR'])) OR preg_match('/^172\.16.*/i', trim($_SERVER['REMOTE_ADDR'])) OR preg_match('/^192\.168\.*/i', trim($_SERVER['REMOTE_ADDR'])) OR preg_match('/^10\..*/i', trim($_SERVER['REMOTE_ADDR'])))){
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')){
				$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				return $ips[0];
			}else{
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		return $_SERVER['REMOTE_ADDR'];
	}
	
	public static function jsonDecode($json, $assoc = false) {
		if (function_exists('json_decode')) {
			return json_decode($json, $assoc);
		} else {
			vendor('json.json');
			$pearJson = new Services_JSON(($assoc) ? SERVICES_JSON_LOOSE_TYPE : 0);
			return $pearJson->decode($json);
		}
	}
	
	public static function jsonEncode($data) {
		if (function_exists('json_encode')) {
			return json_encode($data);
		} else {
			vendor('json.json');
			$pearJson = new Services_JSON();
			return $pearJson->encode($data);
		}
	}
	
	/**
	 * 设置输出缓冲的最小字符个数
	 * @param int $size
	 */
	public static function setFlushMin($size = 4096){
		print str_repeat(" ", $size);
	}
	
	/**
	 * 定时输出缓冲区内容
	 * @param String $info:缓冲区内容
	 * @param float $interval:时间间隔,单位秒(支持小数)
	 */
	public static function outFlush($info='',$interval=1){
		@ini_set('output_buffering', 'Off');
		ob_flush();
		flush();
		sleep($interval);
		return $info;
	}
	
	/**
	 * 清空缓冲区
	 */
	public static function cleanFlush(){
		ob_end_flush();
	}
	
	/**
	 * 根据指定的概率精度生成随机结果
	 * @param array:$proArr,形如 array('iphone' => 10,'laptop' => 20,'electric cooker' => 30,'vacuum cup' => 40)
	 * @return String
	 */
	public static function getRandByPro($proArr){
		$result = '';
		//按概率精度排序
		asort($proArr);
		//概率数组的总概率精度
		$proSum = array_sum($proArr);
		//概率数组循环
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset ($proArr);
		return $result;
	}
	
	/**
	 * 随机生成一个UUID串
	 * @param string $connector
	 * @return string
	 */
	public static function randomUUID($connector='-'){
		$uuid = '';
		if (function_exists('com_create_guid')){
			$uuid = com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123) // "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			.chr(125);// "}"
		}
		$uuid = trim($uuid,chr(123).chr(125));
		$uuid = str_replace(array(chr(45)), array($connector), $uuid);
		return $uuid;
	}
	
	/**
	 * 解析url信息
	 * @param String $url
	 * @param String $param
	 * @return object
	 */
	public static function parseUrl($url,$param=''){
		$params = array(
			'1' => PHP_URL_SCHEME,		//协议
			'2' => PHP_URL_HOST,		//域名
			'3' => PHP_URL_PORT,		//端口
			'4' => PHP_URL_USER,		//用户
			'5' => PHP_URL_PASS,		//密码
			'6' => PHP_URL_PATH,		//路径
			'7' => PHP_URL_QUERY,		//参数键值对
			'8' => PHP_URL_FRAGMENT,	//锚
		);
		if ($param && array_key_exists($param, $params)) {
			return parse_url($url,$params[$param]);
		}
		return parse_url($url);
	}
	
	/**
	 * 反序列化
	 * @param string $serial_str
	 * @return object
	 */
	public static function mb_unserialize($serial_str) {
		$serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
		$serial_str = str_replace("\r", "", $serial_str);
		return unserialize($serial_str);
	}
	
	public static function alert($html=''){
		$html = '<script type="text/javascript">alert("'.$html.'");</script>';
		die($html);
	}
	
	/**
	 * 过滤字符串中的html标签
	 * @param string $string
	 * @return string
	 */
	public static function filterHtml($string){
		return strip_tags(self::nl2br2($string));
	}
	
	/**
	 * Convert \n and \r\n and \r to <br />
	 * @param string $string String to transform
	 * @return string New string
	 */
	public static function nl2br2($string) {
		return str_replace(array("\r\n", "\r", "\n"), '<br />', $string);
	}
	
	/**
	 * 创建目录
	 * @param string $dir
	 */
	public static function makeDir($dir){
		if(!is_readable($dir)){
			self::makeDir(dirname($dir));
			if(!is_file($dir)){
				mkdir($dir,0777);
			}
		}
	}
	
	/**
	 * 获取文件信息
	 * @param String $fileName: 文件名,包含路径信息
	 * @param String $sec: 返回的信息类型,1  路径,2 文件名,3 文件后缀,默认返回数组型
	 */
	public static function getFileInfo($fileName,$sec = ''){
		$extend = '';
		$secs = array('1'=>PATHINFO_DIRNAME,'2'=>PATHINFO_BASENAME,'3'=>PATHINFO_EXTENSION);
		if (is_file($fileName)) {
			if($sec == ''){
				return pathinfo($fileName);
			}
			return strtolower(pathinfo($fileName,$secs[$sec]));
		}
	}
	
	/**
	 * 获取服务器操作系统信息,相当于调用了 "s n r v m" 的所有模式
	 */
	public static function showServerInfo(){
		return php_uname('a');
	}
	
	/**
	 * 获取服务器端操作系统名称
	 */
	public static function showOSName(){
		return php_uname('s');
	}
	
	/**
	 * 获取服务器端操作系统的主机名
	 */
	public static function showServerName(){
		return php_uname('n');
	}
	
	/**
	 * 获取服务器端操作系统版本名称
	 */
	public static function showServerVersionName(){
		return php_uname('r');
	}
	
	/**
	 * 获取服务器端操作系统版本号
	 */
	public static function showServerVersion(){
		return php_uname('v');
	}
	
	/**
	 * 获取服务器端操作系统类型
	 */
	public static function showServerType(){
		return php_uname('m');
	}
	
	/**
	 * 获取php运行的软件环境信息,包括:apahce,操作系统,php
	 */
	public static function showServerSoftwareInfo(){
		return $_SERVER['SERVER_SOFTWARE'];
	}
	
	/**
	 * 获取apache版本信息
	 */
	public static function showApacheVersion(){
		return apache_get_version();
	}
	
	/**
	 * 获取php版本号
	 */
	public static function showPhpVersion(){
		return PHP_VERSION;
		//return phpversion();
	}
	
	/**
	 * 获取mysql版本号
	 */
	public static function showMysqlVersion(){
		return mysql_get_server_info();
	}
	
	/**
	 * 获取换行符
	 * @return string
	 */
	public static function getNewLine(){
		return PHP_EOL;
	}
	
	/**
	 * 获取目录分隔符
	 * @return string
	 */
	public static function getDirSep(){
		return DIRECTORY_SEPARATOR;
	}
	
	/**
	 * 获取路径分隔符
	 * @return string
	 */
	public static function getPathSep(){
		return PATH_SEPARATOR;
	}
	
	/**
	 * 获取默认的include_path
	 * @return string
	 */
	public static function getDefaultIncludePath(){
		return DEFAULT_INCLUDE_PATH;
	}
	
	/**
	 * 过滤sql,防注入
	 * @param string $string
	 * @param boolean $htmlOK
	 * @return string
	 */
	public static function filterSQL($string, $htmlOK = false){
		$keyWord = array('and','execute','update','count','chr','mid','master','truncate','char','declare','select','create','delete','insert','\'','"','or','=');
		$string = str_replace($keyWord, '', $string);
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		if (!is_numeric($string)) {
			$string = addslashes($string);
			if (!$htmlOK) {
				$string = strip_tags(self::nl2br2($string));
			}
		}
		return $string;
	}
	
	/**
	 * 字符串编码转换
	 * @param string $string
	 * @param string $encode
	 * @return string
	 */
	public static function convertEncode($string='',$encode='UTF-8'){
		$src_code = self::getStringCode($string);
		if ($src_code != $encode) {
			//return mb_convert_encoding($string,$encode,'UTF-8,GBK,GB2312,ISO-8859-1,ASCII');
			return iconv($src_code,$encode,$string);
		}
		return $string;
	}
	
	/**
	 * 获取指定URL内容
	 * @param string $url
	 * @param boolean $useIncludePath
	 * @param string $streamContext
	 * @param int $curlTimeOut
	 * @return mixed|boolean
	 */
	public static function getFileContents($url, $useIncludePath = false, $streamContext = NULL, $curlTimeOut = 5){
		if ($streamContext == NULL){
			$streamContext = @stream_context_create(array('http' => array('timeout' => 5)));
		}
		if (in_array(ini_get('allow_url_fopen'), array('On', 'on', '1'))){
			return @file_get_contents($url, $useIncludePath, $streamContext);
		}elseif (function_exists('curl_init') && in_array(ini_get('allow_url_fopen'), array('On', 'on', '1'))){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $curlTimeOut);
			curl_setopt($curl, CURLOPT_TIMEOUT, $curlTimeOut);
			$content = curl_exec($curl);
			curl_close($curl);
			return $content;
		}
		return false;
	}
	
	public static function callUserMethod($object,$defaultMethod='',$datas=array()){
		if (is_object($object)) {
			$current_class = get_class($object);
			$current_object = $object;
		}else{
			$current_class = $object;
			$current_object = new $current_class();
		}
		$methodArray = get_class_methods($current_class);
		$flag = true;
		foreach ($methodArray as $method){
			if (isset($_GET[$method]) || isset($_POST[$method])) {
				call_user_func_array(array($current_object,$method),$datas);
				$flag = false;
				break;
			}
		}
		if ($flag) {
			if (method_exists($current_object,$defaultMethod)) {
				call_user_func_array(array($current_object,$defaultMethod),$datas);
			}
		}
	}
	
	/**
	 * 获取指定目录(不包括子目录)下的文件和子目录
	 * @param String $filePath:文件目录
	 * @param boolean $inc_dir:是否包含子目录
	 * @param array $extends:文件后缀,形如array('html','txt')
	 * @return array:文件数组,形如array('文件路径'=>'文件名')
	 */
	public static function getFileList($filePath,$inc_dir = true,$extends = array()){
		$files = array();
		if(is_dir($filePath)){
			$handler = opendir($filePath);
			while (($filename = readdir($handler)) !== false) {
				if ($filename != "." && $filename != "..") {
					$fileFullPath = $filePath.'/'.$filename;
					if (!$inc_dir) {
						if ($extends && is_array($extends) && !empty($extends)) {
							if (in_array(self::getFileInfo($fileFullPath,3),$extends)) {
								if(is_file($fileFullPath)){
									$files[$fileFullPath] = $filename;
								}
							}
						}else{
							if(is_file($fileFullPath)){
								$files[$fileFullPath] = $filename;
							}
						}
					}else{
						if ($extends && is_array($extends) && !empty($extends)) {
							if (in_array(self::getFileInfo($fileFullPath,3),$extends)) {
								if(is_file($fileFullPath)){
									$files[$fileFullPath] = $filename;
								}
							}
						}else{
							$files[$fileFullPath] = $filename;
						}
					}
				}
			}
			closedir($handler);
		}
		return $files;
	}
	
	/**
	 * 获取指定目录(包括子目录)下的所有文件和子目录
	 * @param String $filePath:文件目录
	 * @param boolean $inc_dir:是否包含子目录
	 * @param array $extends:文件后缀,形如array('html','txt')
	 * @return array:文件数组,形如array('文件路径'=>'文件名')
	 */
	public static function getFileLists($filePath,$inc_dir = true,$extends = array()) {
		$all_files = array();
		if(is_dir($filePath)){
			$all_files = array_merge($all_files,self::getFileList($filePath,$inc_dir,$extends));
			if ($inc_dir) {
				$dp = dir($filePath);
				while (@$file = $dp ->read()){
					if($file !="." && $file !=".."){
						self::getFileLists($filePath."/".$file,$inc_dir,$extends);
					}
				}
				$dp ->close();
			}
		}
		if (is_file($filePath)) {
			$all_files[$filePath] = pathinfo($filePath,PATHINFO_BASENAME);
		}
		return $all_files;
	}
	
	/**
	 * 二维数组排序
	 * @param array $arr:二维数组
	 * @param string $key:要排序的键名
	 * @param string $type:排序方式,asc 正序,desc 倒序
	 * @param string $index:是否保留原索引,true 保留,false 重建
	 * @return void|multitype:unknown
	 */
	public static function array_sort($arr,$key,$type='asc',$index=true){
		if (count($arr) == 0) {
			return ;
		}
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$key];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		if($index){
			foreach ($keysvalue as $k=>$v){
				$new_array[$k] = $arr[$k];
			}
		}else{
			foreach ($keysvalue as $k=>$v){
				$new_array[] = $arr[$k];
			}
		}
		return $new_array;
	}
	
	public static function round($str,$prec=2){
		return sprintf('%.'.intval($prec).'f',floatval($str));
	}
	
	/**
	 * 左侧补零
	 * @param string $str
	 * @param int $num
	 */
	public static function fillZero($str,$num=0){
		return sprintf('%0'.$num.'d',$str);
	}
	
	/**
	 * 将数组写入到php文件中
	 * @param string $file:php文件
	 * @param array $array:数组
	 */
	public static function saveArray($file,$array=array()){
		$str = "<?php\n return ".var_export($array, true).";\n?>";
		file_put_contents($file, $str);
	}
	
	/**
	 * 模拟表单提交
	 * @param string $url:目标url
	 * @param array $body:表单参数,数组格式
	 * @param boolean $simple_mode
	 * @param boolean $content_type
	 * @return mixed
	 */
	public static function makeConnection($url, $body, $simple_mode = true, $content_type='') {
		$content_type = $content_type ? $content_type : 'application/x-www-form-urlencoded';
		//尝试fopen连接
		$return = self::connectByFopen($url, $body, $content_type);
		if ($return !== false) {
			return $return;
		}
		
		//尝试curl连接
		$return = self::connectByCURL($url, $body);		
		if ($return !== false) {
			return $return;
		}
		
		//尝试sock连接
		$return = self::connectByFSOCK($url, $body, $simple_mode, $content_type);
		if ($return !== false) {
			return $return;
		}		
		return '';
	}
	
	public static function connectByFopen($url,$data,$content_type){
		if (!in_array(ini_get('allow_url_fopen'), array('On', 'on', '1'))){
			return false;
		}
		$body = http_build_query($data,'','&');
		$streamContext = @stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header'=> "Content-Type: ".$content_type." \r\n" .
						   "Content-Length: ".strlen($body)."\r\n",
				'content' => $body,
				'timeout' => 5
			)
		));
		return file_get_contents($url, false, $streamContext);
	}
	
	public static function connectByCURL($url,$data,$timeout=30,$httpHeader=array()){
		if (!(function_exists('curl_init') && in_array(ini_get('allow_url_fopen'), array('On', 'on', '1')))){
			return false;
		}
		$ch = @curl_init();
		if (!$ch) {			
			return false;
		}
		$body = http_build_query($data);
		@curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_POST, true);
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		@curl_setopt($ch, CURLOPT_HEADER, false);
		if ($httpHeader) {
			@curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
		}
		@curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		@curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		@curl_setopt($ch, CURLOPT_VERBOSE, true);
		$result = @curl_exec($ch);
		@curl_close($ch);
		return $result;
	}
	
	public static function connectByFSOCK($url, $data, $simple_mode=true, $content_type){
		$body = http_build_query($data);
		$fp = @fsockopen('sslv3://'.$url, 443, $errno, $errstr, 4);
		if (!$fp){
			return false;
		}
		$header = self::makeFstockHeader($url, strlen($body), $content_type);
		@fputs($fp, $header.$body);
		$tmp = '';
		while (!feof($fp)){			
			$tmp .= trim(fgets($fp, 1024));
		}
		fclose($fp);
		if (!$simple_mode || !preg_match('/[A-Z]+=/', $tmp, $result)) {
			return $tmp;
		}
		$pos = strpos($tmp, $result[0]);
		$body = substr($tmp, $pos);		
		return $body;
	}
	
	private static function makeFstockHeader($host, $lenght, $content_type){
		$header = 'POST '.strval('/nvp').' HTTP/1.0'."\r\n" .
				'Host: '.strval($host)."\r\n".
				'Content-Type: '.$content_type."\r\n".
				'Content-Length: '.(int)($lenght)."\r\n".
				'Connection: close'."\r\n\r\n";
		return $header;
	}
	
	/**
	 * 删除指定目录下的所有文件
	 * @param string $dir
	 */
	public static function removeFile($dir){
		error_reporting(0);
		$dir_arr = scandir($dir);
		foreach($dir_arr as $key=>$val){
			if($val == '.' || $val == '..'){
				continue;
			}
			if(is_dir($dir.'/'.$val)) {
				self::removeFile($dir.'/'.$val);
				@rmdir($dir.'/'.$val);
			} else {
				@unlink($dir.'/'.$val);
			}
		}
	}
	

	
	/**
	 * 判断两个日期是否连续
	 * @param int $time1:时间戳1
	 * @param int $time2:时间戳2,该参数值应大于第一个参数值
	 * @return boolean
	 */
	public static function isConsecutiveDay($time1,$time2){
		$date1 = getdate($time1);
		$date2 = getdate($time2);
		
		if ($date1['year'] == $date2['year'] && $date2['yday']-$date1['yday'] == 1) {
			return true;
		} elseif ($date2['year']-$date1['year'] == 1 && $date1['mon']-$date2['mon'] == 11 && $date1['mday']-$date2['mday'] == 30) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取流数据
	 * @return string
	 */
	public static function getStreamData(){
		return file_get_contents("php://input");
	}
	
	/**
	 * 判断是否是移动端
	 * @return boolean
	 */
	public static function isMobile(){
		vendor('mobile.MobileDetect');
		$detect = new MobileDetect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if ($deviceType == 'computer') {
			return false;
		}
		return true;
	}
	
	/**
	 * 判断是否是IOS平台
	 * @return boolean
	 */
	public static function isIOS(){
		vendor('mobile.MobileDetect');
		$detect = new MobileDetect;
		$deviceType = $detect->is('iOS') ? true : false;
		return $deviceType;
	}
	
	/**
	 * 判断是否是Android平台
	 * @return Ambigous <boolean, number, NULL, mixed>
	 */
	public static function isAndroid(){
		vendor('mobile.MobileDetect');
		$detect = new MobileDetect;
		$deviceType = $detect->is('AndroidOS') ? true : false;
		return $deviceType;
	}
	
	/**
	 * 截取字符串
	 * @param string $str:待截取的字符串
	 * @param int $length:截取长度
	 * @param int $start:开始截取位置
	 * @param string $suffix:后缀
	 * @param string $charset:编码类型
	 * @return string
	 */
	public static function subString($str, $length, $start=0, $suffix='', $charset='utf-8') {
		$len = array(
			'utf-8' => 3,
			'gbk' => 2
		);
		if (mb_strlen($str,$charset) <= $length) {
			return $str;
		}
		if (function_exists('mb_strcut')) {
			//按字节截取
			//长度转换
			$temp_len = $len[strtolower($charset)];
			$temp_len = $temp_len ? $temp_len : $len['utf-8'];
			$temp_len = $length * $temp_len;
			$result = mb_strcut($str, $start, $temp_len, $charset);
		} elseif (function_exists('mb_substr')) {
			//按字符截取
	    	$result = mb_substr($str, $start, $length, $charset);
	    } elseif (function_exists('iconv_substr')) {
	    	//按字符截取
	    	$result = iconv_substr($str,$start,$length,$charset);
	    } else {
	    	$charArray = array(
    			'utf-8' => '/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/',
    			'gbk' => '/[x01-x7f]|[x81-xfe][x40-xfe]/',
    			'gb2312' => '/[x01-x7f]|[xb0-xf7][xa0-xfe]/',
    			'big5' => '/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/'
	    	);
	    	preg_match_all($charArray[strtolower($charset)], $str, $match);
	    	$result = implode('',array_slice($match[0], $start, $length));
	    }
	    $result = $suffix ? $result.$suffix : $result;
	    return $result;
	}
	
	/**
	 * 统计字符串中中英文和数字的个数
	 * @param string $str
	 * @return array
	 */
	public static function countChar($str=''){
		preg_match_all('/[0-9]{1}/',$str,$numberCount);
		preg_match_all('/[a-zA-Z]{1}/',$str,$lettersCount);
		preg_match_all('/([\x{4e00}-\x{9fa5}]){1}/u',$str,$chinese);
		$result = array(
			'number' => count($numberCount[0]),
			'letters' => count($lettersCount[0]),
			'chinese' => count($chinese[0])
		);
		return $result;
	}
	
	/**
	 * 获取字符串长度
	 * @param string $str
	 * @return number
	 */
	public static function getStringLength($str=''){
		return mb_strlen($str,'utf-8');
	}
	
	/**
	 * 判断是否是一个Url链接
	 * @param string $str
	 * @return boolean
	 */
	public static function isUrl($str=''){
		$rule = '/^(http:|https:)/i';
		$result = preg_match($rule,$str);
		return $result;
	}
	
	/**
	 * 判断资源文件是否存在
	 * @param string $url
	 * @return boolean
	 */
	public static function fileExists($url=''){
		$rule = '/^(http:|https:)/i';
		$result = preg_match($rule,$url);
		if ($result) {
			$header = get_headers($url);
			if(preg_grep('/200/', $header)){
				return true;
			}
			return false;
		}
		if (file_exists($url)) {
			return true;
		}
		return false;
	}
	
	/**
	 * 获取两个字符之间的内容
	 * @param string $content
	 * @param string $start
	 * @param string $end
	 * @return string
	 */
	public static function getSubstrBetween($str,$start,$end){
	    $result = explode($start, $str);
	    if (isset($result[1])){
	        $result = explode($end, $result[1]);
	        return $result[0];
	    }
	    return $str;
	}
	
	/**
	 * 执行外部命令
	 * @param string $cmd
	 * @return array
	 */
	public static function exec($cmd){
		$result = array();
		if (is_file($cmd)) {
			if (!is_executable($cmd)) {
	            @exec('sudo chmod +x '.$cmd);
	        }
		} else {
			if (stripos($cmd, 'sudo ') === false) {
				$cmd = 'sudo '.$cmd;
			}
		}
		if (function_exists('shell_exec')) {
			$result = shell_exec($cmd);
			return $result;
		}
		exec($cmd,$result);
		return $result;
	}
	
	public static function encodeImage($imageStr){
		return base64_encode($imageStr);
	}
	
	public static function decodeImage($imageStr){
		$image = 'data:image/jpg/png/gif;base64,'.$imageStr;
		return $image;
	}
	
	/**
	 * 从字符串中提取数字
	 * @param string $str
	 * @param boolean $all
	 * @return mixed
	 */
	public static function parseNumber($str,$all=false){
		if ($all) {
			preg_match_all('/\d+/',$str,$result);
		} else {
			preg_match('/\d+/',$str,$result);
		}
		return $result[0];
	}
	
	/**
	 * 获取客户端操作系统信息
	 * @return string
	 */
	public static function getOS(){
		$os = '';
		$httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
		if($httpUserAgent){
			if (preg_match('/win/i',$httpUserAgent)) {
				$os = 'Windows';
			} elseif (preg_match('/mac/i',$httpUserAgent)) {
				$os = 'MAC';
			} elseif (preg_match('/linux/i',$httpUserAgent)) {
				$os = 'Linux';
			} elseif (preg_match('/unix/i',$httpUserAgent)) {
				$os = 'Unix';
			} elseif (preg_match('/bsd/i',$httpUserAgent)) {
				$os = 'BSD';
			} else {
				$os = 'Other';
			}
		}
		return $os;
	}
	
	/**
	 * 获取客户端浏览器信息
	 * @return string
	 */
	public static function getBrowser(){
		$browser = '';
		$httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
		if($httpUserAgent){
			if (preg_match('/MSIE/i',$httpUserAgent)) {
				$browser = 'MSIE';
			}elseif (preg_match('/Firefox/i',$httpUserAgent)) {
				$browser = 'Firefox';
			}elseif (preg_match('/Chrome/i',$httpUserAgent)) {
				$browser = 'Chrome';
			}elseif (preg_match('/Safari/i',$httpUserAgent)) {
				$browser = 'Safari';
			}elseif (preg_match('/Opera/i',$httpUserAgent)) {
				$browser = 'Opera';
			}else {
				$browser = 'Other';
			}
		}
		return $browser;
	}
	
	/**
	 * jsonrpc调用
	 * @param string $url:资源地址
	 * @param string $action:方法名称
	 * @param mixed $param:方法参数
	 * @return array
	 */
	public static function callJsonRpc($url,$action,$param=null){
		$result = array('status' => 'success');
		try {
			vendor('jsonRPC.jsonRPCClient');
			$client = new \jsonRPCClient($url);
			$result['data'] = $client->$action($param);
		} catch (\Exception $e) {
			$result['status'] = 'failed';
		}		
		return $result;
	}
}

?>