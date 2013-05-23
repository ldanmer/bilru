$(document).ready(function(){
	// Переключение видимости типов подрядчиков
	$('#contractor-types').click(function(){
		if($('#work-list').is(':visible'))
			$('#work-list').hide();
		
		$('#contractor-list').toggle();
	});

		// Переключение видимости типов подрядчиков
	$('#work-types').click(function(){
		if($('#contractor-list').is(':visible'))
			$('#contractor-list').hide();
		$('#work-list').toggle();
	});

	// Переключение видимости типов заказов
	$('#order-types').click(function(){
		if($('#contractor-list').is(':visible') || $('#work-list').is(':visible'))
		{
			$('#contractor-list').hide();
			$('#work-list').hide();
		}
		$('#ordertype-list').toggle();
	});

	$('#dogovorennost').click(function(){
		if($(this).is(':checked'))
		{
			$('#Orders_price').attr('value', '0').attr('disabled','');
		}
		else
		{
			$('#Orders_price').removeAttr('disabled');
		}
	});

	// Разворот заказов
	$('.show').click(function(){
		var block = $(this).parent().parent();
		$(block).find('.hidden').toggle('500');

		if($(this).attr("value") == "Показать полностью")
			$(this).attr("value", "Свернуть")
		else
			$(this).attr("value", "Показать полностью")

		if($(this).text()=="Далее...")
			$(this).text("Свернуть");
		else
			$(this).text("Далее...");

	});
	
	// Разворот формы комментариев
	$('a.comment-show').click(function(){
		var block = $(this).parent().parent().next();
		$(block).toggle();
	});

	$('a.cencel').click(function(){
		var block = $(this).parent().parent().parent();
		$(block).toggle();
	})

	// Добавить строк
	$('#add-lines').click(function(){
		$('tbody#order-list tr').clone().appendTo($('tbody#order-list'));
	});

	// Вернуться на страницу назад
	$('.btn-back').click(function(){
		window.history.back();
	});

	// Tooltip в поиске покупки
	$('#material-grid img[src$="stroy_mat.png"]').tooltip({title:"Строительные материалы"});
	$('#material-grid img[src$="otdel_mat.png"]').tooltip({title:"Отделочные материалы"});
	$('#material-grid img[src$="engen_mat.png"]').tooltip({title:"Инженерное оборудование"});
	$('#material-grid img[src$="delivery.png"]').tooltip({title:"Только с доставкой"});

	// Карусель
	$('#photos').carouFredSel({
		circular: false,
		pagination  : "#photos_pag"
	});

	$('#blueprints').carouFredSel({
		circular: false,
		pagination  : "#blueprints_pag"
	});

	// Add fields to Offer
	$('#offer-add').click(function(){
		$('.hide').show();
		$('.visible').hide();
		$(this).replaceWith($('<input type="submit" class="pull-right btn btn-primary" name="submit" />'));
	});

	// Count Offer sum 
	$('.order-amount').change(function(){
		var thisPrice = parseInt($(this).attr('value'));
		var number = parseInt($(this).parent().prev().text());
		$(this).parent().next().text(thisPrice * number);
		var amount = 0;
		$('.sum').each(function(){
			amount = amount + parseInt($(this).text());
		});
		$('#ByOffer_total_price').attr('value',amount);
	});

	$('#ByOffer_unsupply').click(function(){
		if($(this).is(':checked'))
		{
			$('#ByOffer_delivery').attr('value', '0').attr('disabled','');
		}
		else
		{
			$('#ByOffer_delivery').removeAttr('disabled');
		}
	});

	// Tooltip в поиске поставщика
	$('tbody a[href*="byOffer"]').tooltip({title:"Посмотреть предложение"});
	$('tbody a[href*="orderOffer"]').tooltip({title:"Посмотреть предложение"});		
	$('tbody a[href*="UserRating"]').tooltip({title:"Отзывы"});		
	$('.order-view .rating').tooltip({title:"Посмотреть отзывы"});	
	$('.order-view .reviews').tooltip({title:"Посмотреть отзывы"});	

	$('#user-rating-form .raty-icons').click(function(){
		var average = 0;
		$('#user-rating-form input[type="hidden"]').each(function(){
			if($(this).attr('value'))
				var currNum = parseInt($(this).attr('value'));
			else
				currNum = 0;
			average = average + currNum;
		});
		$('#average').text((average/6).toFixed(1))
	});
});

