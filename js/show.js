$(document).ready(function() {
  $("#btnPrint").printPage({
    url: "print.php",
    attr: "href"
  })

  $(".controls .glyphicon-remove-circle").bind("click", function(){
    var id = $(this).parent(".controls").attr("id");
    var $t = $(this);

    $.ajax({
      type: "POST",
      url: "remove.php",
      data: "id="+id
    })
    .success(function(data, status) {
      $t.parents("tr").remove();
    })
    .fail(function(data, status, error) {
      console.warn(error)
      alert("Wystąpił błąd podczas usuwania!")
    })
  });
});
