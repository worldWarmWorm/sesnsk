/*function shopItemCount(){
	var k = $(".product-item").length;
	var n = (k%4);
	if (n > 0) {

		for (var i = 0; i < 4-n; i++) {
			$(".product-list").append("<div class='product-item'></div>");
		}
	}
}*/

var toCartAnimation = function(obj) {

	
	var cv = obj.innerWidth();
	var ch = obj.innerHeight();
	var ot = obj.offset().top - $(document).scrollTop();
	var ol = obj.offset().left;

		console.log(cv);
	obj.clone()
		.css({
			'position' : 'fixed',
			'z-index' : '100',
			'width': cv,
			'height': ch,
			'top': ot,
			'left': ol,
			'opasity': 0.5
		})  
		.appendTo('body')
		.addClass('product-scale')
		.removeClass('slick-slide')
		.animate({
			opacity: '0',
			marginTop: -ch,
			marginLeft: -cv,
			top: 0,
			left:'100%',
			opacity: 0,
		}, 
		500, function() {
			$(this).remove();
		});
}


$(document).ready(function() {
	/*if($(".product-list").length) {
		shopItemCount();
	}*/

	$(document).on('click', '.js__in-cart', function(){
		toCartAnimation($(this).closest(".product-item"));
		$(this).addClass('in-cart-active');
	});

	$(document).on('click', '.js__photo-in-cart', function(){
		toCartAnimation($(".js__main-photo"));
		$(this).addClass('in-cart-active');
	});

	// Скрипт оберзки текста
	(function(selector) {
		var maxHeight=100, // максимальная высота свернутого блока
			togglerClass="read-more", // класс для ссылки Читать далее
			smallClass="small", // класс, который добавляется к блоку, когда текст свернут
			labelMore="Подробнее", 
			labelLess="Свернуть";
			
		$(selector).each(function() {
			var $this=$(this),
				$toggler=$($.parseHTML('<a href="#" class="'+togglerClass+'">'+labelMore+'</a>'));
			$this.after(["<div>",$toggler,"</div>"]);
			$toggler.on("click", $toggler, function(){
				$this.toggleClass(smallClass);
				$this.css('height', $this.hasClass(smallClass) ? maxHeight : $this.attr("data-height"));
				$toggler.text($this.hasClass(smallClass) ? labelMore : labelLess);
				return false;
			});
			$this.attr("data-height", $this.height());
			if($this.height() > maxHeight) {
				$this.addClass(smallClass);
				$this.css('height', maxHeight);
			}
			else {
				$toggler.hide();
			}
		});
	})(".is_read_more"); // это селектор элементов для которых навешивать обрезку текста.

	var fancyboxImages = $('a.image-full'); 
	if (fancyboxImages.length) {
		$(fancyboxImages).fancybox({
			overlayColor: '#333',
			overlayOpacity: 0.8,
			titlePosition : 'over',
			helpers: {
			overlay: {
					locked: false
				}
			}
		});
	}

	$('body').on('click', '.yiiPager li', function(){
		$('html, body').animate({ scrollTop: $('.content').offset().top }, 500); // анимируем скроолинг к элементу scroll_el
	});

	$('#totop').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});
});
