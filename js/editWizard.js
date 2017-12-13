
function getSelectedItem() {
    var wiznum = $("#slctWiz").val();
    for (j = 0; j < wizardItems.length; j++)
        if (wizardItems[j].id == wiznum) return wizardItems[j];
    return null;
}

function populateItems(){
    $("#slctInclude").find('option').remove();
    $("#slctRemaining").find('option').remove();
    var chosenWizard = getSelectedItem();
    if (chosenWizard == null) return;
    for (i = 0; i < budgetItems.length; i++) {
        var budgetItem = budgetItems[i];
        var inList = false;
        for (k = 0; k < chosenWizard.itemIds.length; k++) 
            if (chosenWizard.itemIds[k] == budgetItem.idStr) inList = true;
        var lstBox = inList ? $("#slctInclude") : $("#slctRemaining");
        lstBox.append($('<option>', {value: budgetItem.idStr, text: budgetItem.name } ) );
    }
}

function setDisabled(control){
    control.removeClass('enabled');
    control.addClass('disabled');
    control.attr('disabled', 'disabled');
}

function setEnabled(control){
    control.removeClass('disabled');
    control.addClass('enabled');
    control.removeAttr('disabled');
}

function toggleControls(turnOn){
    if (turnOn){
        setEnabled($("#txtName"));
        setEnabled($("#btnSaveName"));
        setEnabled($("#btnDelete"));
    }
    else {
        $("#txtName").val('');
        setDisabled($("#txtName"));
        setDisabled($("#btnSaveName"));
        setDisabled($("#btnDelete"));
        setDisabled($("#btnMoveUp"));
        setDisabled($("#btnMoveDown"));
    }
}

function setButtons(){
    if ($("#slctInclude").val() != null)
        setEnabled($("#btnRight"));
    else
        setDisabled($("#btnRight"));
    
    if ($("#slctRemaining").val() != null)
        setEnabled($("#btnLeft"));
    else
        setDisabled($("#btnLeft"));

    setEnabled($("#btnMoveUp"));
    setEnabled($("#btnMoveDown"));
    var numItems = $("#slctWiz option").length;
    if ($("#slctWiz").val() == null){
        toggleControls(false);
    }
    else {
        toggleControls(true);
    }
    if ($("#slctWiz").prop("selectedIndex") == 0){
        setDisabled($("#btnMoveUp"));
    }
    if ($("#slctWiz").prop("selectedIndex") == numItems - 1){
        setDisabled($("#btnMoveDown"));
    }
}

function refreshControls(){
    var chosenWizard = getSelectedItem();
    if (chosenWizard == null) return;
    $("#txtName").val(chosenWizard.question);
}

function refreshAll(){
    populateItems();
    setButtons();
    refreshControls();
}

function fillWizard(){
    $("#slctWiz").find('option').remove();
    for (i = 0; i < wizardItems.length; i++)
        $("#slctWiz").append($('<option>', {value: wizardItems[i].id, text: wizardItems[i].question } ) );
}


$("#btnNew").on("click", function() {
    var maxId = -1;
    $("#slctWiz option").each(function() {
        if ($(this).val() > maxId)
            maxId = $(this).val();
    });

    var newId = parseInt(maxId) + 1;
    var newItem = { "id": newId, "question": "New Item", "itemIds": [] };
    wizardItems.push(newItem);
    fillWizard();
    $("#slctWiz").val(newId);
    refreshAll();
});

$("#btnDelete").on("click", function() {
    var id = $("#slctWiz").val();
    var index;
    for (var i = 0; i < wizardItems.length; i++)
        if (wizardItems[i].id == id)
            index = i;
    wizardItems.splice(index, 1);
    fillWizard();
    refreshAll();
});

$("#btnMoveUp").on("click", function() {
    var id = $("#slctWiz").val();
    var index;
    for (i = 0; i < wizardItems.length; i++)
        if (wizardItems[i].id == id) index = i;
    if (index < 1) return;
    var newArr = [];
    for (i = 0; i < wizardItems.length; i++){
        if (i == index -1)
            newArr.push(wizardItems[i + 1]);
        else if (i == index)
            newArr.push(wizardItems[i - 1]);
        else
            newArr.push(wizardItems[i]);
    }
    wizardItems = newArr;
    fillWizard();
    $("#slctWiz").val(id);
    refreshAll();
});

$("#btnMoveDown").on("click", function() {
    var id = $("#slctWiz").val();
    var index;
    for (i = 0; i < wizardItems.length; i++)
        if (wizardItems[i].id == id) index = i;
    if (index >= wizardItems.length - 1) return;
    var newArr = [];
    for (i = 0; i < wizardItems.length; i++){
        if (i == index +1)
            newArr.push(wizardItems[i - 1]);
        else if (i == index)
            newArr.push(wizardItems[i + 1]);
        else
            newArr.push(wizardItems[i]);
    }
    wizardItems = newArr;
    fillWizard();
    $("#slctWiz").val(id);
    refreshAll();
});

$("#btnSaveName").on("click", function() {
    var input = $("#txtName").val();
    var chosenWizard = getSelectedItem();
    chosenWizard.question = input;
    var id = chosenWizard.id;
    fillWizard();
    $("#slctWiz").val(id);
    refreshAll();
});

$("#btnSaveAll").on("click", function() {
    var url = "ajax.php?update=wizard";
    $.ajax({
        url: url,
        type: 'POST',
        data: {"wizardItems": JSON.stringify(wizardItems)},
        success: function(data) {
            alert('Update complete.');
        },
        error: function(e) {
            alert('There was an error.');
        }
    });
});

$("#btnLeft").on("click", function() {
    var itemId = $("#slctRemaining").val();
    var chosenWizard = getSelectedItem();
    chosenWizard.itemIds.push(itemId);
    refreshAll();
});

$("#btnRight").on("click", function() {
    var itemId = $("#slctInclude").val();
    var chosenWizard = getSelectedItem();
    var index = chosenWizard.itemIds.indexOf(itemId);
    if (index > -1)
        chosenWizard.itemIds.splice(index, 1);
    refreshAll();
});

$("#slctWiz").on("change", function(){
    refreshAll();
    //refreshControls();
});

$(".swapBox").on("change", function(){
    setButtons();
});

$(document).ready(function() {
    fillWizard();
    refreshAll();
} );
