$("#toggle-lga-table").hide();
$("#toggle-ward-table").hide();
$("#toggle-station-table").hide();
$("#toggle-state-table").hide();
$("#chart-report-ward").hide();
$("#chart-report-lga").hide();
$("#chart-report-polling-station").hide();
$("#chart-report-state").hide();

$("#toggle-state-chart").on("click", function() {
    $("#toggle-state-chart").hide();
    $("#toggle-state-table").show();
    $("#table-report-state").fadeOut();
    $("#chart-report-state").fadeIn();
});

$("#toggle-state-table").on("click", function() {
    $("#toggle-state-chart").show();
    $("#toggle-state-table").hide();
    $("#table-report-state").fadeIn();
    $("#chart-report-state").fadeOut();
});

$("#toggle-lga-chart").on("click", function() {
    $("#toggle-lga-chart").hide();
    $("#toggle-lga-table").show();
    $("#table-report-lga").fadeOut();
    $("#chart-report-lga").fadeIn();
});

$("#toggle-lga-table").on("click", function() {
    $("#toggle-lga-chart").show();
    $("#toggle-lga-table").hide();
    $("#table-report-lga").fadeIn();
    $("#chart-report-lga").fadeOut();
});

$("#toggle-ward-chart").on("click", function() {
    $("#toggle-ward-chart").hide();
    $("#toggle-ward-table").show();
    $("#table-report-ward").fadeOut();
    $("#chart-report-ward").fadeIn();
});

$("#toggle-ward-table").on("click", function() {
    $("#toggle-ward-chart").show();
    $("#toggle-ward-table").hide();
    $("#table-report-ward").fadeIn();
    $("#chart-report-ward").fadeOut();
});

$("#toggle-station-chart").on("click", function() {
    $("#toggle-station-chart").hide();
    $("#toggle-station-table").show();
    $("#table-report-polling-station").fadeOut();
    $("#chart-report-polling-station").fadeIn();
});

$("#toggle-station-table").on("click", function() {
    $("#toggle-station-chart").show();
    $("#toggle-station-table").hide();
    $("#table-report-polling-station").fadeIn();
    $("#chart-report-polling-station").fadeOut();
});