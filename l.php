<!DOCTYPE html>

<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, minimum-scale=1.0"/>
    <link href="css/reset.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="css/jquery-ui.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="css/style2.css" rel="stylesheet" type="text/css"/>

    <title>Ссылки</title>

    <!--    <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <!--   <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script> -->
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/template.js"></script>
    <script type="text/javascript" src="js/scriptAjax.js"></script>
    <script type="text/javascript" src="js/categ.js"></script>
</head>

<body>
<div id="sizeElem"></div>
<div id="hideAllCat"></div>
<div id="zoom_screen">
    <div class="down"></div>
</div>

<div id="modal_wind"></div>

<div id="up"></div>
<div id="down"></div>

<div id="header">

    <button id="all_links" title="При нажатии выведет все имеющиеся ссылки">Все Ссылки</button>

    <a href="http://ron17.h19.ru/lin/" target="_blank" class="link-trans"><img src="img/logo.png"/></a>

    <a href="http://ron17.h19.ru/wr/" target="_blank" class="link-trans"><img src="img/logo.png"/></a>

    <select>
    </select>

    <input type="checkbox" class="addGroup" title="Позволяет добовлять новую перечень ссылок к уже выведенным"/>

    <div class="wr_inp_seach">
        <input id="search"/>
        <ul id="sel_ch"></ul>
        <div class="search-clear"></div>
    </div>

    <input type="checkbox" class="glob_search js_glob_search" checked="true" title="Организует глобальный поиск"/>
    <!-- <button id="click" style="pointer-events: none; opacity: 0.5;">CLICK</button>-->

    <button id="all_categories" class="all_categories" title="Вывести все категории">Все Категории</button>

    <button id="addLast">20</button>
    <button id="addLastNew" class="addLastNew js-addLastNew"></button>
    <div class="flg"></div>
    <button id="but_form" title="Добавить ссылку">Доб. ссылку</button>
    <button id="but_group_form" title="Добавить группу">Доб. группу</button>

    <button id="delMnLks">Удаление</button>
    <button id="cancelDelMnLks" title="Отмена удаления отмеченных для удаления ссылок">Отмена</button>

    <ul class='menuCat'></ul>

    <a href="https://www.yandex.ru" id="search_yandex" target="_blank" class="links_header"><span>Яндекс</span></a>
    <a href="https://www.google.ru" id="search_google" target="_blank" class="links_header"><span>Гугл</span></a>
    <a href="https://translate.google.ru" id="transl_google" target="_blank"
       class="links_header"><span>Переводчик</span></a>
    <a href="https://www.youtube.com" id="youtube" target="_blank" class="links_header"><span>YOUTOBE</span></a>

</div><!--  END  but_form  -->


<!--  ФОРМА ДЛЯ ВЫВОДА ВСЕХ ГРУПП  -->
<div id="all_group">
    <div class="close ui-sortable-handle" style=""></div>
    <h2>Все существующие категории</h2>
    <ul class="list sortable ui-sortable">
    </ul>
    <div class="clear"></div>
</div>


<!--  ФОРМА ДЛЯ СОЗДАНИЯ ССЫЛКИ  -->
<div id="wrap_form">


    <!--  ФОРМА ДЛЯ СОЗДАНИЯ ССЫЛКИ  -->
    <div id="link_add" class="sortable">

        <div class="close"></div>

        <form>
            <h2>Добавление Ссылки</h2>

            <h3>Название ссылки</h3>
            <input type="text" name="name" id="name" autofocus=""/>

            <h3>Категория</h3>
            <select>
            </select>

            <h3>Изображение</h3>
            <input type="text" name="img" id="img"/>

            <h3>Фон</h3>
            <div class="wrap-color">
                <input type="color" name="background" class="inp-backgr" value="#74AAF6" id="background"/>
                <div class="wrap-color__cont js-wrap-color__cont">
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ff0000"
                         style="background: #ff0000"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ffff00"
                         style="background: #ffff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#00ff00"
                         style="background: #00ff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#0080ff"
                         style="background: #0080ff"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#8000ff"
                         style="background: #8000ff"></div>
                </div>
            </div>

            <h3>Описание</h3>
            <textarea name="title" id="title"></textarea>

            <input type="button" name="but_send" id="but_send" value="Отправить" accesskey="w"/>
        </form>
    </div><!--  END  link_add  -->


    <!--  ФОРМА ДЛЯ ЗАПИСИ ГРУППЫ -->
    <div id="group_add" class="sortable">
        <div class="close"></div>
        <form>
            <h2>Новая категория</h2>

            <h3>Название Группы</h3>
            <input type="text" id="name_group" autofocus=""/>

            <h3>Фон</h3>
            <div class="wrap-color wrap-color_groop">
                <p class="df">
                    <input type="radio" name="group_backg" class="backgr-rd" value="true" id="backg_group_1" checked/>
                    <input type="color" value="#74AAF6" class="inp-backgr" id="backg_group_color"/>
                </p>
                <div class="wrap-color__cont js-wrap-color__cont">
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ff0000"
                         style="background: #ff0000"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ffff00"
                         style="background: #ffff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#00ff00"
                         style="background: #00ff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#0080ff"
                         style="background: #0080ff"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#8000ff"
                         style="background: #8000ff"></div>
                </div>
            </div>

            <h3>Фон - изображение</h3>
            <p>
                <input type="radio" name="group_backg" value="true" id="backg_group_2"/>
                <input type="text" id="backg_group_img" value="#74AAF6" placeholder="url"/>
            </p>

            <div>
                <label class="check-view">
                    <input type="checkbox" checked="checked" id="menu_view_create" class="menu_view_create" value=""> -
                    отображать в меню
                </label>
            </div>

            <h3>Описание</h3>
            <textarea id="title_group"></textarea>

            <input type="button" id="but_send_group" value="Отправить" accesskey="w"/>
        </form>
    </div><!--  END  group_add  -->


    <!--  ФОРМА ДЛЯ ИЗМЕНЕНИЯ ГРУППЫ -->
    <div id="group_apdate" class="sortable">

        <div class="close"></div>

        <form>
            <h1>Изменить категорию</h1>

            <h3 class="catg_name">Название категории</h3>
            <input type="text" id="name_group" autofocus=""/>

            <h3>Фон</h3>
            <div class="wrap-color wrap-color_groop">
                <p>
                    <input type="radio" name="group_backg" value="true" id="backg_group_1" checked/>
                    <input type="color" value="#fddff5" id="backg_group_color"/>
                </p>
                <div class="wrap-color__cont js-wrap-color__cont">
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ff0000"
                         style="background: #ff0000"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ffff00"
                         style="background: #ffff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#00ff00"
                         style="background: #00ff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#0080ff"
                         style="background: #0080ff"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#8000ff"
                         style="background: #8000ff"></div>
                </div>
            </div>

            <h3>Фон - изображение</h3>
            <p>
                <input type="radio" name="group_backg" value="true" id="backg_group_2"/>
                <input type="text" id="backg_group_img-update" value="" placeholder="url"/>
            </p>
            <div>
                <label class="check-view">
                    <input id="menu_view" class="input input-mod menu_view_create"
                           value="" type="checkbox"> - отображать в меню
                </label>
            </div>

            <h3>Описание</h3>
            <textarea id="title_group"></textarea>

            <input type="button" id="but_send_group_update" value="Отправить" accesskey="w"/>
        </form>
    </div>
    <!--  END  group_apdate  -->


    <!-- ФОРМА ДЛЯ ОБНОВЛЕНИЯ ССЫЛКИ -->
    <div id="apdate_form" class="sortable">

        <div class="close"></div>

        <form>
            <h2>Редактирование Ссылки</h2>

            <h3>Название ссылки</h3>
            <input type="text" name="name" class="name" autofocus=""/>

            <h3>Категория</h3>
            <select>
            </select>

            <input type="hidden" name="hidGroup" class="hidGroup"/>

            <h3>Изображение</h3>
            <input type="text" name="imgCreate" class="imgCreate"/>
            <!--
                <h3>Фон</h3>
            <input type="text" name="background" class="background_1" />
             -->
            <h3>Зданий фон</h3>
            <div class="wrap-color">
                <input type="color" name="background" value="#74AAF6" class="background_2"/>
                <div class="wrap-color__cont js-wrap-color__cont">
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ff0000"
                         style="background: #ff0000"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#ffff00"
                         style="background: #ffff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#00ff00"
                         style="background: #00ff00"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#0080ff"
                         style="background: #0080ff"></div>
                    <div class="wrap-color__item js-wrap-color__item" data-color="#8000ff"
                         style="background: #8000ff"></div>
                </div>
            </div>

            <p>
                <label>
                    <input class="rewriteLink" type="checkbox"/>
                    - отметьте если хотите чтобы была создана новая ссылка
                </label>
            </p>


            <h3>Описание</h3>
            <textarea name="title" class="title"></textarea>

            <input type="button" name="but_send" class="but_send" value="Отправить" accesskey="w"/>
        </form>
    </div><!--  END  link_add  -->

    <!-- -->

</div><!--  END  wrapp_form  -->


<div class="alert_mess"></div>

<!---------->
<div id="lastTventy">

    <h2 class="titlLastGroup">Последние двадцать ссылок</h2>
    <ul class="bom sortable">

    </ul>

    <div class='clear'></div>

</div><!--   END WRAPPER   -->

<!---------->
<div id="wrapper">

    <h1 class="nameGroup"><span data-id-cat="16">Главная</span></h1>
    <ul class="bom sortable">

    </ul>

    <div class='clear'></div>

</div><!--   END WRAPPER   -->


<script>
    $(document).ready(function () {
        $("a[onclick]").click();
    });
</script>

<script type="text/javascript" src="js/script_1.js"></script>

</body>
</html>
