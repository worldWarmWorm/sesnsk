<?php
use common\components\helpers\HYii as Y;
use common\components\helpers\HArray as A;

class ShopNewController extends AdminController
{
	/**
	 * (non-PHPdoc)
	 * @see \CController::actions()
	 */
	public function actions()
	{
		return \CMap::mergeArray(parent::actions(), [
			'saveCarouselSort'=>[
				'class'=>'\common\ext\sort\actions\SaveAction',
				'categories'=>['product_carousel_new']
			],	
			'saveProductSort'=>[
				'class'=>'\common\ext\sort\actions\SaveAction',
				'categories'=>['shop_category_new']
			],
			'migrate'=>[
				'class'=>'\ext\shopmigrate\actions\YmlMigrateAction'
			],
			'removeCategoryMainImage'=>[
				'class'=>'\common\ext\file\actions\RemoveFileAction',
				'modelName'=>'\CategoryNew',
				'behaviorName'=>'mainImageBehavior',
				'ajaxMode'=>true
			],
			'removeProductMainImage'=>[
				'class'=>'\common\ext\file\actions\RemoveFileAction',
				'modelName'=>'\ProductNew',
				'behaviorName'=>'mainImageBehavior',
				'ajaxMode'=>true
			],
			'productMassiveControl'=>'\admin\actions\ShopProductMassiveControlAction'
		]);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see AdminController::filters()
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(), array(
			array('DModuleFilter', 'name'=>'shop'),
			'ajaxOnly +removeRelatedCategory'
		));
	}
	
    public function actionIndex()
    {
        $categories = $this->getCategories();
        $products   = ProductNew::model()->onShopIndex()->scopeSort('shop_category_new')->findAll();
        $this->render('index', compact('categories', 'products'));
    }

    public function actionOrderFields () {
	    $model = new \DOrder\models\OrderCustomerFields();

        if (isset($_POST['DOrder_models_OrderCustomerFields'])) {
            $model->attributes = $_POST['DOrder_models_OrderCustomerFields'];
            if ($model->save()) {
                Y::setFlash(Y::FLASH_SYSTEM_SUCCESS, Yii::t('AdminModule.shop', 'success.orderFieldAdd', []));
                $this->redirect(['orderFields']);
            }
        }

	    $criteria = new CDbCriteria();
        $criteria->order = 'sort ASC';
	    $fields = $model->findAll($criteria);
        $this->render('order_field', compact('model', 'fields'));
    }

    public function actionOrderFieldDelete () {
        $id = \Yii::app()->request->getPost('id');
        \DOrder\models\OrderCustomerFields::model()->deleteByPk($id);

        echo \CJSON::encode(array('id'=>$id));

        \Yii::app()->end();
    }

    public function actionOrderFieldModify () {
        $id = \Yii::app()->request->getPost('id');
        $model = \DOrder\models\OrderCustomerFields::model()->findByPk($id);

        if (isset($_POST['DOrder_models_OrderCustomerFields'])) {
            $model->attributes = $_POST['DOrder_models_OrderCustomerFields'];
            if ($model->save()) {
                echo \CJSON::encode(array(
                    'id'=>$id,
                    'result' => 'success',
                    'content' => '<td class="data_column">' . $model->name . '</td>'
                    . '<td class="data_column">' . $model->label . '</td>'
                    . '<td class="data_column">' . $model->type . '</td>'
                    . '<td class="data_column">' . ($model->required ? 'да' : 'нет') . '</td>'
                    . '<td class="data_column">' . $model->sort . '</td>'
                ));
                \Yii::app()->end();
            }
        }
        echo \CJSON::encode(array(
            'id'=>$id,
            'content' => $this->renderPartial('order_field_modify',  compact('model'), true, true)
        ));

        \Yii::app()->end();
    }


    public function actionCategory($id)
    {
    	// @var boolean $modeRelatedHidden режим без отображения привязанных товаров
		$modeRelatedHidden=(bool)\Yii::app()->request->getQuery('hide_related', A::get($_COOKIE, 'adm_sw_hide_rel_prods', false));
		setcookie('adm_sw_hide_rel_prods', $modeRelatedHidden ? 1 : 0, 0, '/');

        $categories = $this->getCategories($id);
        $breadcrumbs = $this->getBreadcrumbs($id);

        $model = $this->loadCategory($id);
        
        if(!$model)
            throw new CHttpException(404, "Not found");

        $product=new ProductNew;
        $productDataProvider=$product->with('productAttributes')->cardColumns()->search(D::cms('shop_product_page_size', 12));
        
        $this->render('category', compact('model', 'categories', 'breadcrumbs', 'id', 'productDataProvider', 'modeRelatedHidden'));
    }

    public function actionRemoveRelatedCategory()
    {
        $data = Yii::app()->request->getPost('data');

        if($data){
            RelatedCategory::model()->deleteAll(array('condition'=>'category_id = ' . $data['related'] . ' AND product_id = ' . $data['product']));
        }

        Yii::app()->end();
    }

    public function actionCategorySort()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $data=json_decode(Yii::app()->request->getPost('data', json_encode(array())));
            if(is_array($data)) {
                $cases=array('ordering'=>'', 'root'=>'','lft'=>'','rgt'=>'','level'=>'');
                foreach($data as $item) {
                    array_walk($cases, function(&$expression,$attribute) use ($item) { 
                        $expression.=' WHEN '.(int)$item->id.' THEN '.(int)$item->$attribute;
                    });
                }
                array_walk($cases, function(&$expression,$attribute) {
                    $expression="`t`.`{$attribute}`=CASE `t`.`id` {$expression} ELSE `t`.`{$attribute}` END";
                });
                
                $query='UPDATE `'.CategoryNew::model()->tableName().'` as `t` SET '.implode(',',$cases);
                CategoryNew::model()->getDbConnection()
                    ->createCommand($query)
                    ->execute();
                echo CJSON::encode(array('success'=>true));
            }
            else {
                echo CJSON::encode(array('success'=>false));
            } 
            Yii::app()->end();
            die();
        }
        $this->pageTitle = 'Препараты'.' / Сортировка категорий';

        $this->render('category_sort');
    }

    /* --- Product CRUD --- */
    public function actionProductCreate($category_id = null)
    {
        $last = ProductNew::model()->lastRecord()->find();
        $model = new ProductNew();

        if (isset($_POST['ProductNew'])) {
            $model->attributes = $_POST['ProductNew'];

            if ($model->save()) {

                if(isset($_POST['EavValue'])){
                    foreach ($_POST['EavValue'] as $key => $value) {
                        $attributesProduct = new EavValue;
                        $attributesProduct->id_attrs = $key;
                        $attributesProduct->id_product = $model->id;
                        $attributesProduct->value = $value;
                        $attributesProduct->save();
                    }
                }
                
                if(isset($_POST['saveout'])) {
                	Y::setFlash(Y::FLASH_SYSTEM_SUCCESS, Yii::t('AdminModule.shop', 'success.productCreatedWithName', ['{name}'=>$model->title]));
                	$this->redirect(['category', 'id'=>$model->category_id]);
                }
                else {
                	$this->redirect(['productUpdate', 'id'=>$model->id]);
                }
            }
        }

        if ($category_id)
            $model->category_id = $category_id;
        else{
            if(count($last)>0)
                $model->category_id = $last->category_id;
        }

        $fixAttributes = array();

        if(Yii::app()->params['attributes']){
            $criteria = new CDbCriteria;
            $criteria->condition = "fixed = 1";

            $fixAttributes = EavAttribute::model()->findAll($criteria);
        }

        $this->render('productcreate', compact('model', 'fixAttributes'));
    }

    //Клонирование продукта
    public function actionProductClone($id){
        $model = $this->loadProduct($id);
        $cloned_product = new ProductNew;
        $cloned_product->attributes = $model->attributes;
        $cloned_product->title = $model->title."_копия";
        $cloned_product->alias = $model->alias."-".mktime();
        // $cloned_product->created=new \CDbExpression('NOW()');
        // $cloned_product->ordering=0;
        //Если продукт сохранен, то начинаем работу с картинками.
        //Объявляем хелпер.
        $fhelp = new CFileHelper;
        //Получаем изображения.
        $id = $model->id;
        $files_to_copy = glob('images/product/{'.$id.','.$id.'_*}.*', GLOB_BRACE); 
        //Если продукт склонировался выполняем нужные действия
        if($cloned_product->save()){
			if($oldMainImageFile=$cloned_product->mainImageBehavior->getFilename(true)) {
	        	$cloned_product->main_image=$cloned_product->mainImageBehavior->getBasename() . '.' . pathinfo($cloned_product->mainImageBehavior->getFilename(true), PATHINFO_EXTENSION);
        		$newMainImageFile=$cloned_product->mainImageBehavior->getFilename(true);
        		copy($oldMainImageFile, $newMainImageFile);
	        	$cloned_product->save();
        	}
            if(!empty($files_to_copy)) {
                foreach ($files_to_copy as $key => $file) {
                    $ext = $fhelp->getExtension($file);
                    $tmp = explode('/', $file);
                    $tmp = explode('.', $tmp[2]);
                    $tmp = explode('_', $tmp[0]);
                    if(isset($tmp[1])){
                        copy( $file, 'images/product/'.$cloned_product->id.'_'.$tmp[1].'.'.$ext); 
                    }
                    else{

                        copy( $file, 'images/product/'.$cloned_product->id.'.'.$ext);

                    }
                }
            }
            //Обработка дополнительных фотографий.
            $imgages = CImage::model()->findAll(array('condition'=>"item_id = $model->id"));
            if($imgages) {
                foreach ($imgages as $key => $img) {
                    $new_image = new CImage;
                    $new_image->attributes = $img->attributes;
                    $uid = uniqid();
                    $ext = $fhelp->getExtension('/images/product/'.$img->filename);
                    $fname = $uid.'.'.$ext;
                    $new_image->filename = $fname;
                    $new_image->item_id = $cloned_product->id;
                    if(copy('images/product/'.$img->filename, 'images/product/'.$fname)){
                        $new_image->save();
                    }
                }
            }
            $url = $this->createUrl('shopNew/productupdate', array('id'=>$cloned_product->id));
            $this->redirect($url);
        }
    }

    public function actionProductUpdate($id, $price = null, $save = false)
    {   
        $model = $this->loadProduct((int)$id);
        if($save) {
            $model->price = $price;
            $model->save(false);
            Yii::app()->end();
        }

        if (isset($_POST['ProductNew'])) {
            $model->attributes = $_POST['ProductNew'];
            if ($model->save()) {

                if(isset($_POST['EavValue']) && $_POST['EavValue']){
                    foreach ($_POST['EavValue'] as $key => $value) {

                        $criteria = new CDbCriteria;
                        $criteria->condition = "id_attrs = {$key} AND id_product = {$model->id}";

                        $attributesProduct = EavValue::model()->find($criteria);

                        if(count($attributesProduct)){

                            $attributesProduct->value = $value;
                            $attributesProduct->save();
                        }else{

                            $attributesProduct = new EavValue;
                            $attributesProduct->id_attrs = $key;
                            $attributesProduct->id_product = $model->id;
                            $attributesProduct->value = $value;
                            $attributesProduct->save();

                        }

                    }
                }

                $additionalCategories = Yii::app()->request->getPost('relatedCategories');

                if($additionalCategories){
                    foreach ($additionalCategories as $id => $catID) {
                        $relatedCategory = new RelatedCategory;
                        $relatedCategory->product_id = $model->id;
                        $relatedCategory->category_id = $catID;
                        $relatedCategory->save();
                    }
                }

                if(isset($_POST['saveout'])) {
                	Y::setFlash(Y::FLASH_SYSTEM_SUCCESS, Yii::t('AdminModule.shop', 'success.productUpdatedWithName', ['{name}'=>$model->title]));
               		$this->redirect(['category', 'id'=>$model->category_id]);
                }
            }
        }
        $fixAttributes = array();

        if(Yii::app()->params['attributes']){
            $criteria = new CDbCriteria;
            $criteria->condition = "fixed = 1";

            $fixAttributes = EavAttribute::model()->findAll($criteria);
        }

        // Дополнительные категории
        if($model->isNewRecord) {
            $categoryList=$relatedCategories=null;
        }
        else {
            $relatedCategoriesIDs = array();

            foreach ($model->relatedCategories as $key => $value) {
                $relatedCategoriesIDs[] = $value['category_id'];
            }

            $relatedCategoriesIDs[] = $model->category_id;

            $categoryCriteria = new CDbCriteria;
            $categoryCriteria->select = 'id, title, lft, rgt, level, root';
            $categoryCriteria->addNotInCondition('id', $relatedCategoriesIDs);

            $categoryList = CategoryNew::model()->findAll($categoryCriteria);

            $categoryCriteriaProduct = new CDbCriteria;
            $categoryCriteriaProduct->select = 'id, title';
            $categoryCriteriaProduct->addInCondition('id', $relatedCategoriesIDs);
            $relatedCategories = CategoryNew::model()->findAll($categoryCriteriaProduct);
        }

        $this->render('productupdate', compact('model', 'fixAttributes', 'categoryList', 'relatedCategories'));
    }
    
    public function actionThumbsUpdate($id)
    {
        $model = $this->loadProduct($id);

        if (isset($_POST['ProductNew'])) {
            $model->attributes = $_POST['ProductNew'];

            if ($model->save()) {
                $this->refresh();
            }
        }

        $this->render('thumbsupdate', compact('model'));
    }

    public function actionProductDelete($id)
    {
        $model = $this->loadProduct($id);
        $categoryId=$model->category_id;
        $model->delete();

        $this->redirect(array('shopNew/category', 'id'=>$categoryId));
    }


    private function _saveCategories(array $categories, $parentModel=null)
    {
        foreach ($categories as $code => $data) {
            $model = CategoryNew::model()->findByAttributes(array('code'=>$code));
            
            if(!$model) {
                $model = new CategoryNew();
                $model->title = $data['category']['title'];
                $model->code = $data['category']['code'];
                
                if($parentModel!=null)
                    $model->appendTo($parentModel);

                $model->saveNode();
            }

            if (isset($data['subcategory'])) 
                $this->_saveCategories($data['subcategory'], $model);
        }
    }

    public function actionCategoryCreate($parent_id = null)
    {
        $model = new CategoryNew();

        if (isset($_POST['CategoryNew'])) {
            $model->attributes = $_POST['CategoryNew'];

            if ($parent_id) {
                $parent = CategoryNew::model()->findByPk($parent_id);
                $save = $model->appendTo($parent);
            } else {
                $save = $model->saveNode();
            }
            
            if ($save) {
                if(isset($_POST['saveout'])) {
                    Y::setFlash(Y::FLASH_SYSTEM_SUCCESS, Yii::t('AdminModule.shop', 'success.categoryCreatedWithName', ['{name}'=>$model->title]));
                    $this->redirect(['category', 'id'=>$model->id]);
                }
                else {
                    $this->redirect(['categoryUpdate', 'id'=>$model->id]);
                }
            }
        }

        $this->render('categorycreate', compact('model'));
    }

    public function actionCategoryUpdate($id)
    {
        $model = $this->loadCategory($id);

        if (isset($_POST['CategoryNew'])) {
            $model->attributes = $_POST['CategoryNew'];
            
            if ($model->saveNode()) {
            	if(isset($_POST['saveout'])) {
            		Y::setFlash(Y::FLASH_SYSTEM_SUCCESS, Yii::t('AdminModule.shop', 'success.categoryUpdatedWithName', ['{name}'=>$model->title]));
            		$this->redirect(['category', 'id'=>$model->id]);
            	}
                $this->refresh();
            }
        }

        $this->render('categoryupdate', compact('model'));
    }
    
    public function actionCategoryDelete($id)
    {
        $model = $this->loadCategory($id);
        $model->deleteNode();

        $this->redirect(array('shopNew/index'));
    }
    
    public function actionCategoryTotalDelete($id)
    {
    	if(!$_GET['hash'] || (md5($id) !== $_GET['hash'])) {
    		$this->redirect(array('shopNew/category', 'id'=>$id));
    	}
        $category = $this->loadCategory($id);
        $descendants=$category->descendants()->findAll(['index'=>'id']);

        $categoryIDs=[];
       	if($descendants) {
        	$categoryIDs=array_keys($descendants);
        }
        $categoryIDs[]=$category->id;

        $criteria=new CDbCriteria;
   	    $criteria->addInCondition('`category_id`', $categoryIDs);

        $products=ProductNew::model()->findAll($criteria);
        if($products) {
        	foreach($products as $product)
        		$product->delete();
        }
        $category->deleteNode();

        $this->redirect(array('shopNew/index'));
    }

    private function loadProduct($id)
    {
        $model = ProductNew::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'Продукт не найден');
        return $model;
    }
    private function loadCategory($id)
    {
        $model = CategoryNew::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'Категория не найдена');
        return $model;
    }


    /** ---  */
    public function actionRemoveMainImg()
    {
        $status = 0;

        if (isset($_POST['product_id'])) {
            ProductNew::model()->removeMainImage($_POST['product_id']);
            $status = 1;
        }
        echo $status;
        Yii::app()->end();
    }

    public function actionRemoveCategoryMainImg()
    {
        $status = 0;

        if (isset($_POST['product_id'])) {
            CategoryNew::model()->removePhoto($_POST['product_id']);
            $status = 1;
        }
        echo $status;
        Yii::app()->end();
    }

    
    
    

    public function actionClearImageCache()
    {
        ProductNew::model()->clearImageCache();

        if (Yii::app()->request->isAjaxRequest) {
            echo 'ok';
            Yii::app()->end();
        }
        $this->redirect(array('shopNew/index'));
    }

    /**
     * @param null $parent
     * @return mixed
     */
    private function getCategories($parent = null)
    {
        if ($parent) {
            if($category = CategoryNew::model()->findByPk($parent)) {
            	return $category->children()->findAll();
            }
            return false;
        }

        return CategoryNew::model()->roots()->findAll(array('order'=>'ordering'));
    }

    public function getBreadcrumbs($id, $add_current = false)
    {
        $category = CategoryNew::model()->findByPk((int)$id);
        
        $result = array();
        $result['Препараты'] = array('shopNew/index');

        if(count($category)){
            $parents = $category->ancestors()->findAll();
            
            foreach($parents as $p) {
                $result[$p->title] = array('shopNew/category', 'id'=>$p->id);
            }
            if($add_current){
                $result[$category->title] = array('shopNew/category', 'id'=>$category->id);    
            }
        }

        return $result;
    }

    public function actionResize() {
        Yii::import('ext.EJCropper');
        $jcropper = new EJCropper();
        $jcropper->thumbPath = Yii::getPathOfAlias('webroot.images.product');
         
        $jcropper->jpeg_quality = 95;
        $jcropper->png_compression = 8;
         
        // get the image cropping coordinates (or implement your own method)
        $coords = $jcropper->getCoordsFromPost();
         
        // returns the path of the cropped image, source must be an absolute path.
        $src = mb_strpos($_POST['src'], '?') ? Yii::getPathOfAlias('webroot').mb_strcut($_POST['src'], 0, mb_strpos($_POST['src'], '?')) : Yii::getPathOfAlias('webroot').$_POST['src'];
        $dst = mb_strpos($_POST['dst'], '?') ? Yii::getPathOfAlias('webroot').mb_strcut($_POST['dst'], 0, mb_strpos($_POST['dst'], '?')) : Yii::getPathOfAlias('webroot').$_POST['dst'];
        $thumbnail = $jcropper->crop($src, $dst, $coords);
    }

    public function actionCarousel()
    {
    	if(!D::cms('shop_enable_carousel'))
    		throw new \CHttpException(404);
    	
    	$this->breadcrumbs = [
        	'Препараты'=>['shopNew/index'],
        	'Популярные товары'=>['shopNew/carousel']      	
    	];
    	
    	$dataProvider=ProductNew::model()->cardColumns()->scopeSort('product_carousel')->getDataProvider(['condition'=>'in_carousel=1'], false);

    	$this->render('carousel', compact('dataProvider'));
    }
}
