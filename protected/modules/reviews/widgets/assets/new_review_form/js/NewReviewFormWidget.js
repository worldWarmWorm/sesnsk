/**
 * Kontur.Reviews.NewReviewFormWidget javascript class.
 * Javascript for \reviews\widgets\NewReviewForm widget
 * 
 * @use js/kontur/common/classes/Kontur.js
 * @use js/kontur/reviews/classes/Reviews.js
 * 
 */
;KonturLoader.add('reviews\kontur\reviews\widgets\newreviewform', function() {
	
	window.Kontur.__proto__.Reviews.__proto__.NewReviewFormWidget=(function() {
		/**
		 * @var object this.
		 */
		var _this=this,
			$fancyboxWrapper=$("#fancybox-wrap"),
			jqFormId='#fancybox-review-add-form',
			$form=$(jqFormId),
			tryCount=3;
		
		this.submitAddForm=function(form, data, hasError) {
			if (!hasError) {
				var t=Kontur.Lang.t("reviews_langs");
				if(tryCount-- > 0) {
		            $.post($(form).attr('action'), $(form).serialize(), function(data) {
		                if (data.success) {
							$form.parent().html(t("w_nrf_mgs_success"));
		                }
		                else {
		                	Kontur.DataJs.get("result-errors", $form).html(t("w_nrf_mgs_error")).show();
		            	}
		            }, "json");
				}
				else {
					Kontur.DataJs.get("buttons", $form).html(t("w_nrf_mgs_error_max_try")).show();
				}
	        }
		};
		
		/**
		 * Инициализация
		 */
		this.init=(function(model) {
			$(document).on("click", Kontur.DataJs.expr("add-review"), function(e) {
				$.fancybox({
	                'href': jqFormId,
	                'scrolling': 'no',
	                'titleShow': false,
	                'onComplete': function(a, b, c) {
	                	$fancyboxWrapper.addClass('formBox');
	                }
	            });
			});
		    
			return this;
		})(this);
	
		return this;
	})();
	
}, 200);
