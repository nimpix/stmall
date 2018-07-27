window.onload = function () {

        initializeTimer(); // вызываем функцию инициализации таймера
        initializeTimer('timer2',189);
        initializeTimer('timer3',439);
  

    function initializeTimer(item,offset,newDate) {
        var itemId = item;
        if (!item) itemId = 'timer1';
        if (!offset) offset = 0;
        var curDate = new Date();
        var curDateYear = curDate.getFullYear();
        var curDateMonth = curDate.getMonth();
        var curDateDay = curDate.getDate();
        var curDateHours = curDate.getHours();
        var curDateMinutes = curDate.getMinutes();
        var curDateSeconds = curDate.getSeconds();
        var endDate = new Date(curDateYear,curDateMonth,curDateDay+1,0,0+offset,0,0); // получаем дату истечения таймера
        var currentDate = new Date(); // получаем текущую дату
        if (currentDate>endDate) endDate = newDate;
        var seconds = (endDate-currentDate) / 1000; // определяем количество секунд до истечения таймера
          //console.log(endDate+"/"+currentDate+"/"+seconds);
        if (seconds > 0) { // проверка - истекла ли дата обратного отсчета
            var minutes = seconds/60; // определяем количество минут до истечения таймера
            var hours = minutes/60; // определяем количество часов до истечения таймера
            minutes = (hours - Math.floor(hours)) * 60; // подсчитываем кол-во оставшихся минут в текущем часе
            hours = Math.floor(hours); // целое количество часов до истечения таймера
            seconds = Math.floor((minutes - Math.floor(minutes)) * 60); // подсчитываем кол-во оставшихся секунд в текущей минуте
            minutes = Math.floor(minutes); // округляем до целого кол-во оставшихся минут в текущем часе


            setTimePage(hours,minutes,seconds,itemId); // выставляем начальные значения таймера

            function secOut() {
                if (seconds == 0) { // если секунду закончились то
                    if (minutes == 0) { // если минуты закончились то
                        if (hours == 0) { // если часы закончились то
                            showMessage(timerId); // выводим сообщение об окончании отсчета
                        }
                        else {
                            hours--; // уменьшаем кол-во часов
                            minutes = 59; // обновляем минуты
                            seconds = 59; // обновляем секунды
                        }
                    }
                    else {
                        minutes--; // уменьшаем кол-во минут
                        seconds = 59; // обновляем секунды
                    }
                }
                else {
                    seconds--; // уменьшаем кол-во секунд
                }
                setTimePage(hours,minutes,seconds,itemId); // обновляем значения таймера на странице
            }
            timerId = setInterval(secOut, 1000) // устанавливаем вызов функции через каждую секунду
        }
        else {
            //console.log("Обновление даты прошло");
            curDateDay +=4;
            var nDate = new Date(curDateYear,curDateMonth,curDateDay,0,0+offset,0,0);
            initializeTimer(itemId,offset,nDate);
        }
    }

    function setTimePage(h,m,s,itemId) { // функция выставления таймера на странице
        var ih = '',im = '',is = '';
        if(h<10) ih = 0;
        if(m<10) im = 0;
        if(s<10) is = 0;
        var element = document.getElementById(itemId); // находим элемент с id = timer

        if(element){
            element.innerHTML = "<div class='timer-wrapper'><span>"+ih+h+"</span><div class='word-timer'>часов</div></div>" +
                "<div class='sep'>:</div><div class='timer-wrapper'><span>"+im+m+"</span><div class='word-timer'>минут</div></div>" +
                "<div class='sep'>:</div><div class='timer-wrapper'><span>"+is+s+"</span><div class='word-timer'>секунд</div></div>";
        }
    }

    function showMessage(timerId) { // функция, вызываемая по истечению времени
        clearInterval(timerId); // останавливаем вызов функции через каждую секунду
    }

}
