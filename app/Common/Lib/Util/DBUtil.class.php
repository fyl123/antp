<?php
namespace Common\Lib\Util;
class DBUtil {
	/**
	 * 获取查询数据集
	 * @param object $obj:模型对象
	 * @param mixed $where:查询条件
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @param string $field:要查询的字段
	 * @param string $orderby:排序参数
	 * @param int $pageSize:每页记录数
	 * @param int $p:当前页
	 * @param int $limit
	 * @param string $group 分组
	 * @return array
	 */
	public static function queryList($obj,$where=null,$relation=false,$field='',$orderby='',$pageSize=0,$p=0,$limit=0,$group=''){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		
		if (!empty($field)) {
			$obj = $obj->field($field);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		if (!empty($orderby)) {
			$obj = $obj->order($orderby);
		}
		if ($pageSize) {
			$obj = $obj->page(($p?$p:I('p',1)),(int)$pageSize);
		}
		if (!empty($limit)) {
			$obj = $obj->limit((int)$limit);
		}
		if (!empty($group)) {
			$obj = $obj->group($group);
		}
		$result = $obj->select();
		return $obj->parseFieldsMap($result);
	}
	
	/**
	 * 获取查询的单行数据
	 * @param object $obj:模型对象
	 * @param mixed $where:查询条件
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @param string $field:要查询的字段
	 * @return array
	 */
	public static function queryRow($obj,$where='',$relation=false,$field=''){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		$result = $obj->find();
		return $obj->parseFieldsMap($result);
	}
	
	/**
	 * 获取单个字段的值
	 * @param object $obj:模型对象
	 * @param string $field:要查询的字段
	 * @param mixed $where:查询条件
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * return mixed
	 */
	public static function queryField($obj,$field,$where='',$relation=false){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		return $obj->getField($field);
	}
	
	/**
	 * 获取表中某个字段的最大值+1
	 * @param object $obj:模型对象
	 * @param string $key:表中字段
	 * @param int $default:默认值
	 * @return string
	 */
	public static function getMaxKey($obj,$key,$default=0){
		$maxKey = $obj->max($key);
		$maxKey = $maxKey ? $maxKey+1 : $default;
		return $maxKey;
	}
	
	/**
	 * 统计记录总数
	 * @param object $obj
	 * @param mixed $where
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @return number
	 */
	public static function count($obj,$where='',$relation=false){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		$count = $obj->count();
		$count = $count ? $count : 0;
		return $count;
	}
	
	/**
	 * 统计某个字段的数据总和
	 * @param object $obj
	 * @param string $field
	 * @param mixed $where
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @return float
	 */
	public static function sum($obj,$field,$where='',$relation=false){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		$totals = $obj->sum($field);
		$totals = $totals ? $totals : 0;
		return $totals;
	}
	
	/**
	 * 统计某个字段的平均值
	 * @param object $obj
	 * @param string $field
	 * @param mixed $where
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @return float
	 */
	public static function avg($obj,$field,$where='',$relation=false){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		$avg = $obj->avg($field);
		$avg = $avg ? $avg : 0;
		return $avg;
	}
	
	/**
	 * 统计某个字段的最大值
	 * @param object $obj
	 * @param string $field
	 * @param mixed $where
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @return float
	 */
	public static function max($obj,$field,$where='',$relation=false){
		if ($relation) {
			$obj = $obj->relation($relation);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		$max = $obj->max($field);
		$max = $max ? $max : 0;
		return $max;
	} 
	
	/**
	 * 统计某个字段的最小值
	 * @param object $obj
	 * @param string $field
	 * @param mixed $where
	 * @param string|boolean $relation:关联名称,全部关联时为true,没有关联时为false
	 * @return float
	 */
	public static function min($obj,$field,$where='',$relation=false){
		if ($relation) {
			$obj = $obj->relation(true);
		}
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		$min = $obj->min($field);
		$min = $min ? $min : 0;
		return $min;
	}
	
	/**
	 * 新增数据
	 * @param object $obj:模型对象
	 * @param mixed $data:数据
	 * @return mixed
	 */
	public static function add($obj,$data){
		if ($obj->create($data)) {
			return $obj->add();
		}
		return false;
	}
	
	public static function addAll($obj,$data){
		return $obj->addAll($data);
	}
	
	/**
	 * 修改数据
	 * @param object $obj:模型对象
	 * @param mixed $where:修改条件
	 * @param mixed $data:数据
	 * @return
	 */
	public static function save($obj,$where,$data){
		if ($obj->create($data)) {
			return $obj->where(is_string($where) ? array($where) : $where)->save();
		}
		return false;
	}
	
	/**
	 * 删除数据
	 * @param object $obj:模型对象
	 * @param mixed $where:删除条件
	 * @param string $orderby
	 * @param int $limit
	 * @return
	 */
	public static function delete($obj,$where='',$orderby='',$limit=0){
		if (!empty($where)) {
			$obj = $obj->where(is_string($where) ? array($where) : $where);
		}
		if (!empty($orderby)) {
			$obj = $obj->order($orderby);
		}
		if (!empty($limit)) {
			$obj = $obj->limit((int)$limit);
		}
		return $obj->delete();
	}
	
	/**
	 * 按原生sql查询
	 * @param string $sql
	 * @return mixed
	 */
	public static function query($sql){
		return M()->query($sql);
	}
	
	/**
	 * 按原生sql执行CURD
	 * @param string $sql
	 * @return mixed
	 */
	public static function execute($sql){
		return M()->execute($sql);
	}
	
	/**
	 * 中文字段排序
	 * @param string $sortField
	 * @return string
	 */
	public static function sortBy($sortField=''){
		if (empty($sortField)) {
			return $sortField;
		}
		$sortField = 'convert('.$sortField.' using gbk)';
		return $sortField;
	}
	
	/**
	 * 根据经纬度计算距离
	 * @param string $lng:经度字段
	 * @param string $lat:纬度字段
	 * @param array $lng_lat_value:经纬度值
	 * @param string $field:字段别名
	 * @return array
	 */
	public static function buildDistanceField($lng,$lat,$lng_lat_value=array(),$field='distance'){
		$lngValue = $lng_lat_value['lng'] ? $lng_lat_value['lng'] : 0;
		$latValue = $lng_lat_value['lat'] ? $lng_lat_value['lat'] : 0;
		$result = array(
			'fieldName' => $field,
			'fieldStr' => '(6378.138 * 2 * asin(sqrt(pow(sin(('.$lat.' * pi() / 180 - '.$latValue.' * pi() / 180) / 2),2) + cos('.$lat.' * pi() / 180) * cos('.$latValue.' * pi() / 180) * pow(sin(('.$lng.' * pi() / 180 - '.$lngValue.' * pi() / 180) / 2),2))) * 1000) as '.$field
		);
		return $result;
	}
}

?>