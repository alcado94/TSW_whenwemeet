
$('.divTableColumn').click( function() {
    
    var id = $(this).attr('id');
    
    var ids = $('.divTableColumnScheduleShow');
    if ($('#'+id+'Sched').hasClass('divTableColumnScheduleShow')){
        $('#'+id+'Sched').removeClass('divTableColumnScheduleShow');
    }else{
        
        ids.removeClass('divTableColumnScheduleShow');
        $('#'+id+'Sched').toggleClass('divTableColumnScheduleShow');
    }
    
});

$('[id^="participate"]').click(function() {

    var elem = $(this);
    var id = elem.attr('id');

    console.log(id);
    console.log('#m'+id);


    if ( elem.is(':checked') ){
        $('#m'+id).prop('checked', true);
    }else{
        $('#m'+id).prop('checked', false);
    }

    
});

$('[id^="mparticipate"]').click(function() {

    var elem = $(this);
    var id = elem.attr('id').substring(1);

    console.log(id);
    console.log('#'+id);

    if ( elem.is(':checked') ){
        $('#'+id).prop('checked', true);
    }else{
        $('#'+id).prop('checked', false);
    }

    
});


$( "#enviarParticipar" ).click(function() {

        $( "#form" ).submit();
        
});
