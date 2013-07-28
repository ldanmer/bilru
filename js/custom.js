$(document).ready(function(){
	// Принятие соглашения
	$('#accept').click(function(){
		$('#PersonalData_terms').prop('checked', true);
	});

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
		$(block).find('.hidden').toggle('500').css('display', 'inline');

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
		var block = $(this).parent().parent().parent().next();
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
	$('.carusel').carouFredSel({
		circular: false,		
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

	// Переключение видимости заказов пользователя
	$('#orders-show').click(function(){
		if($('#user-purchases').is(':visible'))
		{
			$('#user-purchases').hide();			
		}
		$('#user-orders').toggle();
	});

	// Переключение видимости поставок пользователя
	$('#purchases-show').click(function(){
		if($('#user-orders').is(':visible'))
		{
			$('#user-orders').hide();			
		}
		$('#user-purchases').toggle();
	});

	// Кнопка загрузки изображений
	$('.upload').click(function(){
		var id = $(this).attr('data-target');		
		$('#'+id+'_wrap input').last().trigger('click');
	});

	$('.accordion-menu li.level1').hover(
		function(){
			$(this).find('ul.level2').stop().show('slow');
		},
		function(){
			$(this).find('ul.level2').stop().hide('slow');
		}
	);

	$('.multiselect').multiselect({
		buttonWidth:'314px',
		maxHeight: 500,
		buttonClass:'btn',		
		includeSelectAllOption:true
	});

	$('a.look').tooltip({title:"Посмотреть"});

	/* Мульти Селект */

	$('li.group-label').click(
		function (event) {	
		event.stopPropagation();		
			if($(this).hasClass('hovered'))
				$(this).removeClass('hovered');
			else
				$(this).addClass('hovered');			
			$(this).find('ul.multiselect-group').toggle(500);
		}
	);

	$('input#avatar').change(function(){
		$(this).closest("form").submit();
	});

	$('a.accordion-toggle').click(function (){
		var i = $(this).find('i');
		if(i.hasClass('icon-chevron-right'))
			i.removeClass('icon-chevron-right').addClass('icon-chevron-down')
		else
			i.removeClass('icon-chevron-down').addClass('icon-chevron-right')
	});

	$('input.selectall').change(
		function(){	
		if(!$(this).is(':checked'))		
			$(this).closest('div.accordion-inner').find('input[type="checkbox"]').prop('checked', false);
		else
			$(this).closest('div.accordion-inner').find('input[type="checkbox"]').prop('checked', true);
		});

	$('#tarifbase input[type="checkbox"]').change(
		function(){	
			if(!$(this).is(':checked'))
				$('#tarifbase input[type="checkbox"]').attr("disabled", false);
			else
				$('#tarifbase input[type="checkbox"]').attr("disabled", true);
				
				$(this).closest('div.accordion-inner').find('input[type="checkbox"]').attr("disabled", false);
		});

	$('#payment-form input[type="radio"]').change(
		function(){
			$('#payment-form input[type="radio"]').parent().css('background-color', '#1f497d');
			$('#payment-form input[type="radio"]:checked').parent().css('background-color', 'rgb(0,176,80)');

			if($(this).attr('id')=='UserSettings_tariff_0')
			{
				$('#fucking-idiocy button').text('Перейти');
				//$('#fucking-idiocy button').attr('data-toggle', 'modal').attr('data-target', '#base-trans');
			}				
			else
			{
				$('#fucking-idiocy button').text('Оплатить');
			}			


			var tar = $('input[type="radio"]:checked', '#tarif-choose').parent().parent().find('label').text();		
			var term = $('#payment-term input[type="radio"]:checked').val()
			var index = $('#payment-term input[name="term"]:checked').parent().index();			
			var sum = $('td:eq('+index+')','#refresh #sum').text();
			var month = "";
			if(term == "1") 
				month = " месяц";
			if(term == "3") 
				month = " месяца";
			if(term == "6" || term == "12") 
				month = " месяцев";

			if(tar.toLowerCase() != "базовый")
			{
				$('#payment-title').text('Оплата тарифного плана "' + tar + '" на ' + term + month);
				$('#final-price').text(sum + ' руб.');
			}				
			else
			{
				$('#payment-title').text('-');
				$('#final-price').text('0,00 руб.')
			}				
		});
});

