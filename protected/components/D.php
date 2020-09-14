<?php
/**
 * Набор полезных функций
 */
class D
{
	/**
	 * Получить компонент d
	 * @return DApi
	 */
	public static function yd()
	{
		return \Yii::app()->d;
	}
	
	/**
	 * Результат условия.
	 * @param boolean $if результат условия.
	 * @param string $then значение на вывод при результате условия TRUE.
	 * @param string|null $else значение на вывод при результате условия FALSE.
	 * По умолчанию пустая строка.
	 * @return null|string
	 */
	public static function c($if, $then, $else=null)
	{
		return $if ? $then : $else;
	}
	
	/**
	 * Проверяет роль пользователя
	 * @param string $role роль пользователя.
	 * @return bool
	 */
	public static function role($role)
	{
		// return (\Yii::app()->user->role === $role);
		if($role == 'admin' && Yii::app()->user->getState('role') == 'sadmin') return true;
		
		return (Yii::app()->user->getState('role') === $role);
	}
	
	/**
	 * Получить значение переменной из настроек CMS
	 * @param string $param имя параметра.
	 * @param mixed $default значение параметра по умолчанию.
	 * @return mixed
	 */
	public static function cms($param, $default=null, $strict=false)
	{
        $value=\Yii::app()->settings->get('cms_settings', $param);
        if(!$value && $strict) {
            return ($value === null) ? $default : $value;
        }
		return $value ?: $default;
	}
	
	/**
	 * Проверка значения из значений параметров CMS
	 * @param string $param имя параметра.
	 * @param mixed|NULL $value проверяемое значение параметра. По умолчанию (NULL) будет 
	 * возвращено преобразование значения параметра в тип BOOLEAN. 
	 * @param boolean $default результат возвращаемый по умолчанию, если параметр не найден.
	 * По умолчанию FALSE.
	 * @param boolean $strict строгая проверка типа. По умолчанию (FALSE) - не строгая.
	 * @return bool
	 */
	public static function cmsIs($param, $value=null, $default=false, $strict=false)
	{
		$paramValue=self::cms($param);
		return ($paramValue === null) 
			? $default 
			: (($value === null) ? (bool)$paramValue : ($strict ? ($paramValue === $value) : ($paramValue == $value)));	
	}

	/**
	 * Получить путь к файлу из настроек CMS
	 * @param string $param имя параметра.
	 * @param null|string $default
	 * @return null|string
	 */
	public static function cmsFile($param, $default=null)
	{
		$uploadPath = \Yii::app()->params['uploadSettingsPath'];
		$filename = static::cms($param);
		
		return $filename? ($uploadPath . $filename) : $default;	
	}
	
	/**
	 * Получить значение переменной из настроек CMS
	 * @param string $param
	 * @param null|mixed $default
	 * @return null|mixed
	 */
	public static function shop($param, $default = null)
	{
		return \Yii::app()->settings->get('shop_settings', $param) ?: $default;
	}
}
