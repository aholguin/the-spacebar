$(document).ready(function(){

$(".js-like-article").on("click",function(e){

    e.preventDefault();
    var link = $(e.currentTarget)
    console.log(link);
    link.toggleClass("fa-heart-o").toggleClass("fa-heart")
    $(".js-like-article-count").html("TEST");
});

});