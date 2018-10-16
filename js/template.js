"use strict";

//=====  FUNCTION  =======================================

let templElem = {
   titleDesc: {
       delMany: 'Позваляет изменить параметры ссылки',
       update: 'Позваляет изменить параметры ссылки',
       del: 'Удаляет данную ссылку'
   }
};


//=====  PHRATHE TEMPLATE
function templatePhrathe(classElem='',
                         idElem,
                         date,
                         timeCreat,
                         title,
                         background,
                         group,
                         icon,
                         number,
                         name ) {

    let $listItem = `<li
        id_number="${idElem}" title="${date}" data-sec="${timeCreat}">
            <div class="${classElem}" style='background-color: ${background}' >
                <div class='number'>${number}</div>
                <textarea title='${name}'>${name}</textarea>
                <div rel='${group}' style ='background-image: url(${icon});' ></div> <input type='checkbox' class='delMany'  title="${templElem.titleDesc.delMany}" />
                <div class='apdate'  title='${templElem.titleDesc.update}'></div>
                <div class='del'  title='${templElem.titleDesc.del}'></div>
                <textarea title='${title}'>${title}</textarea>
            </div>
        </li>`;




    // "<li id_number = '" + data[i]['id'] + "' title = '" + data[i]['data'] + "' data-sec = '" + data[i]['timeCreat'] + "'>\
		// 				<div class='item 777777777' title='" + data[i]['title'] + "' style ='background: " + data[i]['background'] + "' ><a href='" + data[i]['links'] + "' rel='" + data[i]['group'] + "' target='_blank' style ='background-image: url(" + data[i]['icon'] + ");' ></a> <input type='checkbox' class='delMany'  title='Позваляет отметить ссылки для удаления' />\
		// 				\
		// 					<div class='apdate'  title='Позваляет изменить параметры ссылки'></div>\
		// 					\
		// 					<div class='del'  title='Удаляет данную ссылку'></div>\
		// 					\
		// 					<div class='number'>" + data[i]['number'] + "</div> \
		// 				\
		// 				</div>\
		// 				\
		// 				<h3>\
		// 					<a href='" + data[i]['links'] + "' title='" + data[i]['name'] + "' target='_blank'>" + data[i]['name'] + "</a>\
		// 				</h3>\
		// 			</li>"

    return $listItem;
}