$(document).ready(function(){


//---------- КНОПКА ВЫВОДА ВСЕХ ИМЕЮЩИХСЯ ССЫЛОК -----	
//---------- КНОПКА ВЫВОДА ССЫЛОК КАТЕГОРИИ "ГЛАВНЫЕ" -----	
//---------- ВЫВОД СПИСКА ИЗ ДВАДЦАТИ ПОСЛЕДНИХ СОЗДАННЫХ ССЫЛОК  ---
//---------- ВЫВОД СПИСКА КАТЕГОРИЙ ВКЛАДОК ---------
//---------- ОБНОВЛЕНИЕ ЭЛЕМЕНТА  ------------------------
//---------- ОБНОВЛЕНИЕ ЭЛЕМЕНТА 2 ------------------------

//---------- ФУНКЦИИ  -----


//------------  УДАЛЕНИЕ ССЫЛКИ  --------------
$('#all_group').on('click', '.del', function(){

    var $elemCl = $(this).closest('li');
    var nom = $elemCl.attr('data-id');
    var elemNomName = $elemCl.find('h3 a').text();

	if(confirm("Вы действительно хотите удалить данную категорию со всеми относящимеся к ней ссылками \"" + 
	elemNomName + "\" ?")) {
		
		$.ajax({
			url: 'ajax/add_del_group.php',
			type: 'post',
			dataType: 'json',
			data: { nameDelCat: nom },
			success: function(data) {

                $elemCl.remove();  //=====  del element
				
				//--  НУМЕРОВАНИЕ ЭЛЕМЕНТОВ
				$("#all_group .number").each(function(indx, element){
				  $(element).text(indx + 1);	  
				});				
				
				//--  ВЫВОД ВСПЛЫВАЮЩЕГО ОКНА
				$(".alert_mess").text('Категория \"'+ elemNomName +'\" и все её ссылки были удалены!').fadeIn(500).delay(1500).fadeOut(500);
				
			}
		});
		
		vent.stopImmediatePropagation(); 
		return false;
	}
});


//------------------

//------------  РЕДКАТИРОВАНИЕ КАТЕГОРИИ  --------------
$('#all_group').on('click', '.apdate', function(){

	$('#modal_wind').show(100);
	$('#wrap_form').show(100);
	$('#group_apdate').slideDown(300);
	$('#all_group').slideUp(150);

	var ar_clElemDt = [];

	var clElemDt = $(this).closest('li');

	ar_clElemDt[0] = clElemDt.attr("data-id");

    $.ajax({
		url: "ajax/add_del_group.php",
		type: 'post',
		dataType: 'json',
		data: { UPDATE_GROUP: ar_clElemDt[0] },
		success: function(data) {

			//-- вывод номера категории
			$('#group_apdate').attr("data-id", data[0]);

			//-- вывод имени категории
			$('#group_apdate #name_group').val(data[1]);

			//-- вывод фона
			$('#group_apdate #backg_group_color').val(data[2]);

			//-- вывод описания
			$('#group_apdate #title_group').val(data[3]);

            //-- print background-img
            $('#backg_group_img-update').val(data[5]);

            //-- print background-img
			if ( data[6] == 1 ) { data[6] = true; } else { data[6] = false; }
            $('#menu_view').prop('checked', data[6]);
		}
	});

	return false;
});


//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

$('#but_send_group_update').on('click', function(){

	var ar_clElemDt = [];

	//-- вывод номера категории
	ar_clElemDt[0] = $('#group_apdate').attr("data-id");

	//-- вывод имени категории
	ar_clElemDt[1] = $('#group_apdate #name_group').val();

	//-- вывод фона
	ar_clElemDt[2] = $('#group_apdate #backg_group_color').val();

	//-- вывод описания
	ar_clElemDt[3] = $('#group_apdate #title_group').val();

	//-- выбор отображения пункта меню
	ar_clElemDt[4] = $('#menu_view').prop("checked");
	if (ar_clElemDt[4]) { ar_clElemDt[4] = 1; } else { ar_clElemDt[4] = 0; }

    //-- print background-image
    ar_clElemDt[5] = $('#backg_group_img-update').val();
    console.log( ar_clElemDt );


	//-- отправка данных редактируемой категории
    $.ajax({
		url: "ajax/add_del_group.php",
		type: 'post',
		dataType: 'json',
		data: { UPDATE_GROUP_FULL: ar_clElemDt },
		success: function(data) {
			if (data[0] == 0) {
                $(".alert_mess").text('Категория с таким названием уже существует').fadeIn(500).delay(1500).fadeOut(500);
			}

            if (data[0] == 1) {
                $(".alert_mess").text('Категория была обновлена').fadeIn(500).delay(1500).fadeOut(500);
            }

            if (data[0] == 2) {
                $(".alert_mess").text('Название категории "' + data[2] + '" изменена на "' + data[1] + '" ').fadeIn(500).delay(1500).fadeOut(500);
            }
		}
	});

});


//-------
});