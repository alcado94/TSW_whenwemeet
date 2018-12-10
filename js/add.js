
var countDay = $('.input-date').length-1;
var countHour = 1;

$('#AñadirFecha').click( function(){
    countDay++;
    $('.schedule-pos').append('<div class="schedule-day"><label class="string optional" for="user-name">Dia</label><div><input class="input-date" type="date" name="day['+countDay+'][0]" id=""><button class="btn btn-small-day"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div><div class="schedule-date" id="'+countDay+'"><div class="schedule-date-pos"><input type="time" name="day['+countDay+'][1][hourInit]" class="timeIn" id=""><input type="time" name="day['+countDay+'][1][hourEnd]" class="timeIn" id=""></div><button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div><input type="button" value="Añadir Hora" class="btn btn-time"></div>');
    
})

$('body').on('click','.btn-time:not(.btn-time-exist)',function(e){
    countHour++;
    $(this).before('<div class="schedule-date"><div class="schedule-date-pos"><input type="time" name="day['+countDay+']['+countHour+'][hourInit]" class="timeIn" id=""><input type="time" name="day['+countDay+']['+countHour+'][hourEnd]" class="timeIn" id=""></div><button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div>')
    
})

$('body').on('click','.btn-time-exist',function(e){
    countHour++;
    date = $(this).parent().find('.input-date')[0].value;
    $(this).before('<div class="schedule-date"><div class="schedule-date-pos"><input type="time" name="dayNew['+date+']['+countHour+'][hourInit]" class="timeIn" id=""><input type="time" name="dayNew['+date+']['+countHour+'][hourEnd]" class="timeIn" id=""></div><button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div>')
    
})

$('body').on('click','.btn-small',function(e){
    var elem = $(this).parent().get(0).remove();
})


$('body').on('click','.btn-small-day',function(e){
    var parent = $(this).parents('.schedule-day');
    
    parent.remove();
})

$( "#enviarform" ).click(function() {

    var toret = true;

    if(formCorrect(toret))
        $( "#formT" ).submit();
        
});

$( "#enviarformEdit" ).click(function() {

    var toret = true;

    if(formCorrect(toret) & formCorrectEdit())
        $( "#formT" ).submit();
        
});

function formCorrectEdit(){

    $('#alertTitle').remove();
    $('#alertTitle2').remove();

    title = document.getElementById('user-email');

    if(title.value == ''){
        $('.full').append('<span id="alertTitle" class="alert-form">Introduzca un titulo</span>');
        return false;
    }

    contenedoresDiaPre = document.querySelectorAll(".edit-schedule");    
    contenedoresDia = document.querySelectorAll(".schedule-day:not(.edit-schedule)");    

    if(!diasNoRepetidosEdit(contenedoresDia,contenedoresDiaPre)){
        return false;
    }

    for (let index = 0; index < contenedoresDiaPre.length; index++) {
            if( orderInitEndEdit(contenedoresDiaPre[index]) & required(contenedoresDiaPre[index]) 
                & overlapTime(contenedoresDiaPre[index]) ){
                    toret = true;
                }else{
                    return false;
                }
        
    }

    ////////////////////////////////
    if( !diasNoRepetidos(contenedoresDia) ){
        return false;
    }
    if (contenedoresDia.length == 0 & contenedoresDiaPre.length == 0){
        if(!document.getElementById("alertTitle2"))
            $('.errors-date').append('<span id="alertTitle2" class="alert-form">Inserte fechas</span>');
    }
    //Recorre los contenedores insertados mediante js
    for (let index = 0; index < contenedoresDia.length; index++) {

        if( oneDay(contenedoresDia[index]) & orderInitEnd(contenedoresDia[index]) 
            & overlapTime(contenedoresDia[index]) & required(contenedoresDia[index]) & afterActual(contenedoresDia[index])){
            toret = true;
        }else{
            return false;
        }
        
    }

    return toret;

}

function formCorrect(toret){    

    $('#alertTitle').remove();
    $('#alertTitle2').remove();

    title = document.getElementById('user-email');

    if(title.value == ''){
        $('.full').append('<span id="alertTitle" class="alert-form">Introduzca un titulo</span>');
        return false;
    }

    contenedoresDia = document.querySelectorAll(".schedule:not(.pre-schedule-day)");    

    if( !diasNoRepetidos(contenedoresDia) ){
        return false;
    }
    if (contenedoresDia.length == 0){
        if(!document.getElementById("alertTitle2"))
            $('.errors-date').append('<span id="alertTitle2" class="alert-form">Inserte fechas</span>');
    }
    //Recorre los contenedores insertados mediante js
    for (let index = 0; index < contenedoresDia.length; index++) {

        if( oneDay(contenedoresDia[index]) & orderInitEnd(contenedoresDia[index]) 
            & overlapTime(contenedoresDia[index]) & required(contenedoresDia[index]) & afterActual(contenedoresDia[index])){
            toret = true;
        }else{
            return false;
        }
        
    }

    return toret;

}

function afterActual(contenedor){

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    } 
    if(mm<10){
        mm='0'+mm;
    } 
    var today = yyyy+'/'+mm+'/'+dd;

    if ( Date.parse(contenedor.childNodes[1].childNodes[0].value) < Date.parse(today) ) {
        if(!document.getElementById("alertTitle2"))
            $('.errors-date').append('<span id="alertTitle2" class="alert-form">Inserte una fecha posterior a la actual</span>');
        return false
    }
    
    return true;
}

//Comprueba que no haya campos vacios
function required(contenedor){
    
    listmeet = contenedor.querySelectorAll('.schedule-date-pos');

    if ( contenedor.childNodes[1].childNodes[0].value == '' ){
        if(!document.getElementById("alertTitle2"))
            $('.errors-date').append('<span id="alertTitle2" class="alert-form">Inserte todos los valores</span>');
        return false;
    }
    
    for (let index = 0; index < listmeet.length; index++) {
        if( (listmeet[index].childNodes[0].value == '') | (listmeet[index].childNodes[1].value == '') ){
            if(!document.getElementById("alertTitle2"))
                $('.errors-date').append('<span id="alertTitle2" class="alert-form">Inserte todos los valores</span>');
            return false;
        }
    }

    return true;
}

//Comprueba que no se solape los tiempos
function overlapTime(contenedor){
    
    listmeet = contenedor.querySelectorAll('.schedule-date-pos:not(.schedule-date-pos-pre)');
    listmeetpre = contenedor.querySelectorAll('.schedule-date-pos-pre');

    for (let index2 = 0; index2 < listmeetpre.length; index2++) {
        for (let index = 0; index < listmeet.length; index++) {
            if(((listmeet[index].childNodes[0].value > listmeetpre[index2].childNodes[1].value) &
                (listmeet[index].childNodes[0].value < listmeetpre[index2].childNodes[3].value))
                | ((listmeet[index].childNodes[1].value > listmeetpre[index2].childNodes[1].value) &
                    (listmeet[index].childNodes[1].value < listmeetpre[index2].childNodes[3].value))
                    | ((listmeet[index].childNodes[0].value < listmeetpre[index2].childNodes[1].value) &
                        (listmeet[index].childNodes[1].value > listmeetpre[index2].childNodes[3].value))){
                    if(!document.getElementById("alertTitle2"))
                        $('.errors-date').append('<span id="alertTitle2" class="alert-form">No solape horas en un dia</span>');
                    return false;
            }
        }
    }


    for (let index = 0; index < listmeet.length; index++) {
        for (let index2 = index+1; index2 < listmeet.length; index2++) {

            if((listMeet[index].childNodes[0].childNodes[1].value > listMeet[index2].childNodes[0].childNodes[0].value) &
                (listMeet[index].childNodes[0].childNodes[0].value < listMeet[index2].childNodes[0].childNodes[1].value)){
                    if(!document.getElementById("alertTitle2"))
                        $('.errors-date').append('<span id="alertTitle2" class="alert-form">No solape horas en un dia</span>');
                    return false;
            }
        }
    }

    return true;
}

//Comprueba que no se solape los tiempos
function overlapTimeEdit(contenedor){
    
    listmeet = contenedor.querySelectorAll('.schedule-date-pos');

    for (let index = 0; index < listmeet.length; index++) {
        for (let index2 = index+1; index2 < listmeet.length; index2++) {

            if((listMeet[index].childNodes[0].childNodes[1].value > listMeet[index2].childNodes[0].childNodes[0].value) &
                (listMeet[index].childNodes[0].childNodes[0].value < listMeet[index2].childNodes[0].childNodes[1].value)){
                    if(!document.getElementById("alertTitle2"))
                        $('.errors-date').append('<span id="alertTitle2" class="alert-form">No solape horas en un dia</span>');
                    return false;
            }
        }
    }

    return true;
}

//Comprueba que no haya dos fechas repetidas
//CUIDADO NO ESTA LA FECHA QUE PROVIENE DE LOS INPUTS POR DEFAULT
function diasNoRepetidos(contenedoresDia){
    for (let index = 0; index < contenedoresDia.length; index++) {
        for (let index2 = index+1; index2 < contenedoresDia.length; index2++) {

            if(contenedoresDia[index].childNodes[1].childNodes[0].value == contenedoresDia[index2].childNodes[1].childNodes[0].value){
                if(!document.getElementById("alertTitle2"))
                    $('.errors-date').append('<span id="alertTitle2" class="alert-form">No repita fechas</span>');
                return false;
            }
        }        
    }

    return true;
}

//Comprueba que no haya dos fechas repetidas
//CUIDADO NO ESTA LA FECHA QUE PROVIENE DE LOS INPUTS POR DEFAULT
function diasNoRepetidosEdit(contenedoresDia,contenedoresDiaPre){
    for (let index = 0; index < contenedoresDia.length; index++) {
        for (let index2 = 0; index2 < contenedoresDiaPre.length; index2++) {

            if(contenedoresDia[index].childNodes[1].childNodes[0].value == contenedoresDiaPre[index2].childNodes[3].childNodes[1].value){
                if(!document.getElementById("alertTitle2"))
                    $('.errors-date').append('<span id="alertTitle2" class="alert-form">No repita fechas</span>');
                return false;
            }
        }        
    }

    return true;
}

//Comprobar que los inputs de la hora tengan la finalizacion despues del inicio
function orderInitEnd(contenedor){
    listMeet = contenedor.querySelectorAll(".schedule-date")

    for (let index = 0; index < listMeet.length; index++) {
        meet = listMeet[index].childNodes[0].childNodes;
        if (meet[0].value > meet[1].value){
            if(!document.getElementById("alertTitle2"))
                $('.errors-date').append('<span id="alertTitle2" class="alert-form">La hora inicial y final deben estar en orden</span>');
            return false;
        }
    }
    return true;
}

//Comprobar que los inputs de la hora tengan la finalizacion despues del inicio
function orderInitEndEdit(contenedor){
    listMeet = contenedor.querySelectorAll(".schedule-date")

    for (let index = 0; index < listMeet.length; index++) {

        if(listMeet[index].childNodes[0].nodeName == "#text"){
            meet = listMeet[index].childNodes[1].childNodes;
            if (meet[0].value > meet[1].value){
                if(!document.getElementById("alertTitle2"))
                    $('.errors-date').append('<span id="alertTitle2" class="alert-form">La hora inicial y final deben estar en orden</span>');
                return false;
            }
        }else{
            meet = listMeet[index].childNodes[0].childNodes;
            if (meet[0].value > meet[1].value){
                if(!document.getElementById("alertTitle2"))
                    $('.errors-date').append('<span id="alertTitle2" class="alert-form">La hora inicial y final deben estar en orden</span>');
                return false;
            }
        }

        
    }
    return true;
}


//Comprueba que haya un DATA y un MEET
function oneDay(contenedor){
    
    if(contenedor.childNodes[1].childNodes[0].classList.contains('input-date') & 
        contenedor.childNodes[2].childNodes[0].childNodes.length > 1)
        return true;
    if(!document.getElementById("alertTitle2"))
        $('.errors-date').append('<span id="alertTitle2" class="alert-form">Introduzca un fecha</span>');
    return false;
}


