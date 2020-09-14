Инструкция по установке и использованию модуля
----------------------------------------------------------------------------
Содержание:
I. УСТАНОВКА
II. ИСПОЛЬЗОВАНИЕ

----------------------------------------------------------------------------
I. УСТАНОВКА
----------------------------------------------------------------------------
1) Добавить в основную конфигурацию protected\config\crud.php
return [
	...
	'application.modules.extend.modules.slider.config.crud.main_static'
];

main_static - с учетом прав доступа. Администратор может добавлять и редактировать слайдеры, 
менеджер может только управлять слайдами и активностью слайдеров.

main - полный доступ.

2) Добавьте пункт меню, при необходимости в раздел администрирования
protected\modules\admin\config\menu.php
use crud\components\helpers\HCrud;
...
	'modules'=>[
		HCrud::getMenuItems(Y::controller(), 'slider', 'crud/index', true)


----------------------------------------------------------------------------
II. ИСПОЛЬЗОВАНИЕ
----------------------------------------------------------------------------
Пример 1.

<? $this->widget('\extend\modules\slider\widgets\BxSlider', [
    'code'=>'index_top',
    'container'=>'slides',
    'tagOptions'=>['class'=>'slides'],
    'htmlOptions'=>['id'=>'slider'],
    'options'=>['slider'],
    'view'=>'bx_slider_top',
    'params'=>['enableInfo'=>true, 'infoLinkOptions'=>['class'=>'slide-green-button']]
]); ?>
