
var countDay = 0;
var countHour = 1;

$('#AñadirFecha').click( function(){
    countDay++;
    $('.schedule-pos').append('<div class="schedule-day"><label class="string optional" for="user-name">Dia</label><div><input class="input-date" type="date" name="day['+countDay+'][0]" id=""><button class="btn btn-small-day"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div><div class="schedule-date"><div class="schedule-date-pos"><input type="time" name="day['+countDay+'][1][hourInit]" id=""><input type="time" name="day['+countDay+'][1][hourEnd]" id=""></div><button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div><input type="button" value="Añadir Hora" class="btn btn-time"></div>');
    
})

$('body').on('click','.btn-time',function(e){
    countHour++;
    $(this).before('<div class="schedule-date"><div class="schedule-date-pos"><input type="time" name="day['+countDay+']['+countHour+'][hourInit]" id=""><input type="time" name="day['+countDay+']['+countHour+'][hourEnd]" id=""></div><button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button></div>')
    
})

$('body').on('click','.btn-small',function(e){
    var elem = $(this).parent().get(0).remove();
})


$('body').on('click','.btn-small-day',function(e){
    var parent = $(this).parents('.schedule-day');
    
    parent.remove();
})

$( "#enviarform" ).click(function() {

    var value = $("#user-email").val();

    if(value.length>0)
    {
        $( "#formT" ).submit();
    }
        
});
