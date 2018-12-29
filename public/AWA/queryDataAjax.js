"use strict";
function queryDataAjax($url) {
  /*
   * code base class formHTML php
   * voir class formHTML
   */
  // new form ajax
  var formdata = new FormData();

  // select input  form html type string =>>> darori class form-control-file
  var formdatahtml = document.getElementsByClassName("form-string");
  // add data string to from ajax (name value)
  for (var i = 0; i < formdatahtml.length; i++) {

    formdata.append(formdatahtml[i].name, formdatahtml[i].value);
  }
  // select input  form html type string childs =>>> darori class form-childs
  var formdatahtmlchilds = document.getElementsByClassName("form-childs");
  // add data string to from ajax (childs value,value,value,value)
  for (var i = 0; i < formdatahtmlchilds.length; i++) {
    var formdatahtmlchild = (formdatahtmlchilds[i]);
    var name = formdatahtmlchild.name;

    for (i = 0; i < formdatahtmlchild.length; i++) {
      //examine current option
      var currentOption = formdatahtmlchild[i];
      //print it if it has been selected
      if (currentOption.selected == true) {
        formdata.append(name, currentOption.value);

      }

    }

  }



  //send formdata par ajax
  var ajax = new XMLHttpRequest();

  ajax.onreadystatechange = function (event) {
    // XMLHttpRequest.DONE === 4
    if (this.readyState === XMLHttpRequest.DONE) {
      if (this.status === 200) {
        console.log(this.responseText);
      } else {
        console.log("Status de la réponse: %d (%s)", this.status, this.statusText);
      }
    }
  };

  ajax.open("POST", $url);

  ajax.send(formdata);



}




                    