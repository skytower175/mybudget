
google.charts.load("visualization", "1", {'packages': ['corechart'], "callback": drawChart});
google.charts.setOnLoadCallback(drawChart);
var chart;
var expenses = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
function drawChart() {
    var tbl = [['Expense', 'Amount']];
    for (var i = 0; i < categories.length; i++) {
        tbl.push([categories[i].name, expenses[i]]);
    }
    var data = google.visualization.arrayToDataTable(tbl);
    var options = {
        title: 'expenses'
    };
    chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}

$('#txtInitial, .amount').on('keyup', function () {
    if ($(this).hasClass('amount')) {
        var amount = $(this).val();
        var price = $(this).closest('div.item-row').find('input[name=price]').val();
        var total = amount * price;
        $(this).closest('div.item-row').find('span.total').text(total);
    }
    var completeTotal = 0;
    var init = parseInt($('#txtInitial').val() || 0);
    var link = "printout.php?in=" + init;

    expenses = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $('div.item-row').each(function(){
        var quantity = parseInt($(this).find('input.amount').val());
        var amount = parseFloat($(this).find('span.total').text()) || 0;
        if (amount !== 0) {
            var id = $(this).find('input[name=id]').val();
            link += '&' + id  + '=' + quantity;
        }
        var category = $(this).find('input[name=category]').val() - 1;
        completeTotal += amount;
        expenses[category] += amount;
    });

    completeTotal = init - completeTotal;
    $('#spnTotal').text(completeTotal);
    $('#printLink').attr('href', link);

    var tbl = [['Expense', 'Amount']];
    for (var i = 0; i < categories.length; i++) {
        tbl.push([categories[i].name, expenses[i]]);
    }
    tbl.push(['remaining', completeTotal]);
    var data = google.visualization.arrayToDataTable(tbl);
    var options = {
        title: 'expenses'
    };
    chart.draw(data, options);
});

$("#resetLink").click(function(){
    $("#searchText").val('');
    $("#wizardText").val('');
    $(".search-hide").removeClass("search-hide");
    $(".wizard-hide").removeClass("wizard-hide");
});

//for the progress bar functionality
$(document).ready(function() {
    $('#spnTotal').bind("DOMSubtreeModified", function () {

        var init_value = $('#txtInitial').val();
        var amount_left = $('#spnTotal').text();

        var percent = parseInt(amount_left, 10) / parseInt(init_value, 10);
        var percent_left = (1 - percent) * 100;
        percent_left = parseInt(percent_left);

        if (percent_left >= 85) {
            $('#success').width(percent_left + '%');
            $("#success").attr('class', 'progress-bar progress-bar-danger');
        } else if (percent_left < 70) {
            $('#success').width(percent_left + '%');
            $("#success").attr('class', 'progress-bar progress-bar-success');
        } else if (percent_left >= 70 || percent_left < 85) {
            $('#success').width(percent_left + '%');
            $("#success").attr('class', 'progress-bar progress-bar-warning');
        } else {
            $('#success').width('0%');
            $("#success").attr('class', 'progress-bar progress-bar-danger');
        }
    });
});

//for the progress bar view summary screen move
$(document).ready(function () {
    $("#viewSummary").click(function() {
        $('html, body').animate({
            scrollTop: $("#heading15").offset().top
        }, 1000);
    });
});
