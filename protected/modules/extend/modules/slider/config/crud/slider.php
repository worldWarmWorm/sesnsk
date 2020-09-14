<?php
/**
 * Файл настроек модели \slider\models\Slider
 */
use common\components\helpers\HYii as Y;
use extend\modules\slider\models\Slider;

$t=Y::ct('\extend\modules\slider\SliderModule.crud', 'extend.slider');
return [
	'class'=>'\extend\modules\slider\models\Slider',
	'menu'=>[
		'backend'=>['label'=>$t('slider.backend.menu.item.label')]
	],
	'buttons'=>[
		'create'=>['label'=>$t('slider.button.create')]
	],	
	'crud'=>[		
		'index'=>[
			'url'=>'/cp/crud/index',
			'title'=>$t('slider.page.index.title'),
			'gridView'=>[ 
				'dataProvider'=>[
					'criteria'=>[
						'select'=>'`t`.`id`, `t`.`code`, `t`.`title`, `t`.`active`, `t`.`description`, `t`.`options`'
					]
				],
				'sortable'=>[
                    'url'=>'/cp/crud/sortableSave',
                    'category'=>'slider_sliders'
                ],
				'columns'=>[
					'id'=>[
						'name'=>'id',
						'header'=>'#',
						'headerHtmlOptions'=>['style'=>'width:5%;text-align:center'],
					],
					'code'=>[
						'name'=>'code',
						'headerHtmlOptions'=>['style'=>'width:5%'],
					],
					'title'=>[
						'name'=>'title',
						'header'=>$t('slider.crud.index.gridView.columns.title.header'),
						'type'=>'raw',
						'value'=>'"<strong>".CHtml::link($data->title,["/cp/crud/index", "cid"=>"slide", "slider"=>$data->id])."</strong><small>"'
 							. '. ("<br/><span>'. $t('slider.label.options.type').':</span> ".(($i=$data->optionsBehavior->find("code","type"))?(($v=$i["value"])?$v:"slider"):"slider"))'
 							. '. ("<br/><span>'. $t('slider.label.options.width').':</span> ".(($i=$data->optionsBehavior->find("code","width"))?(($w=$i["value"])?$w."px":"'.$t('emptyValue').'"):"<span class=\'label label-danger\'><i class=\'glyphicon glyphicon-exclamation-sign\'></i> '.$t('emptyValue').'</span>"))'
 							. '. ("<br/><span>'. $t('slider.label.options.height').':</span> ".(($i=$data->optionsBehavior->find("code","height"))?(($h=$i["value"])?$h."px":"'.$t('emptyValue').'"):"<span class=\'label label-danger\'><i class=\'glyphicon glyphicon-exclamation-sign\'></i> '.$t('emptyValue').'</span>"))'
 							. '. ("<br/><span>'. $t('slider.label.options.proportional').':</span> ".(($i=$data->optionsBehavior->find("code","proportional"))?$i["value"]:"yes")."</span>")'
 							. '. ("<br/>".($data->description?\common\components\helpers\HHtml::intro($data->description,100):""))'
							. '. "</small>"'
					],
 					'active'=>[
 						'name'=>'active',
 						'header'=>$t('slider.crud.index.gridView.columns.active.header'),
 						'type'=>[
 							'common.ext.active'=>[
 								'behaviorName'=>'activeBehavior',
 							] 
						],
 						'headerHtmlOptions'=>['style'=>'width:15%']
 					],
					'crud.buttons'=>[
						'type'=>'crud.buttons',
						'params'=>[
							'template'=>'{edit_slides}&nbsp;&nbsp;{update}{delete}',
							'buttons'=>[
								'edit_slides' => [
									'label'=>'<span class="glyphicon glyphicon-picture"></span>',
									'url'=>'\Yii::app()->createUrl("/cp/crud/index", ["cid"=>"slide", "slider"=>$data->id])',
									'options'=>['title'=>$t('slider.crud.index.gridView.columns.buttons.slides')],
								],
							],
							'headerHtmlOptions'=>['style'=>'width:10%']
						]
					]					
				]
			]
		],
		'create'=>[
			'url'=>'/cp/crud/create',
			'title'=>$t('slider.page.create.title')
		],
		'update'=>[
			'url'=>'/cp/crud/update',
			'title'=>$t('slider.page.update.title')
		],
		'delete'=>[
			'url'=>'/cp/crud/delete'
		],
		'tabs'=>[
			'main'=>[
				'title'=>$t('slider.tabs.main.title'),
				'attributes'=>[
					'active'=>'checkbox',
					'title',
					'code'=>['type'=>'text', 'params'=>[
						'htmlOptions'=>['class'=>'form-control w100']
					]],
					'description'=>['type'=>'tinyMce', 'params'=>['full'=>false]],
				]
			],
			'options'=>[
				'title'=>$t('slider.tabs.options.title'),
				'attributes'=>[
					'options'=>[
						'type'=>'common.ext.data',
						'behaviorName'=>'optionsBehavior',
						'params'=>[
							'wrapperOptions'=>['style'=>'width:50% !important'],
							'header'=>[
								'code'=>['title'=>$t('slider.options.code.title'), 'htmlOptions'=>['style'=>'width:15%']],
								'title'=>['title'=>$t('slider.options.title.title'), 'htmlOptions'=>['style'=>'width:35%']], 
								'value'=>$t('slider.options.value.title'),
								'unit'=>['title'=>$t('slider.options.unit.title')?'':'', 'htmlOptions'=>['style'=>'width:10%']]
							],
							'types'=>['code'=>'default', 'title'=>'default', 'unit'=>'default'],
							'defaultActive'=>true,
							'readOnly'=>['code', 'title', 'unit'],
							'hideActive'=>true,
							'hideAddButton'=>true,
							'hideDeleteButton'=>true,
							'enableSortable'=>false,
							'refreshDefault'=>'code',
							'notes'=>[
								//['title'=>$t('slider.label.options.type.note')], [], [],
								[], [], [],
								['title'=>$t('slider.label.options.proportional.note')]	
							],
							'default'=>[
								['code'=>'type', 'title'=>$t('slider.label.options.type'), 'value'=>'slider'],
								['code'=>'width', 'title'=>$t('slider.label.options.width'), 'value'=>Slider::WIDTH, 'unit'=>'px'],
								['code'=>'height', 'title'=>$t('slider.label.options.height'), 'value'=>Slider::HEIGHT, 'unit'=>'px'],
								['code'=>'proportional', 'title'=>$t('slider.label.options.proportional'), 'value'=>'yes']
							],
						]
					],
					'slide_properties'=>[
						'type'=>'common.ext.data',
						'behaviorName'=>'slidePropertiesBehavior',
						'params'=>[
							'header'=>[
								'code'=>[
									'title'=>$t('slider.slideProperties.code.title'), 
									'htmlOptions'=>['style'=>'width:15%']
								],
								'title'=>[
									'title'=>$t('slider.slideProperties.title.title'), 
									'htmlOptions'=>['style'=>'width:20%']
								], 
								'default'=>$t('slider.slideProperties.default.title'),
								'note'=>$t('slider.slideProperties.note.title'),
								'unit'=>[
									'title'=>$t('slider.slideProperties.unit.title'), 
									'htmlOptions'=>['style'=>'width:5%;font-size:0.7em;text-align:center']
								]
							],
							'types'=>[
								'title'=>['type'=>'text', 'params'=>['htmlOptions'=>['style'=>'min-height:50px']]],									
								'default'=>['type'=>'text', 'params'=>['htmlOptions'=>['style'=>'min-height:50px']]],
								'note'=>['type'=>'text', 'params'=>['htmlOptions'=>['style'=>'min-height:50px;font-size:0.8em;']]],
							],
							'defaultActive'=>true,
							'default'=>[
								['code'=>'', 'title'=>'', 'default'=>'', 'note'=>'', 'unit'=>'']
							]
						]
					]
				]
			]
		]
	]
];
