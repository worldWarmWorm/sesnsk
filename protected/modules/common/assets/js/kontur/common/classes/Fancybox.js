/**
 * Вспомогательный класс для Fancybox
 * @see http://fancyapps.com/fancybox/#docs
 * 
 * @use Kontur.js
 * @use DataJs.js
 */
;KonturLoader.add('common\kontur\\\\fancybox', function() {

window.Kontur.Fancybox=(function() {
	var _this=this;
	
	/**
	 * Получить экземпляр данного класса
	 */
	this.getInstance=(function(_this) {
		return function() {
			return _this;
		};
	})(this);
	
	/**
	 * Инициалировать fancybox
	 * @param string key значение атрибута data-js. По умолчанию "fancybox".
	 * @param mixed options опции для fancybox
	 */
	this.init=function(key, options) {
		if(typeof(key) == 'undefined') key="fancybox";
		
		$(Kontur.DataJs.expr(key)).fancybox(options);
	};
	
	/**
	 * Инициализация для IFRAME
	 * 
	 */
	this.iframeInit=function(options) {
		if(typeof(options) == 'undefined') {
			options={
				type: 'iframe',
				iframe: {
					scrolling: 'auto'
				},
				modal: false,
				autoSize: true,
				closeClick: false,
				openEffect: 'none',
				closeEffect: 'none'
			};
		}
		
		_this.init("fancybox-iframe", options);
		
		// закрытие fancybox-окна в iframe 
		$(document).on("click", Kontur.DataJs.expr("fancybox-iframe-btn-close"), function(e) {
			window.parent.$.fancybox.close(true);
		});
	};
	
	this.iframeInit();
	
	return this;
})();

}, 3);