/**
 * Класс регистрации обработчиков.
 */
;KonturLoader.add('common\kontur\datajs', function() {
	
	window.Kontur.DataJs=(function() {
		var _this=this;
		
		/**
		 * Получить выражение выборки для атрибута "data-js".
		 * @param string value значение.
		 * @param mixed prefix выражение к которому будет добавлен селектор "[data-js='value']".
		 * По умолчанию пустая строка.
		 * @param boolean isChildren элемент является потомком. Требуется, если в параметре "prefix"
		 * передан объект без заданного атрибута "id". Если передно FALSE, выражение выборки 
		 * будет создано для текущего объекта. По умолчанию TRUE (выражение выборки будет создано 
		 * для выборки потомка).  
		 * @return string выражение выборки.
		 */
		this.expr=function(value, prefix, isChildren) {
			if(typeof(prefix) != "string") {
				if(typeof(prefix) == "object") {
					if(typeof(isChildren) == "undefined") 
						isChildren=true;
					
					if(prefix.selector) 
						prefix=prefix.selector + (isChildren ? " " : "");
					else {
						var id=Math.random() * (1000000 - 1) + 1;
						$(prefix).attr("data-jsid", id);
	
						prefix="[data-jsid='"+id+"']" + (isChildren ? " " : "");
					}
				}
				else {
					prefix="";
				}
			}
			
			return prefix + "[data-js='" + value + "']";
		};
		
		/**
		 * Получить элемент по значению атрибута "data-js".
		 * @param string value значение.
		 * @param mixed obj объект или выражение выборки, относительно которого будет произведен поиск.
		 * @param mixed filter выражение фильтрации. По умолчанию фильтрация применена не будет.
		 * @return object jQuery
		 */
		this.get=function(value, obj, filter) {
			var $found=(typeof(obj) == 'undefined') ? $(_this.expr(value)) : $(obj).find(_this.expr(value));
			return (typeof(filter) != 'undefined') ? $found.filter(filter) : $found;
		};
		
		/**
		 * Получить значение параметра
		 * @param string name имя параметра. 
		 * @param mixed obj объект или выражение выборки, для которого будет получено значение data-js параметра.
		 * @return object jQuery
		 */
		this.param=function(name, obj) {
			return $(obj).attr("data-js-"+name);
		}
		
		/**
		 * Установка значения параметра
		 * @param string name имя параметра. 
		 * @param mixed value значение параметра. 
		 * @param mixed obj объект или выражение выборки, для которого будет получено значение data-js параметра.
		 * @return object jQuery
		 */
		this.setParam=function(name, value, obj) {
			$(obj).attr("data-js-"+name, value);
			return $(obj);
		}
		
		return this;
	})();
	
}, 2);