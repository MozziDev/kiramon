$(".site-index").on("click",".toFavorites",function(){
    let resultAjax;

    let data = {
        'address': $(this).data('address')
    };
    sendAjax('/site/in-favorites', data, 'json').done(function (data){
        resultAjax = data;
    })

    $.pjax.reload({
        container: '#validatorsList',
    });
});

$(".site-index").on("click",".fromFavorites",function(){
    let resultAjax;

    let data = {
        'address': $(this).data('address')
    };
    sendAjax('/site/from-favorites', data, 'json').done(function (data){
        resultAjax = data;
    })

    $.pjax.reload({
        container: '#validatorsList',
    });
});

function sendAjax(url,data,type){
    return $.ajax({
        url: url,
        type: 'POST',
        data: data,
        async: false,
        dataType: type
    });
}