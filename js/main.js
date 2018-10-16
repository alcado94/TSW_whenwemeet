
$('.divTableColumn').click( function() {
    
    var id = $(this).attr('id');
    
    var ids = $('.divTableColumnScheduleShow');
    if ($('#'+id+'Sched').hasClass('divTableColumnScheduleShow')){
        $('#'+id+'Sched').removeClass('divTableColumnScheduleShow');
    }else{
        
        ids.removeClass('divTableColumnScheduleShow');
        $('#'+id+'Sched').toggleClass('divTableColumnScheduleShow');
    }
    
})

