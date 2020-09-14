/**
 * Класс интернационализации
 */
;KonturLoader.add('common\kontur\lang', function() {
	
	window.Kontur.Lang=(function() {
		var _this=this;
	
		/** @var array переводы {category: {key: message}} */
		this.langs=[];
	
		/**
		 * добавление переводов
		 * @param string category
		 * @param array messages {key: message}
		 */
		this.register=function(category, messages) {
			_this.langs[category]=messages;
		};
		
		/**
		 * функция перевода
		 */
		this.t=function(category) {
			return function(key) {
				return _this.langs[category] ? _this.langs[category][key] : '';
			};
		};
	
		return this;
	})();
	
}, 2);