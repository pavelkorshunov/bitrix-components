// ;(function(){
//     "use strict";
//     window.onload = function()
//     {
//         var form = document.querySelector('.hs-form');
//         var arrObjecs = new Array();
//         form.addEventListener('submit', function(e){
//             e.preventDefault();
//             getFormData();
//             sendDataServer();
//         });

//         //Заполняем массив информацией из формы

//         function getFormData()
//         {
//             for( var i = 0; i < form.length; i++)
//             {
//                 arrObjecs.push({
//                     name : form.elements[i].name,
//                     value : form.elements[i].value
//                 });
//             }
//             return arrObjecs;
//         }

//         //Отправляем данные на серввер

//         function sendDataServer()
//         {
//             var xhr = new XMLHttpRequest();

//             xhr.onreadystatechange = function() {
//                 if(xhr.readyState === 4 && xhr.status == 200 || xhr.status == 304) {
//                     console.log(xhr.responseText);
//                 }
//             };

//             var url = window.location.pathname;
//             var data = 'data=' + JSON.stringify(arrObjecs);

//             xhr.open("POST", url);
//             xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//             xhr.send(data);
//         }
//     };
// })();