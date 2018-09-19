//=====  VARIABLE
var countElemAll = 20;
var countElemAdd = 20;
var topOffset = 15;


$(document).ready(function () {

    //---------- КНОПКА ВЫВОДА ВСЕХ ИМЕЮЩИХСЯ ССЫЛОК -----
    //---------- ВЫВОД СПИСКА ИЗ ДВАДЦАТИ ПОСЛЕДНИХ СОЗДАННЫХ ССЫЛОК  ---
    //---------- ВЫВОД СПИСКА КАТЕГОРИЙ ВКЛАДОК ---------
    //---------- ОБНОВЛЕНИЕ ЭЛЕМЕНТА  ------------------------
    //---------- ОБНОВЛЕНИЕ ЭЛЕМЕНТА 2 ------------------------

    //---------- ОГРАНИЗАЦИЯ ГЛОБАЛЬНОГО ПОИСКА

    //---------- ФУНКЦИИ  -----


    //---------- КНОПКА ВЫВОДА ВСЕХ ИМЕЮЩИХСЯ ССЫЛОК -----
    $("#all_links").click(function () {

        $.ajax({

            url: "ajax/ajax.php",
            type: 'post',
            dataType: 'json',
            data: {vodca: 777},
            success: function (data) {

                $("#wrapper ul.bom").empty();  //-- очистка списка
                $(".nameGroup").html('<span class="all_lin">Все имеющиеся ссылки</span>');  //--  ВЫВОД ИМЕНИ ГРУППЫ В ЗАГОЛОВКЕ

                dat(data); //-- функция вывода элементов категорий

                $("#wrapper .number").each(function (indx, element) {
                    $(element).text(indx + 1);
                });
            }
        });
    });


    //----  ВЫВОД СПИСКА ИЗ ДВАДЦАТИ ПОСЛЕДНИХ СОЗДАННЫХ ССЫЛОК  ---
    $("#addLast").on('click', function () {

            $self = $(this);

            if ($self.hasClass('act')) {

                $self.removeClass('act');

                //-- очистка списка
                $("#lastTventy").slideUp(1000, function () {
                    $("#lastTventy ul.bom").empty();
                });

                $self.css({'background': 'gray'});
                $('.addLastNew').hide('slow', ()=>{ countElemAll = 20; });

            } else {

                $self.addClass('act');

                $self.css({'background': 'red'});

                $("#lastTventy ul.bom").empty();  //-- очистка списка

                lastElemLinkAdd();

                $("#lastTventy").slideDown(1000);
                $('.addLastNew').show('slow');
            }
        }
    );


    //=====

    $(".js-addLastNew").on('click', function () {

        lastElemLinkAdd();
    });


//-------  	ВЫВОД СПИСКА КАТЕГОРИЙ ВКЛАДОК ---------
    var allGroupName = [];

    $.ajax({

        url: "ajax/add_del_group.php",
        type: 'post',
        dataType: 'json',
        data: {vodca: "yes"},
        success: function (data) {

            $("#link_add select,#header > select,#header .menuCat").empty(); //-- предворительно очистим список

            var zn_view = 1;

            for (var i = 0; i < data["name"].length; i++) {

                // if (data["view"][i] == 1) {
                //     zn_view = "";
                // }
                // if (data["view"][i] == 0) {
                //     zn_view = "no-vis";
                // }

                allGroupName.push({'id': data["id"][i], 'name': data["name"][i]});

                $("#link_add select, #header > select").append("<option value='" + data["id"][i] + "'>" + data["name"][i] + "</option>"); //-- заполняем список категориями

                $("#header .menuCat").append(elemMenu(data["id"][i], data["timeCreat"][i], data["date"][i], data["view"][i], data["name"][i])); //-- заполняем список категориями
            }

            $("#header .menuCat li:first").addClass('sel');  //-- выделение первого элемента в группе категорий меню

            heightZn();  //-- создание отступа от вкладок
        }
    });

//-------  	ПЕРЕХОД К ССЫЛКАМ ПРИ НАЖАТИИ НА КАТЕГОРИЮ ---------
    $("#all_group, #header .menuCat").on('click', 'li', function () {
        var nameTitle = $(this).find("h3 a").text();  //-- выбранная из списка категория
        var gr = $(this).attr('data-id');  //-- выбранная из списка категория

        $("#header .menuCat li").removeClass('sel');  //-- удаляем класс выделения
        $("#header .menuCat li[data-id=" + gr + "]").addClass('sel');  //-- удаляем класс выделения

        $.ajax({
            url: "ajax/categ.php",
            type: 'post',
            dataType: 'json',
            data: {gr: gr},
            success: function (data) {

                $("#wrapper ul.bom").empty();  //-- очистка списка
                $(".nameGroup").html('<span data-id-cat=' + gr + '>' + nameTitle + '</span>');  //--  ВЫВОД ИМЕНИ ГРУППЫ В ЗАГОЛОВКЕ

                //-- УДАЛЯЕМ ВСЕ ВЫБОРКИ В СПИСКЕ
                $("#header > select option, #link_add select option").each(function (indx, element) {
                    $(this).attr('selected', '');
                });

                //-- ВЫБИРАЕМ ГРАФУ "ГЛАВНАЯ" В СПИСКЕ
                var nameCat = 0;
                $("#header > select option, #link_add select option").each(function (indx, element) {
                    nameCat = $(this).val();
                    if (nameCat == gr) $(this).attr('selected', 'selected');
                });


                for (var i = 0; i < data.length; i++) {

                    if (data[i]['choise'] == 1) {
                        data[i]['icon'] = data[i]['screen'];
                    }

                    $("#wrapper ul.bom").append(
                        "<li id_number = '" + data[i]['id'] + "' title = '" + data[i]['data'] + "' data-sec = '" + data[i]['timeCreat'] + "'>\
						<div class='item' title='" + data[i]['title'] + "' style ='background: " + data[i]['background'] + "' ><a href='" + data[i]['links'] + "' rel='" + data[i]['group'] + "' target='_blank' style ='background: url(" + data[i]['icon'] + ") no-repeat center/87% 82%;' ></a> <input type='checkbox' class='delMany'  title='Позваляет отметить ссылки для удаления' />\
						\
							<div class='view_link' title='' style ='background: url(" + data[i]['screen'] + ") no-repeat center/100% 100%;' ></div> \
							\
							<div class='screen' title='Показывает полный скриншот страницы'><a href='" + data[i]['full_screen'] + "' target='_blank'></a></div> \
							\
							<div class='apdate'  title='Позваляет изменить параметры ссылки'></div>\
							\
							<div class='del'  title='Удаляет данную ссылку'></div>\
							\
							<div class='number'>" + data[i]['number'] + "</div> \
						\
						</div>\
						\
						<h3>\
							<a href='" + data[i]['links'] + "' title='" + data[i]['name'] + "' target='_blank'>" + data[i]['name'] + "</a>\
						</h3>\
					</li>");
                }

                $('#all_group').slideUp(100);
                $('#modal_wind').slideUp(100);
                $('#wrap_form').slideUp(100);
                $("#all_group ul").empty();

            }
        });
    });


//------------  ОБНОВЛЕНИЕ ЭЛЕМЕНТА  ------------------------
    $('#wrapper, #lastTventy').on('click', '.apdate', function () {

        $('#apdate_form').slideToggle(300);
        $('#modal_wind').slideToggle(100);
        $('#wrap_form').slideToggle(100);

        $('#apdate_form select').html('');

        var apDateId = $(this).closest('li').attr('id_number');
        $("#apdate_form").attr('id_elem', apDateId);

        $.ajax({
            url: 'ajax/apdate.php',
            type: 'post',
            dataType: 'json',
            data: {apDateId: apDateId},
            success: function (data) {

                //Вывод имени ссылки
                $("#apdate_form .name").val(data["name"]);

                //Вывод группы ссылки
                var checked;

                for (var i = 0; i < allGroupName.length; i++) {

                    if (allGroupName[i]['id'] == data["group_id"]) {
                        checked = "selected";
                    } else {
                        checked = "";
                    }

                    $("#apdate_form select").append("<option value='" + allGroupName[i]['id'] + "' " + checked + ">" + allGroupName[i]['name'] + "</option>");
                }

                //Вывод группы ссылки в скрытое поле
                // var groupFirst = $('#apdate_form option:selected').text();
                var groupFirst = $('h1.nameGroup span').attr('data-id-cat');
                $("#apdate_form .hidGroup").val(groupFirst);

                //Вывод самой ссылки на страницу
                $("#apdate_form .links").val(data["links"]);

                //Вывод заднего фона ссылки
                // $("#apdate_form .background_2").attr('value',data["background"]); //todo
                $("#apdate_form .background_2").val(data["background"]);

                //Флажок определ. использ. фона
                if (data["choise"] == 1) {
                    var choise = $('#apdate_form .choise_back').prop("checked", true);
                }

                //Вывод описания ссылки
                $("#apdate_form .title").val(data["title"]);
            }
        });
    });


//------------  ОБНОВЛЕНИЕ ЭЛЕМЕНТА 2  ----------------
    $('#apdate_form .but_send').click(function () {

        var apDate = new Array();

        //ID изменяемой ссылки
        apDate[0] = $("#apdate_form").attr('id_elem');

        //Нахождение имени ссылки
        apDate[1] = $('#apdate_form .name').val();

        //Нахождение id группы ссылки
        apDate[2] = $('#apdate_form option:selected').val();

        //Нахождение имени группы ссылки
        apDate[9] = $('#apdate_form option:selected').text();

        //Нахождение первоначальной группы ссылки
        apDate[8] = $('#apdate_form .hidGroup').val();

        //Нахождение адресса ссылки на странице
        apDate[3] = $('#apdate_form .links').val();

        //Нахождение заднего фона ссылки
        apDate[4] = $('#apdate_form .background_2').val();

        //Определения выбора фона ссылки (иконка или изображение)
        $('#apdate_form .choise_back').prop("checked") ? apDate[5] = 1 : apDate[5] = 0;

        //Определение нужно ли перезаписать данную ссылку или создать новую
        $('#apdate_form .rewriteLink').prop("checked") ? apDate[7] = 1 : apDate[7] = 0;

        //Нахождение описания ссылки
        apDate[6] = $('#apdate_form .title').val();


        if (apDate[1] == "" || apDate[3] == "") {
            alert("Не все требуемые поля заполнены!");
        } else {
            $.ajax({
                url: 'ajax/apdate2.php',
                type: 'post',
                dataType: 'json',
                data: {apDate: apDate},
                success: function (data) {

                    if (data[0] == 6) {
                        alert("Ссылка с таким именем уже существует!");
                    } else {

                        //--  УДАЛЕНИЕ ИЗ СПИСКА ССЫЛКИ С ИЗМЕНЕННОЙ ГРУППОЙ
                        if (!$('#header .addGroup:checkbox').attr("checked")) {

                            if (data[0] == 4) {
                                //--  ВНЕШНЕЕ УДАЛЕНИЕ ЭЛЕМЕНТА ИЗ СИСТЕМЫ
                                $("#wrapper li").each(function () {
                                    if ($(this).attr('id_number') == apDate[0]) {
                                        $(this).remove();
                                    }
                                });

                                //--  НУМЕРОВАНИЕ ЭЛЕМЕНТОВ
                                $("#wrapper .number").each(function (indx, element) {
                                    $(element).text(indx + 1);
                                });
                            }
                        }


                        //=====  CREATE ICONS AND SCREENSHOT
                        $.ajax({
                            url: 'ajax/screenIcon.php',
                            type: 'post',
                            dataType: 'json',
                            data: {idLin: apDate[0], linLin: apDate[3]},
                            success: function (dataPar) {

                            }
                        });  //--  КОНЕЦ АЯКС ЗАПРОСА


                        if (data[0] == 45) {
                            $.ajax({
                                url: 'ajax/screenIcon.php',
                                type: 'post',
                                dataType: 'json',
                                data: {idLin: data[1], linLin: apDate[3]},
                                success: function (dataPar) {

                                }
                            });  //--  КОНЕЦ АЯКС ЗАПРОСА
                        }


                        resetForm();


                        var $elem = $("#wrapper li[id_number=" + apDate[0] + "]");
                        if ($elem) {
                            $elem.find('.item a').attr('href', apDate[3]);
                            $elem.find('h3 a').text(apDate[1]).attr('href', apDate[3]);
                            $elem.find('.item').css('background', apDate[4]);
                        }

                        var $elem_2 = $("#lastTventy li[id_number=" + apDate[0] + "]");
                        if ($elem_2) {
                            $elem.find('.item a').attr('href', apDate[3]);
                            $elem.find('h3 a').text(apDate[1]).attr('href', apDate[3]);
                            $elem_2.find('.item').css('background', apDate[4]);
                        }
                    }
                }
            });
        } //-- IF проверки пустых строк
    });


//--  ГЛАВНАЯ ФУНКЦИЯ ВЫВОДА ЭЛЕМЕНТОВ КАТЕГОРИИ
    function dat(data) {
        for (var i = 0; i < data.length; i++) {

            if (data[i]['choise'] == 1) {
                data[i]['icon'] = data[i]['screen'];
            }

            $("#wrapper ul.bom").append(
                "<li id_number = '" + data[i]['id'] + "' title = '" + data[i]['data'] + "' data-sec = '" + data[i]['timeCreat'] + "'>\
					<div class='item' title='" + data[i]['title'] + "' style ='background: " + data[i]['background'] + "' ><a href='" + data[i]['links'] + "' rel='" + data[i]['group'] + "' target='_blank' style ='background: url(" + data[i]['icon'] + ") no-repeat center/87% 82%;' ></a> <input type='checkbox' class='delMany'  title='Позваляет отметить ссылки для удаления' />\
					\
						<div class='view_link' title='' style ='background: url(" + data[i]['screen'] + ") no-repeat center/100% 100%;' ></div> \
						\
						<div class='screen' title='Показывает полный скриншот страницы'><a href='" + data[i]['full_screen'] + "' target='_blank'></a></div> \
						\
						<div class='apdate'  title='Позваляет изменить параметры ссылки'></div>\
						\
						<div class='del'  title='Удаляет данную ссылку'></div>\
						\
						<div class='number'>" + data[i]['number'] + "</div> \
					\
					</div>\
					\
					<h3>\
						<a href='" + data[i]['links'] + "' title='" + data[i]['name'] + "' target='_blank'>" + data[i]['name'] + "</a>\
					</h3>\
				</li>");
        }
    }

//-----
});


//----  функция создания отступа контент. части
function heightZn() {
    var znTopHg = $(".menuCat").outerHeight(true) + topOffset;
    $("body").css({"paddingTop": znTopHg});
}


//----  RESET FORM UPDATE LINK
function resetForm() {
    $('#wrap_form input').removeAttr("checked");
    $('#wrap_form input, #wrap_form textarea').val('');
    $('#link_add, #group_add, #apdate_form, #all_group').slideUp(500);
    $('#link_add, #group_add, #apdate_form, #all_group').slideUp(500);
    $("#all_group ul.list").text('');
    $('#modal_wind').slideUp(300);
    $('#wrap_form').slideUp(300);
    $('#wrap_form').trigger('reset');
}


//----  SET TOP OFFSET FOR MENU
function setTopOffset() {

    var winBr = $(window).width();

    if ( winBr >= 1060) topOffset = 15;
    if ( winBr < 1060) topOffset = 45;
    if ( winBr <= 560) topOffset = 70;

    heightZn();
}


//=====  CREATE ELEMENT TOP MENU
function elemMenu(id, sec, date, classVis, name ) {

    var zn_view = "";
    if (!(classVis * 1)) zn_view = "no-vis";

    return $elem = "<li " +
                       "data-id='"+id+"' " +
                       "data-sec='"+sec+"' " +
                       "data-time='"+date+"'" +
                       "class='"+zn_view+"'" +
                    ">" +
                           "<h3>" +
                                "<a title='"+name+"' >" + name + "</a>" +
                           "</h3>" +
                   "</li>";
}


//======  ADD NEW LAST ELEMENT
function lastElemLinkAdd() {

    $.ajax({
        url: "ajax/ajax.php",
        type: 'post',
        dataType: 'json',
        data: {query: {'offset': (countElemAll - countElemAdd), 'count': countElemAdd}},
        success: function (data) {

            for (var i = 0; i < data.length; i++) {

                if (data[i]['choise'] == 1) {
                    data[i]['icon'] = data[i]['screen'];
                }

                $("#lastTventy ul.bom").append(
                    "<li id_number = '" + data[i]['id'] + "' title = '" + data[i]['data'] + "' data-sec = '" + data[i]['timeCreat'] + "'>\
									<div class='item' title='" + data[i]['title'] + "' style ='background: " + data[i]['background'] + "' ><a href='" + data[i]['links'] + "' rel='" + data[i]['group_id'] + "' target='_blank' style ='background: url(" + data[i]['icon'] + ") no-repeat center/87% 82%;' ></a> <input type='checkbox' class='delMany'  title='Позваляет отметить ссылки для удаления' />\
									\
										<div class='view_link' title='' style ='background: url(" + data[i]['screen'] + ") no-repeat center/100% 100%;' ></div> \
										\
										<div class='screen' title='Показывает полный скриншот страницы'><a href='" + data[i]['full_screen'] + "' target='_blank'></a></div> \
										\
										<div class='apdate'  title='Позваляет изменить параметры ссылки'></div>\
										\
										<div class='del'  title='Удаляет данную ссылку'></div>\
										\
										<div class='number'>" + data[i]['number'] + "</div> \
									\
									</div>\
									\
									<h3>\
										<a href='" + data[i]['links'] + "' title='" + data[i]['name'] + "' target='_blank'>" + data[i]['name'] + "</a>\
									</h3>\
								</li>");
            } //-- КОНЕЦ ЦИКЛА

            //--  РАСЧЁТ ЭЛЕМЕНТОВ
            $("#lastTventy .number").each(function (indx, element) {
                $(element).text(indx + 1);
            });

            //-- SCROLL UP
            $('html,body').animate({scrollTop: 0}, 'slow');

            countElemAll += countElemAdd;
            $('.addLastNew').text(countElemAll);
        }

    }); //-- КОНЕЦ АЯКС-ЗАПРОСА
}