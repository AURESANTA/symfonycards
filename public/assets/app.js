$(".nav-link").onclick(function(e) {
    e.preventDefault();
    var form = $(this);
    var id = $("#id_user").val();
    var url = this.href;
    $.ajax({
        type: "GET",
        url: url,
        success: getUser,
    });
    function getUser(card){
        {$('#maDiv').empty().append('Nom : ' + card.cardname + ' | Groupe : ' + card.cardname)}
    }
});