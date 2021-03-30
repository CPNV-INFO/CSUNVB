var showSheetsListBtn = document.querySelectorAll('.showSheetsList');
showSheetsListBtn.forEach((item) => {
    item.addEventListener('click', function (event) {
        var state = event.target.dataset.list;
        var elements = document.getElementsByClassName(state+"Sheets");
        for (var i = 0; i < elements.length; i ++) {
            elements[i].classList.remove('d-none');
        }
        $("#show-"+state).addClass('d-none');
        $("#hide-"+state).removeClass("d-none");
        $(this).parent().css("border-radius","10px 10px 0 0");
    }, false);
})

var hideSheetsListBtn = document.querySelectorAll('.hideSheetsList');
hideSheetsListBtn.forEach((item) => {
    item.addEventListener('click', function (event) {
        var state = event.target.dataset.list;
        var elements = document.getElementsByClassName(state+"Sheets");
        for (var i = 0; i < elements.length; i ++) {
            elements[i].classList.add('d-none');
        }
        $("#hide-"+state).addClass('d-none');
        $("#show-"+state).removeClass("d-none");
        $(this).parent().css("border-radius","10px");
    }, false);
})

function print_page(){
    window.print();
}

function flashMessage(message){
    $("#flashMessage").html('<div class="alert alert-info">'+message+'</div>');
}

$(function(){
    $('[data-toggle="tooltip"]').tooltip();
})



function savePosY(){
    sessionStorage.setItem('posY', window.pageYOffset);
}
$(document).ready(function() {
    window.scrollBy(0, sessionStorage.getItem('posY'));
    sessionStorage.removeItem('posY');
});

function alertError(jqXHR,exception){
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    alert(msg);
}

function post(path, parameters) {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", path);
    $.each(parameters, function(key, value) {
        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);
        form.append(field);
    });
    $(document.body).append(form);
    form.submit();
}