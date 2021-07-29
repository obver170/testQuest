function addFunc(){
  $.ajax({
    method: "POST",
    url: "action.php",
    data: { text: $("p.unbroken").text() }
  })
    .done(function( response ) {
      $("p.broken").html(response);
    });
}
