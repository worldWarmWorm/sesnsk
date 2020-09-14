/**
 * Kontur.Reviews.DefaultController javascript class.
 * Javascript for \reviews\controllers\DefaultController
 * 
 * @use js/kontur/common/classes/Kontur.js
 * @use js/kontur/reviews/classes/Reviews.js
 * 
 */
;KonturLoader.add('reviews\kontur\reviews\defaultcontroller', function() {
	
	window.Kontur.__proto__.Reviews.__proto__.DefaultController=(function() {
		/**
		 * @var object this.
		 */
		var _this=this;
		
		/**
		 * Инициализация
		 */
		this.init=(function(model) {
		    /*        $(this).next().toggleClass('show');
		        });
	
		        $('#add-question a').click(function() {
		            
		        });
		    });
	
			$(document).ready(function() {
				if(_this.getAutoSave() == 1) {
					$(Kontur.DataJs.expr("auto-save")).attr("checked", "checked");
					$(Kontur.DataJs.expr("btn-total-save")).addClass("disabled");
				}
				
				$(document).on("switchChange.bootstrapSwitch", Kontur.DataJs.expr("auto-save"), model.changeAutoSave);
				$(document).on("change", Kontur.DataJs.expr("nestable-menu"), model.nestableMenuSave);
				$(document).on("click", Kontur.DataJs.expr("btn-total-save"), model.nestableMenuTotalSave);
			});
			
			*/
			return this;
		})(this);
	
		return this;
	})();
	
}, 201);
