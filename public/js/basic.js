


  function dropDown(number) {

    var currentStatus = $("#dropdown" + number).css("display");

    if (currentStatus == "none") {
      $("#dropdown" + number).css("display", "block");
    } else {
      $("#dropdown" + number).css("display", "none");
    }

  }