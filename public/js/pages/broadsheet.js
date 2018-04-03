var millisec = parseInt(MILISEC);
function page_refresh_stats(){
    $('#loader').show();
    $("#displayChart").hide();
    $.ajax({
        url: STATS, 
        method: "POST",
        data: {
            '_token': TOKEN,
            'slug': SLUG
        },
        success: function(data) {
            $("#loader").hide();
            $('#displayChart').show();
            $('#displayChart').html(data);
            // location.reload();
        },
        complete: function() {}
    });
    
    setTimeout(page_refresh_stats, millisec);
}

$(document).ready(function() {
    //initializing page refresh function
    page_refresh_stats();
}); 