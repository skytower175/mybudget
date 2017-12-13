
var categories;

function populateCategories(){
    $.getJSON("ajax.php?get=cat", function(json){
        categories = json;
    });
}

function checkRow(cb) {
    var toChange = cb.val() == '1';
    var row = $(cb).closest("tr.edit-row");
    var btn = row.find("input[name='save']");
    btn[0].disabled = !toChange;

    //Stopped using toggleClass because there was problems with it
    if (toChange) {
        row.addClass('chn');
        btn.removeClass('disabled');
    }
    else {
        row.removeClass('chn');
        btn.addClass('disabled');
    }
}

function saveChange(btn) {
    function getItem(row, name){
        return row.find("[name='" + name + "']");
    }
    var row = $(btn).closest("tr.edit-row");
    var inp = $(row).find('input, textarea');
    for (var i = 0; i < inp.length; i++){
        if (!(inp[i].checkValidity())){
            alert('Validation failed - please check the values you entered.');
            return;
        }
    }
    var id = row.find("[data-name='idStr'] span.orig").html();
    var data = Object();
    data.idStr = id;
    data.name = getItem(row, 'name').val();
    data.description = getItem(row, 'description').val();
    data.price = getItem(row, 'price').val();
    data.categoryId = getItem(row, 'category').val();
    data.cluster = getItem(row, 'cluster').val();
    data.quote = getItem(row, 'quote').is(':checked');
    data.sponsored = getItem(row, 'sponsored').is(':checked');
    data.unit = getItem(row, 'unit').val();
    var url = 'ajax.php?update=item&id=' + id;
    console.log(url);
    $.ajax({
        url: url,
        type: 'POST',
        //data: {"data": data},
        data: {"data": JSON.stringify(data)},
        success: function(data) {
            alert("Update may have been successful");
            //var cb = row.find("input[name='tochange']");
            //cb.val(0);
            //checkRow(cb);
            replaceNew(row);
            exitEdit(btn);
            console.log(data);
        },
        error: function(e){
            alert("There was an error");
        }
    });
    console.log(btn);
}

function enterEdit(btn) {
    var row = $(btn).closest('tr.edit-row');
    row.find("td:not([data-name=controls])").each(function(){
        //console.log(this);
        var nt = makeInput(this);
        if (nt !== '')
        {
            $(this).find('span.orig').hide();
            $(this).append(nt);
        }
    });
    var editctrl = "<span class='editctrl'>";
    editctrl += "<button type='button' name='undo' class='btn btn-warning' onclick='exitEdit(this);'><span class='rowicon glyphicon glyphicon-ban-circle'></span>Undo</button>";
    editctrl += "<button type='button' name='save' class='btn btn-success' onclick='saveChange(this);'><span class='rowicon glyphicon glyphicon-ok-circle'></span>Save</button>";
    //editctrl += "<input type='button' name='save' value='Save' onclick='saveChange(this);'/>";
    editctrl += "</span>";
    row.find("td[data-name=controls]").append(editctrl);
    row.addClass("inedit");
    $(btn).hide();
}

function replaceNew(row){
    row.find("td:not([data-name=controls])").each(function(){
        var inp = $(this).find('input, textarea, select');
        var val = inp.val();
        if (inp.is('[type="checkbox"]')){
            val = inp.is(':checked') ? 1 : 0;
        }
        var orig = $(this).find('span.orig');
        if ($(this).data('val') != '')
            $(this).data('val', val);
        var txt;
        switch ($(this).data('name')){
            case 'quote':
            case 'sponsored':
                txt = val == 1 ? 'Yes' : 'No';
                break;
            case 'category':
                var catName = (categories.filter(function(obj){
                    return obj.id == val;
                })[0]).name;
                txt = '(' + val + ') ' + catName;
                break;
            case 'price':
                txt = '$' + val;
                break;
            default:
                txt = val;
                break;
        }
        orig.html(txt);
    });
}

function exitEdit(btn){
    var row = $(btn).closest('tr.edit-row');
    //replaceNew(row); //TODO remove this line!
    row.removeClass('intedit');
    row.find('span.editctrl').remove();
    row.find('button[name=edit]').show();
    row.find('span.orig').show();
    row.find("td:not([data-name=controls])").find('input, textarea, select').remove();
}

function makeInput(item){
    var ostr = '';
    var vl = $(item).find('span.orig').html();
    var name = $(item).data('name');
    switch(name){
        case 'name':
            ostr = '<input type="text" name="name" value="' + vl + '"/>';
            break;
        case 'cluster':
            ostr = '<input type="text" name="cluster" value="' + vl + '"/>';
            break;
        case 'description':
            ostr = '<textarea name="description" rows="5">' + vl + '</textarea>';
            break;
        case 'unit':
            ostr = '<input type="text" name="unit" value="' + vl + '"/>';
            break;
        case 'quote':
            vl = $(item).data('val');
            select = vl == '1' ? 'checked' : '';
            ostr = '<input type="checkbox" name="quote" ' + select + '/>';
            break;
        case 'sponsored':
            vl = $(item).data('val');
            select = vl == '1' ? 'checked' : '';
            ostr = '<input type="checkbox" name="sponsored" ' + select + '/>';
            break;
        case 'price':
            vl = $(item).data('val');
            ostr = '<input type="text" name="price" pattern="\\d+(\\.\\d+)?" value="' + vl + '"/>';
            break;
        case 'category':
            vl = $(item).data('val');
            ostr = '<select name="category" class="edit-item">';
            $.each(categories, function(key, val){
                var sel = vl == val.id ? 'selected' : '';
                ostr += '<option value="' + val.id + '" ' + sel + '>' + val.name + '</option>';
            });
            ostr += '</select>';
            break;
        default:
            break;
    }
    return ostr;
}

$(document).ready(function() {
    populateCategories();
    console.log(categories);
    $('#tblItems').DataTable();
    $('#dvLoading').hide();
    $('#tblItems').css('visibility', 'visible');
} );
