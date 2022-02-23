$(window).on("load", function() {
  $(".addgroup").click(function() {
    $(".group").addClass("group-vi");
    $(".group").removeClass("group");
  });
  commandline = 1;
  in_commandline = 0;
  groupCommand = "";
  files = "";
  var last = $(".id").val();
  var id_new;
  no_reload = 0;

  function controlling(group) {
    if (no_reload == 0) {
      $.ajax({
        type: "POST",
        url: "asssets/php/chat.php",
        data: "type=readID&group=" + group,
        success: function(data) {
          if (data > last) {
            id_new = data;
            loadchat(group);

          } else {
            var init = window.setTimeout(function() {
              controlling(group);
            }, 2000);
          }
          //  alert(data);
        }
      });
    }

  }

  function readID(group) {
    $.ajax({
      type: "POST",
      url: "asssets/php/chat.php",
      data: "type=readID&group=" + group,
      success: function(data) {
        $(".readid").html("<input type='hidden' class='id' value='" + data + "'>");
        last = data;
        controlling(group);
        //  alert(data);
      }
    });
  }

  function loadchat(group) {
    $.ajax({
      type: "POST",
      url: "asssets/php/chat.php",
      data: "type=load&group=" + group + "&id=" + id_new,
      success: function(data) {
        $(".messagesUL").append(data);
        no_reload = 0;
        last = id_new;
        controlling(group);
        $(".messages").animate({
          scrollTop: $(".messagesUL li:last-child").offset().top - $(".messagesUL").offset().top
        }, "slow");
      }
    })
  }

  function readChat(group) {
    $.ajax({
      type: "POST",
      url: "asssets/php/chat.php",
      data: "type=readStart&value=" + group,
      success: function(data) {
        $(".messagesUL").html(data);
        readID(group);
      }
    });
  }
  //Speichert letz gedrückte Gruppe
  var lastGroup = "";

  function readGroups() {
    $.ajax({
      type: "POST",
      url: "asssets/php/groups.php",
      data: "type_group=read",
      success: function(data) {
        $(".groups_contacts").html("" + data + "");
        $(".use").click(function() {
          no_reload = 1;
          commandline = 0;
          var group = $(this).find("li").attr("value");
          if (lastGroup != group) {
            $(".groupSelected").html('  <input type="hidden" class="selectedGroup" name="groupSelecteds" value="' + group + '">');
            $(".nameGroup").html(group);
            no_reload = 0;

            readChat(group);
            lastGroup = group;
          } else {}
        })
      }
    })
    setTimeout(function() {
      readGroups();
    }, 100000);
  }

  $("#Gsub_create").click(function() {
    $.ajax({
      type: "POST",
      url: "asssets/php/groups.php",
      data: "type_group=create&Gname=" + $(".Gname").val() + "&Gpw=" + $(".Gpw").val() + "&Gadmins=" + $(".Gadmins").val(),
      success: function(data) {
        alert("Group Createt");
        readGroups();
      }
    })
  })


  readGroups();



  //-----end for Froups
  //----start chat

  $(".commandline").click(function() {
    no_reload = 1;
    $(".messagesUL").html("");
    lastGroup = "";
    $(".selectedGroup").val("");
    $(".nameGroup").html("Commandline");
    commandline = 1;
  });



  function commandlines(group, message) {
    //alert(group+""+message);
    var splitMessage = message.split("->");
    $(".messagesUL").append("<li class='sent'><img src='http://emilcarlsson.se/assets/mikeross.png'  /><p>" + message + "</p></li>");
    if (message == "remove_chat_value") {
      $.ajax({
        type: "POST",
        url: "asssets/php/commandline.php",
        data: "type=removeChatValue&message=" + message + "&group=" + group,
        success: function(data) {
          if (data != "") {
            setTimeout(function() {
              $(".messagesUL").append(data);
            }, 1000);

          }
        }
      })
    } else if (splitMessage[0] == "add_member") {
      $.ajax({
        type: "POST",
        url: "asssets/php/commandline.php",
        data: "type=addMember&user=" + splitMessage[1] + "&group=" + group,
        success: function(data) {
          if (data != "") {
            setTimeout(function() {
              $(".messagesUL").append(data);
            }, 1000);
          }
        }
      })
    } else if (splitMessage[0] == "add_admin") {
      $.ajax({
        type: "POST",
        url: "asssets/php/commandline.php",
        data: "type=addAdmin&user=" + splitMessage[1] + "&group=" + group,
        success: function(data) {
          if (data != "") {
            setTimeout(function() {
              $(".messagesUL").append(data);
            }, 1000);
          }
        }
      })
    } else if (splitMessage[0] == "remove_member") {
      $.ajax({
        type: "POST",
        url: "asssets/php/commandline.php",
        data: "type=removeMember&user=" + splitMessage[1] + "&group=" + group,
        success: function(data) {
          alert(splitMessage[1]);
          if (data != "") {
            setTimeout(function() {
              $(".messagesUL").append(data);
            }, 1000);
          } else {
            alert("dw");
          }
        }
      })
    } else if (splitMessage[0] == "show_table") {
      $.ajax({
        type: "POST",
        url: "asssets/php/commandline.php",
        data: "type=showTable&group=" + group + "&select=" + splitMessage[1],
        success: function(data) {
          if (data != "") {
            setTimeout(function() {
              $(".messagesUL").append(data);
            }, 1000);
          } else {
            alert("dw");
          }
        }
      })
    }
  }


  function newMessage() {

    message = $(".message-input input").val();

    var split_message = message.split("->");
    if ($(".nameGroup").val() == "Commandline" || commandline == 1 || $(".selectedGroup").val() == "") {

      if (split_message[0] == "use") {
        groupCommand = split_message[1];
        $(".groupSelected").html('<input type="hidden" class="selectedGroup" name="groupSelecteds" value="' + groupCommand + '">');
        $.ajax({
          type: "POST",
          url: "asssets/php/commandline.php",
          data: "type=checkAdmin&message=" + split_message[1] + "&group=" + groupCommand,
          success: function(data) {
            if (data != "") {
              $(".messagesUL").append("<li class='sent'><img src='http://emilcarlsson.se/assets/mikeross.png'  /><p>" + message + "</p></li>");
              $('.message-input input').val(null);
              alert("Now you use the Group '" + groupCommand + "'");
              $(".messagesUL").append(data);
              in_commandline = 1;
              commandline = 0;
            } else {
              alert("YOU are NOT Admin in this Group");
            }
          }
        })
      } else if (split_message[0] == "join_group") {

        //alert("hey");
        $.ajax({
          type: "POST",
          url: "asssets/php/commandline.php",
          data: "type=joinGroup&pw=" + split_message[2] + "&group=" + split_message[1],
          success: function(data) {
            if (data != "") {
              $(".messagesUL").append("<li class='sent'><img src='http://emilcarlsson.se/assets/mikeross.png'  /><p>" + message + "</p></li>");
              $('.message-input input').val(null);
              //alert("Now you use the Group '"+groupCommand+"'");
              readGroups();
              $(".messagesUL").append(data);
              in_commandline = 1;
              commandline = 0;
            } else {
              alert("YOU are NOT Admin in this Group");
            }
          }
        })



      }
    } else if (in_commandline == 1) {
      if (message == "session_close") {
        $(".messagesUL").html("");
        lastGroup = "";
        $(".selectedGroup").val("");
        $(".nameGroup").html("Commandline");
        commandline = 1;
      } else {
        commandlines(groupCommand, message);
      }
    } else if (files == 1) {
      alert("ok");


    } else {
      $.ajax({
        type: "POST",
        url: "asssets/php/chat.php",
        data: "type=write&message=" + message + "&group=" + $(".selectedGroup").val(),
        success: function() {
          $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
          $('.message-input input').val(null);
          $('.contact.active .preview').html('<span>You: </span>' + message);
          $(".messages").animate({
            scrollTop: $(".messagesUL li:last-child").offset().top - $(".messagesUL").offset().top
          }, "slow");
        }
      })
    }

    if ($.trim(message) == '') {
      return false;
    }



  };

  function uploadZip(messages) {
    formdata = new FormData(document.forms[0]);

    if (formdata) {
      //$('.main-content').html('<img src="LoaderIcon.gif" />');
      $.ajax({
        url: "asssets/php/fileUploadFunc.php?message=" + messages,
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(res) {
          //  $(".datas").click();
          alert("OK");
        }
      });
    }
  }



  $('.submit').click(function() {
    newMessage();
  });

  $(".message-input").on('keydown', function(e) {
    if (e.which == 13) {
      newMessage();
      return false;
    }
  });


  $(".datas").click(function() {
    $('.submit').click(function() {
      message = $(".message-input input").val();

      uploadZip(message);
    });
    lastGroup = "";
    no_reload = 1;
    $(".idoss").removeClass("idoss");
    //  $(".idosss").addClass("idoss");
    $(".nameGroup").html("Data");
    $.ajax({
      type: "POST",
      url: "asssets/php/fileUpload.php",
      data: "type=readFiles",
      success: function(data) {
        $(".messagesUL").html(data);
      }
    })
  })



})
