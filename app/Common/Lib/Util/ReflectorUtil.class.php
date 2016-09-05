<?php

class ReflectorUtil {
	
	private static $reflect = null;
	private static $reflectInstance = null;
	
	/**
	 * 动态执行类中的方法
	 * @param object $object:类的实例或类本身
	 * @param string $defaultMethod:默认方法
	 * @param array $data:方法参数
	 */
	public static function executeDynamic($object,$defaultMethod='',$data=array()){
		$flag = true;
		self::initReflect($object);
		$methodArray = self::$reflect->getMethods();
		foreach ($methodArray as $method){
			$methodName = $method->name;
			if (isset($_GET[$methodName]) || isset($_POST[$methodName])) {
				self::$reflectInstance->$methodName(implode(',',$data));
				$flag = false;
				break;
			}
		}
		if ($flag && self::$reflect->hasMethod($defaultMethod)) {
			self::$reflectInstance->$defaultMethod(implode(',',$data));
		}
	}
	
	/**
	 * 初始化反射类
	 * @param object $object:类的实例或类本身
	 */
	private static function initReflect($object){
		if (is_object($object)) {
			self::$reflect = new ReflectionObject($object);
		}else{
			self::$reflect = new ReflectionClass($object);
		}
		self::$reflectInstance = self::$reflect->newInstance();
	}
	
	/**
	 * 获取类注释
	 * @param object $object:类的实例或类本身
	 * @return string
	 */
	public static function getClassDocComment($object){
		self::initReflect($object);
		return self::$reflect->getDocComment();
	}
	
	/**
	 * 获取类中的方法
	 * @param object $object:类的实例或类本身
	 * @return object
	 */
	public static function getMethods($object){
		self::initReflect($object);
		$methods = self::$reflect->getMethods();
		$result = array();
		foreach ($methods as $method) {
			$modifiers = Reflection::getModifierNames($method->getModifiers());
			$method->modifier = $modifiers[0];
			$method->parameters = $method->getParameters();
			$method->doccomment = $method->getDocComment();
			$result[] = $method;
		}
		return $result;
	}
	
	/**
	 *  获取类中的成员属性
	 * @param object $object:类的实例或类本身
	 * @return object
	 */
	public static function getProperties($object){
		self::initReflect($object);
		$properties = self::$reflect->getProperties();
		$result = array();
		foreach ($properties as $property) {
			$modifiers = Reflection::getModifierNames($property->getModifiers());
			$property->modifier = $modifiers[0];
			$property->doccomment = $property->getDocComment();
			$result[] = $property;
		}
		return $result;
	}
	
	/**
	 * 获取类中的常量
	 * @param object $object:类的实例或类本身
	 * @return object
	 */
	public static function getConstants($object){
		self::initReflect($object);
		$constants = self::$reflect->getConstants();
		return $constants;
	}
	
	/**
	 * 获取类的文件名称,包括路径信息
	 * @param object $object:类的实例或类本身
	 * @return string
	 */
	public static function getFileName($object){
		self::initReflect($object);
		return self::$reflect->getFileName();
	}
	
	/**
	 * 获取父类
	 * @param object $object:类的实例或类本身
	 * @return object
	 */
	public static function getParentClass($object){
		self::initReflect($object);
		return self::$reflect->getParentClass();
	}
	
	public static function export($object){
		self::initReflect($object);
		return Reflection::export(self::$reflect,true);
	}
	
	/**
	 * 获取类信息
	 * @param object $object:类的实例或类本身
	 * @return array
	 */
	public static function getClassInfo($object){
		$result = array();
		self::initReflect($object);
		$result['fileName'] = self::getFileName($object);
		$result['classDocComment'] = self::getClassDocComment($object);
		$result['parentClass'] = self::getParentClass($object);
		$result['method'] = self::getMethods($object);
		$result['property'] = self::getProperties($object);
		$result['constant'] = self::getConstants($object);
		return $result;
	}
}

?>