function change(id){
  $.ajax({
    type: "GET",
    url: "change",
    success: function(response){
      $("#code").val(response.message);
    }
  });
}