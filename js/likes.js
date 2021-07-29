function status(idPhoto){

}


function like(arg1){
  $.ajax({
    method: "POST",
    url: "action.php",
    // data: { text: $("p#unbroken").text() }
    data: { text: arg1 }
  })
    // .done(function( response ) {
    //   $("p.broken").html(response);
    // });
}

$(document).ready(function(){


$('label').on('click', function() {

        var self = $(this);
        // НАйти id фотографии (последний симвой атрибута for)
        var idPhoto = self.attr('for').slice(-1);
        like(idPhoto);
        // Текущее количество лайков
        var old = self.children('b').text();

        isActive = self.attr('class');


        if (isActive == 'like'){
          self.attr('class', 'dislike');
          self.css('fill', 'black');
          // чтобы не грузить ajax просто вычту на клиенте (при следующей загрузке значение сразу будет верным)
          self.children('b').text(+old - 1);


        } else {
          self.attr('class', 'like');
          self.css('fill', 'red');
          // чтобы не грузить ajax - прибавить на клиенте (при следующей загрузке значение сразу будет верным)
          self.children('b').text(+old +1);


        }

});
});
