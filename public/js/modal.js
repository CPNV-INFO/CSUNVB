function showModal(){
    $("#mainModal").modal("toggle");
}

function setTitleModal(content){
    $("#mainModalTitle").html(content);
}

function addBodyModal(content){
    $("#mainModalBody").html($("#mainModalBody").html() + content);
}

function testModal(){
    setTitleModal("aaa");
    addBodyModal("asadfsdfsdf");
    showModal();
}

