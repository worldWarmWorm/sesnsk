<?php
/**
 * Конфигурация для OwlCarousel.
 * "По умолчанию"
 * 
 * @var \extend\modules\slider\widgets\OwlCarousel $widget  
 */

return [
	'view'=>'owl_default',
	'options'=>[
		'loop'=>true,                  //Зацикливаем слайдер
        'nav'=>true,                  //Отключил кнопки Вперед и Назад
        'dots'=>true,                  //Точки навигации
        'responsiveClass'=>true,
        'mouseDrag'=>false,
        'items'=>1,                    //Сколько показываьб слайдов
        'autoplay'=>false,             //Автозапуск слайдера
        'smartSpeed'=>1000,            //Время движения слайда
        'autoplayTimeout'=>5000,       //Время смены слайда
        'autoplayHoverPause'=>true,    //Пауза при навидении мыши
	]
];