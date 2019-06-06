$(document).ready(function (e) {
    $('.heart').click(function (event) {
        $.ajax({
            url:'/article/heart/'+$('#article-id').text(),
            method:'POST'
        }).done(function (data) {
            $('.heart').html(data['heart']);
        });
    });

});
