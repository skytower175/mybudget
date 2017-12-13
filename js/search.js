$("#searchText").on("keyup", function () {
    var input = $(this).val().toLowerCase();
    $("div.item-row").each(function () {
        var thisText = $(this).text().toLowerCase();
        if (thisText.indexOf(input) !== -1){
            $(this).removeClass('search-hide');
        }
        else{
            $(this).addClass('search-hide');
        }
    });
    updateCategoryPanels();
});

/* This function is also called in wizard.js */
function updateCategoryPanels(){
    $("div.category-panel").each(function(){
        var ll = ($(this).find('div.item-row:not(.search-hide):not(.wizard-hide)')).length;
        if (ll == 0){
            $(this).addClass('search-hide');
        }
        else{
            $(this).removeClass('search-hide');
        }
    });
}

$("#searchText").on("change", function () {
    var input = $(this).val();
    if (input == '') return;
    var url = "ajax.php?log=" + encodeURIComponent(input);
    console.log("Search URL:", url);
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data) {
            console.log("search logged");
        },
        error: function(e){
            console.log("error logging search");
        }
    });
});
