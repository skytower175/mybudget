
var arrValue = 0;
var yesQuestions = new Array(wizArray.length);

document.getElementById("wizInfo").innerHTML=wizArray[0].question;
document.getElementById("actualQuestion").innerHTML=wizArray[arrValue].stepNum + "/" + wizArray.slice(-1)[0].stepNum;

$("#back").click(function () {

    $('html, body').animate({
        scrollTop: $("#wizard").offset().top
    }, 500);

    if(arrValue == (wizArray.slice(-1)[0].stepNum)) {
        arrValue = arrValue - 1;
        $(".wizButtons").show();
        $('#wizFormBody').show();
        $('#wizSubmitForm').hide();
    } else if(wizArray[arrValue].stepNum == 1) {
        $(".wizButtons").hide();
        $('#startQuestion').show();
        $('#wizFormBody').hide();
        $("#back").hide();
    } else {
        arrValue = arrValue - 1;
        document.getElementById("wizInfo").innerHTML=wizArray[arrValue].question;
        document.getElementById("actualQuestion").innerHTML=wizArray[arrValue].stepNum + "/" + wizArray.slice(-1)[0].stepNum;
    }

});

$(".wizButtons").click(function (e) {

    $('html, body').animate({
        scrollTop: $("#wizard").offset().top
    }, 500);

    if(e.target.id == "wizYes"){
        yesQuestions[arrValue] = 1;
    } else {
        yesQuestions[arrValue] = 0;
    }

    if (wizArray[arrValue].stepNum == wizArray.slice(-1)[0].stepNum) {
        arrValue++;
        $(".wizButtons").hide();
        $('#wizSubmitForm').show();
        $('#wizFormBody').hide();
    } else {
        arrValue++;
        document.getElementById("wizInfo").innerHTML = wizArray[arrValue].question;
        document.getElementById("actualQuestion").innerHTML = wizArray[arrValue].stepNum + "/" + wizArray.slice(-1)[0].stepNum;
    }

});

$("#wizSubmit").click(function () {
    $('#wizard').hide();
    $('.toolHeader').show();
    $('.budgetWrap').show();
    $('#wizardText').val('');

    var i;
    for(i=0; i<=yesQuestions.length; i++){
        if(yesQuestions[i] == 1){
            $('#wizardText').val($('#wizardText').val() + wizArray[i].itemIds);
        }
    }

    //re init variables
    arrValue = 0;
    document.getElementById("wizInfo").innerHTML = wizArray[arrValue].question;
    document.getElementById("actualQuestion").innerHTML = wizArray[arrValue].stepNum + "/" + wizArray.slice(-1)[0].stepNum;

    //TODO - get rid of wizardText and do all the stuff directly instead
    var ids = $("#wizardText").val().split(',');
    $("div.item-row").each(function () {
        $(this).addClass('wizard-hide');
        var id = $(this).find("input[name=id]").val();
        for (var i = 0; i < ids.length; i++){
            if (id == ids[i])
                $(this).removeClass('wizard-hide');
        }
    });
    //Function is located in search.js
    updateCategoryPanels();
});

//Start the wizard function.
$("#startStart").click(function () {

    $('#wizFormBody').show();
    $("#wizNo").show();
    $("#wizYes").show();
    $("#back").show();
    $('#startQuestion').hide();
    window.scrollTo(0,document.body.scrollHeight);
});

//If take me back is clicked
$("#startClose").click(function () {
        $('#wizard').hide();
        $('.toolHeader').show();
        $('.budgetWrap').show();
});

//If the close button is clicked display budget planner
$(document).ready(function() {
    $(".wizardClose").click(function () {
        $('#wizard').hide();
        $('.toolHeader').show();
        $('.budgetWrap').show();
    });
});


//this is for displaying the wizard and hiding the budget planner
$(function () {
    $('#clickToWizard').click(function () {
        $('#wizard').show();
        $(".wizButtons").hide();
        $('#startQuestion').show();
        $('#wizFormBody').hide();
        $('#wizSubmitForm').hide();
        $("#back").hide();
        $('.toolHeader').hide();
        $('.budgetWrap').hide();
        $('html, body').animate({
            scrollTop: $("#wizard").offset().top
        }, 500);
        return false;
    });
});
