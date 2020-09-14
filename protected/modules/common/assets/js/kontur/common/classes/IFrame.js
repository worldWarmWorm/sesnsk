/**
 * Вспомогательный класс для IFRAME
 */
;KonturLoader.add('common\kontur\iframe', function() {

window.Kontur.IFrame=(function() {
	var _this=this;
	
	/** @var object _parent объект родительского окна */
	this._parent=window.parent;
	
	/**
	 * Перезагрузка родительского окна
	 */
	this.parentReload=function() {
		_this._parent.location.reload();
	};
	
	/**
	 * Fancybox
	 * @see http://fancyapps.com/fancybox/#docs
	 */
	this.fancybox=(function() {
		if(typeof(_this._parent.$.fancybox) != "undefined")
			return _this._parent.$.fancybox;
		
		return null;
	})();
	
	return this;
})();

},2 );