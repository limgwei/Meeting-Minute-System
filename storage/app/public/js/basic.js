


  function dropDown(number) {

    var currentStatus = $("#dropdown" + number).css("display");

    if (currentStatus == "none") {
      $("#dropdown" + number).css("display", "block");
      $("#icon"+number).attr("src","/minut/public/storage/image/dropdown.png");
    } else {
      $("#dropdown" + number).css("display", "none");
      $("#icon"+number).attr("src","/minut/public/storage/image/dropup.png");
    }

  }