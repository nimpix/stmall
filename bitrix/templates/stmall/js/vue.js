//window.onload = function () {
    //КОЛИЧЕСТВО В ИЗБРАННОМ
    //             var curCount = parseInt(document.getElementById('fav-count').innerHTML.replace(/ /g, ""));
    //             //Создаем Vue экземпляр
    //             var wishcount = new Vue({
    //                 el: '#wishcount',
    //                 data: {
    //                     count: curCount
    //                 },
    //                 computed: {
    //                     getNewCount: function () {
    //                         this.count += 1;
    //                     },
    //                     minusNewCount: function () {
    //                         this.count = this.count - 1;
    //                     }
    //                 }
    //             });
                //Прослушиваем событие только на странице продукта
                // var prod = document.querySelector('.bx-catalog-element');
                // if(prod){
                //     if (prod.classList.contains('product')) {
                //         var fav = document.querySelector('.add_to_fav');
                //         fav.addEventListener('click', function () {
                //             wishcount.getNewCount;
                //         }, true);
                //     }
                // }
                //Событие на странице избранного
                // var prod = document.querySelector('.favor'),
                //     fav = document.querySelector('.basket-item-actions-remove');
                //
                // if(prod && fav){
                //   //  let index,flag = false;
                //     // for(index = 0; index<prod.length;index++){
                //     //     if (prod[index].classList.contains('favor')) {
                //     //         flag = true;
                //     //     }
                //     // }
                //    // if(flag){
                //     fav.addEventListener('click', function () {
                //         wishcount.getNewCount;
                //     }, true);
                //    // }
                // }

    //КОЛИЧЕСТВО В ИЗБРАННОМ КОНЕЦ


    // initializeTimer(); // вызываем функцию инициализации таймера
    // initializeTimer('timer2',189);
    // initializeTimer('timer3',439);
    //
    // function initializeTimer(item,offset) {
    //     var itemId = item;
    //     if (!item) itemId = 'timer1';
    //     if (!offset) offset = 0;
    //     var curDate = new Date();
    //     var curDateYear = curDate.getFullYear();
    //     var curDateMonth = curDate.getMonth();
    //     var curDateDay = curDate.getDay();
    //     var curDateHours = curDate.getHours();
    //     var curDateMinutes = curDate.getMinutes();
    //     var curDateSeconds = curDate.getSeconds();
    //     var endDate = new Date(curDateYear,curDateMonth,curDateDay-3,0,0+offset,0,0); // получаем дату истечения таймера
    //     var currentDate = new Date(); // получаем текущую дату
    //     var seconds = (endDate-currentDate) / 1000; // определяем количество секунд до истечения таймера
    //     if (seconds > 0) { // проверка - истекла ли дата обратного отсчета
    //         var minutes = seconds/60; // определяем количество минут до истечения таймера
    //         var hours = minutes/60; // определяем количество часов до истечения таймера
    //         minutes = (hours - Math.floor(hours)) * 60; // подсчитываем кол-во оставшихся минут в текущем часе
    //         hours = Math.floor(hours); // целое количество часов до истечения таймера
    //         seconds = Math.floor((minutes - Math.floor(minutes)) * 60); // подсчитываем кол-во оставшихся секунд в текущей минуте
    //         minutes = Math.floor(minutes); // округляем до целого кол-во оставшихся минут в текущем часе
    //
    //         // let dec = Math.random(1,10);
    //         // dec = Math.round(dec);
    //         // hours += dec;
    //
    //         setTimePage(hours,minutes,seconds,itemId); // выставляем начальные значения таймера
    //
    //         function secOut() {
    //             if (seconds == 0) { // если секунду закончились то
    //                 if (minutes == 0) { // если минуты закончились то
    //                     if (hours == 0) { // если часы закончились то
    //                         showMessage(timerId); // выводим сообщение об окончании отсчета
    //                     }
    //                     else {
    //                         hours--; // уменьшаем кол-во часов
    //                         minutes = 59; // обновляем минуты
    //                         seconds = 59; // обновляем секунды
    //                     }
    //                 }
    //                 else {
    //                     minutes--; // уменьшаем кол-во минут
    //                     seconds = 59; // обновляем секунды
    //                 }
    //             }
    //             else {
    //                 seconds--; // уменьшаем кол-во секунд
    //             }
    //             setTimePage(hours,minutes,seconds,itemId); // обновляем значения таймера на странице
    //         }
    //         timerId = setInterval(secOut, 1000) // устанавливаем вызов функции через каждую секунду
    //     }
    //     else {
    //        console.log("Установленная дата уже прошла");
    //     }
    // }
    //
    // function setTimePage(h,m,s,itemId) { // функция выставления таймера на странице
    //     var element = document.getElementById(itemId); // находим элемент с id = timer
    //         element.innerHTML = h+":"+m+":"+s;
    // }
    //
    // function showMessage(timerId) { // функция, вызываемая по истечению времени
    //     clearInterval(timerId); // останавливаем вызов функции через каждую секунду
    // }

//}
