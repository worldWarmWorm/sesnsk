<?php
/**
 * Базовый класс для виджетов слайдера
 * @author kontur
 *
 */
namespace extend\modules\slider\components\base;

use common\components\helpers\HYii as Y;
use common\components\helpers\HArray as A;
use common\components\helpers\HFile;
use common\components\helpers\HCache;
use common\components\helpers\HModel;
use common\components\helpers\HTools;
use extend\modules\slider\models\Slider;

class SliderWidget extends \common\components\base\Widget
{
	/**
	 * @var string символьный код слайдера. 
	 */
	public $code;
	
	/**
	 * @var string имя контейнера слайдера. Если не задано, будет сгенерирован.
	 * По умолчанию (NULL) - не задано.
	 */
	public $container=null;
	
	/**
	 * @var string имя категории сортировки слайдов.
	 * По умолчанию "slider_slides".
	 */
	public $sort='slider_slides';
	
	/**
	 * @var string|NULL|FALSE ключ сортировки слайдов.
	 * По умолчанию (NULL) в качестве ключа будет использован 
	 * идентификатор слайдера.
	 * Если будет передано FALSE, ключ использован не будет. 
	 */
	public $sortKey=null;
	
	/**
	 * (non-PHPdoc)
	 * @see \common\components\base\Widget::$tagOptions
	 */
	public $tagOptions=['class'=>'slider'];
	
	/**
	 * @var string имя тэга списка элементов. По умолчанию "ul".
	 */
	public $itemsTagName='ul';
	
	/**
	 * @var string имя тэга элемента списка. По умолчанию "li".
	 */
	public $itemTagName='li';
	
	/**
	 * @var array атрибуты для тэга элемента списка. По умолчанию пустой массив.
	 */
	public $itemOptions=[];	
	
	/**
	 * @var boolean подключать js библиотеки слайдера.
	 * По умолчанию (TRUE) - подключать.
	 */
	public $jsLoad=true;
	
	/**
	 * @var boolean инициализировать слайдер. 
	 * По умолчанию (TRUE) - инициализировать.
	 */
	public $jsInit=true;
	
	/**
	 * @var string|boolean файл стилей. Может быть передано (FALSE), либо пустое значение, 
	 * в этом случае, стили подключены не будут. 
	 */
	public $cssFile=false;
	
	/**
	 * @var array|string массив конфигурации для инициализации плагина слайдера, 
	 * либо алиас пути к конфигурации слайдера. 
	 * Либо может быть передан одно значение в массиве, вида array("options_default_name"),
	 * где "options_default_name" - имя файла настроек виджета.
	 * Файлы настроек находятся extend.modules.slider.widgets.configs.lowerCamelCaseSliderWidgetShortClassName.*
	 * Доступны следующие настройки:
	 * "default" - настройки по умолчанию
	 */
	public $options=false;
	
	/**
	 * @var boolean использовать кэширование.
	 */
	public $cache=true;
	
	/**
	 * @var integer время кэширования в секундах. 
	 * По умолчанию 60 секунд.
	 */
	public $cacheTime=HCache::MINUTE;

	/**
	 * @var string имя шаблона представления по умолчанию.
	 */
	public $defaultView=false;
	
	/**
	 * @var \extend\modules\slider\models\Slider модель слайдера.
	 */
	protected $slider;
	
	/**
	 * @var array[\extend\modules\slider\models\Slide] массив моделей слайдов.
	 */
	protected $slides=[];
	
	/**
	 * (non-PHPdoc)
	 * @see CWidget::init()
	 */
	public function init()
	{
		if(!$this->getSlider()) {
			return false;
		}
		
		if(is_string($this->options)) {
			$this->options=HFile::includeByAlias($this->options, []);
		}
		elseif(count($this->options) == 1) {
			$folder=HTools::getShortClassName(get_called_class(), true);
			$configName=reset($this->options);
			$config=HFile::includeByAlias(
				"extend.modules.slider.widgets.configs.{$folder}.{$configName}", 
				[], 
				['widget'=>$this]
			);
			$this->options=A::get($config, 'options', []);
			if(!$this->view) {
				$this->view=A::get($config, 'view', $this->view);
			}
		}
		
		if(!$this->container) {
			$this->container='slider_'.$this->code;
		}
		
		if(!A::exists('id', $this->htmlOptions)) {
			$this->htmlOptions['id']=$this->container;
		}
		
		if(!$this->view) {
			$this->view=$this->defaultView;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \common\components\base\Widget::run()
	 */
	public function run()
	{
		if(!$this->getSlider() || !$this->getSlides()) {
			return false;
		}
				
		if($this->cache) {
			if(!($content=Y::cache()->get($this->getCacheId()))) {
				$content=$this->render($this->view, $this->params, true);
				Y::cache()->set($this->getCacheId(), $content, $this->cacheTime);
			}
			echo $content;
		}
		else {
			$this->render($this->view, $this->params);
		}
	}
	
	/**
	 * Получить модель слайдера.
	 * @return \extend\modules\slider\models\Slider
	 */
	public function getSlider()
	{
		if(!$this->slider) {
			$this->slider=HModel::loadByColumn(
				'\extend\modules\slider\models\Slider', 
				['code'=>$this->code], 
				['scopes'=>['activly', 'utcache'=>HCache::YEAR]]
			);
		}
		
		return $this->slider;
	}
	
	/**
	 * Получить слайды модели слайдера.
	 * @return array
	 */
	public function getSlides()
	{
		if(!$this->slides && $this->getSlider()) {
			if($this->sortKey === false) $this->sortKey=null;
			elseif($this->sortKey === null) $this->sortKey=$this->getSlider()->id;
			
			$this->slides=$this->getSlider()->slides([
				'scopes'=>[
					'scopeSort'=>[$this->sort, $this->sortKey, false, 'slides'], 
					'utcache'=>[HCache::YEAR, ['condition'=>'slider_id=:id', 'params'=>[':id'=>$this->getSlider()->id]]]
				]
			]);
		}
		
		return $this->slides;
	}
	
	/**
	 * Получить ширину изображения слайдера.
	 * @return number
	 */
	public function getWidth()
	{
		return (int)$this->slider->optionsBehavior->find('code', 'width', ['returnValue'=>'value']) ?: Slider::WIDTH;
	}
	
	/**
	 * Получить высоту изображения слайдера.
	 * @return number
	 */
	public function getHeight()
	{
		return (int)$this->slider->optionsBehavior->find('code', 'height', ['returnValue'=>'value']) ?: Slider::HEIGHT;
	}
	
	/**
	 * Получить значение пропорционального преобразования изображения слайдера.
	 * @return boolean
	 */
	public function getProportional()
	{
		return in_array($this->slider->optionsBehavior->find('code', 'proportional', ['returnValue'=>'value']), [null, 'yes', 1]);
	}
	
	/**
	 * Получить идентификатор кэша.
	 */
	protected function getCacheId()
	{
		return $this->container . $this->code;
	}
}