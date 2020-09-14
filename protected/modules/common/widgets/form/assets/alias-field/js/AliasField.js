/**
 * AliasFieldWidget script
 */
var AliasField={
	/**
	 * Инициализация
	 */
	init: function(titleId, aliasId, isNewRecord) {
		/**
		 * Обновление поля алиаса.
		 */
		function update(e) {
			//Если с английского на русский, то передаём вторым параметром true.
			$("#"+aliasId).val(cyr2lat($("#"+titleId).val()));
		};
		
		$(document).ready(function() {
			if(isNewRecord) 
				$("#"+titleId).on("keyup", update);
			else 
				$("#"+aliasId).siblings(Kontur.DataJs.expr("afw-btn-update")).on("click", update);
		});
	}
};