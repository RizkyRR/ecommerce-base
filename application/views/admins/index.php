<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Version 2.0</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div id="show-info-dashboard"></div>
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

  <!-- Calendar Main Content -->
  <section class="content">
    <div class="row">
      <div class="alert-notification col-lg-12"></div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-body no-padding">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /. box -->
      </div>
      <!-- /.col -->
    </div>
  </section>
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    getAllInfoDashboard();
    getNetSalesData();
    getNetPurchaseData();
    getGoodsAvailableForSale();
    getCostOfGoodsSold();
    getUserCount();
    getUserOnline();
    getProductCount();
    getProductSold();
    getProductReturn();

    function getAllInfoDashboard() {
      var html = '';
      var i;
      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getAllDashDetail',
        dataType: 'JSON',
        async: true,
        success: function(data) {
          for (i = 0; i < data.length; i++) {
            html += '<div class="col-md-4 col-sm-6 col-xs-12">' +
              '<div class="info-box" title="' + data[i].title + '">' +
              '<span class="info-box-icon ' + data[i].name + '"><i class="' + data[i].value + '" aria-hidden="true"></i></span>' +

              '<div class="info-box-content">' +
              '<span class="info-box-text">' + data[i].title + '</span>' +
              '<span class="info-box-number"><p class="' + data[i].class_id_number + '"></p></span>' +
              '</div>' +
              '</div>' +
              '</div>';
          }

          $('#show-info-dashboard').html(html);
        }
      });
    }

    function getNetSalesData() {
      // https://www.dumetschool.com/blog/cara-membuat-format-uang-rupiah-dengan-jquery

      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getNetSalesData',
        dataType: 'JSON',
        success: function(data) {
          $('.net-sales').attr("data-a-sign", "Rp. ");
          $('.net-sales').attr("data-a-dec", ",");
          $('.net-sales').attr("data-a-sep", ".");
          $('.net-sales').html(data).autoNumeric();
        }
      })
    }

    function getNetPurchaseData() {
      // https://www.dumetschool.com/blog/cara-membuat-format-uang-rupiah-dengan-jquery

      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getNetPurchaseData',
        dataType: 'JSON',
        success: function(data) {
          $('.net-purchase').attr("data-a-sign", "Rp. ");
          $('.net-purchase').attr("data-a-dec", ",");
          $('.net-purchase').attr("data-a-sep", ".");
          $('.net-purchase').html(data).autoNumeric();
        }
      })
    }

    function getGoodsAvailableForSale() {
      // https://www.dumetschool.com/blog/cara-membuat-format-uang-rupiah-dengan-jquery

      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getGoodsAvailableForSale',
        dataType: 'JSON',
        success: function(data) {
          $('.goods-available-for-sale').attr("data-a-sign", "Rp. ");
          $('.goods-available-for-sale').attr("data-a-dec", ",");
          $('.goods-available-for-sale').attr("data-a-sep", ".");
          $('.goods-available-for-sale').html(data).autoNumeric();
        }
      })
    }

    function getCostOfGoodsSold() {
      // https://www.dumetschool.com/blog/cara-membuat-format-uang-rupiah-dengan-jquery

      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getCostOfGoodsSold',
        dataType: 'JSON',
        success: function(data) {
          $('.cost-of-goods-sold').attr("data-a-sign", "Rp. ");
          $('.cost-of-goods-sold').attr("data-a-dec", ",");
          $('.cost-of-goods-sold').attr("data-a-sep", ".");
          $('.cost-of-goods-sold').html(data).autoNumeric();
        }
      })
    }

    function getUserCount() {
      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getUserCount',
        dataType: 'JSON',
        success: function(data) {
          $('.user-count').html(data);
        }
      })
    }

    function getUserOnline() {
      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getUserOnline',
        dataType: 'JSON',
        success: function(data) {
          $('.user-online').html(data);
        }
      })
    }

    function getProductCount() {
      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getProductCount',
        dataType: 'JSON',
        success: function(data) {
          $('.total-product').html(data);
        }
      })
    }

    function getProductSold() {
      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getProductSold',
        dataType: 'JSON',
        success: function(data) {
          $('.total-product-sold').html(data);
        }
      })
    }

    function getProductReturn() {
      $.ajax({
        type: 'GET',
        url: '<?php echo base_url(); ?>admin/getProductReturn',
        dataType: 'JSON',
        success: function(data) {
          $('.total-product-return').html(data);
        }
      })
    }

    // CALENDAR SETUP //

    $.validator.setDefaults({
      highlight: function(element) {
        $(element).closest(".form-group").addClass("has-error");
      },
      unhighlight: function(element) {
        $(element).closest(".form-group").removeClass("has-error");
      },
      errorElement: "span",
      errorClass: "error-message",
      errorPlacement: function(error, element) {
        if (element.parent(".input-group").length) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      },
    });

    var $validator = $("#form-event").validate({
      rules: {
        title: {
          required: true,
        },
      },
      messages: {
        title: {
          required: "Event's title is required!",
        },
      },
    });

    $(".input-datetime").datetimepicker({
      //language:  'fr',
      format: "yyyy-mm-dd hh:ii:00",
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1,
    });

    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();
    var currentDate; // Holds the day clicked when adding a new event
    var currentEvent; // Holds the event object when editing an event

    // var indonesia = moment().tz("Asia/Jakarta");
  });

  var base_url = "<?php echo base_url(); ?>";

  // Fullcalendar
  $("#calendar").fullCalendar({
    header: {
      left: "prev, next, today",
      center: "title",
      right: "month,agendaWeek,agendaDay,listMonth",
    },
    // Get all events stored in database
    contentHeight: 400,
    height: 300,
    forceEventDuration: true,
    defaultDate: moment().format("YYYY-MM-DD h:mm:ss"),
    eventLimit: true, // allow "more" link when too many events
    eventSources: [{
      events: function(start, end, timezone, callback) {
        $.ajax({
          url: "admin/getEvents",
          // type: 'get',
          dataType: "json",
          data: {
            // hypothetical feed requires UNIX timestamps
            start: start.unix(),
            end: end.unix(),
          },
          success: function(data) {
            var events = data.events;
            callback(events);
          },
        });
      },
    }, ],
    selectable: true,
    selectHelper: true,
    editable: true, // Make the event resizable true
    select: function(start, end, allDay) {
      $("#modal-event .modal-title").html("Add New Event");

      $("#title").val("");
      $("#description").val("");
      $("#modal-event input[name=start_date]").val(
        moment(start).format("YYYY-MM-DD h:mm:ss")
      );
      $("#modal-event input[name=end_date]").val(
        moment(end).format("YYYY-MM-DD h:mm:ss")
      );
      $("#color").val("#008000");

      $("#modal-event .delete-event").hide();
      $("#modal-event #btnUpdate").hide();
      $("#modal-event #btnSave").show();

      $(".form-group").removeClass("has-error"); // clear error class
      $(".help-block").empty(); // clear error string
      // $('#form-event')[0].reset();

      $("#modal-event").modal("show");

      $("#calendar").fullCalendar("unselect");
    },
    eventDrop: function(event, delta, revertFunc, start, end) {
      editDropResize(event);
    },
    eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
      editDropResize(event);
    },
    eventClick: function(event, element) {
      $(".modal-title").html(event.title);

      $("#modal-event input[name=id]").val(event.id);
      $("#modal-event input[name=start_date]").val(
        moment(event.start).format("YYYY-MM-DD h:mm:ss")
      );
      $("#modal-event input[name=end_date]").val(
        moment(event.end).format("YYYY-MM-DD h:mm:ss")
      );
      $("#modal-event input[name=title]").val(event.title);
      $("#modal-event textarea[name=description]").val(event.description);
      $("#modal-event select[name=color]").val(event.color);

      $("#modal-event .delete-event").show();
      $("#modal-event #btnUpdate").show();
      $("#modal-event #btnSave").hide();
      $("#modal-event").modal("show");

      editData(event);
      deleteData(event);
    },
    // Event Mouseover
    eventRender: function(event, element) {
      element.popover({
        title: event.title,
        content: event.description,
        html: true,
        animation: "true",
        trigger: "hover",
        placement: "auto",
        container: "body",
      });
      // element.find('.fc-title').append("<br/>" + event.description);
    },

    // CALENDAR SETUP //

  });

  function addNew() {
    $("#btnSave").text("Saving..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable
    var eventData;

    var $valid = $("#form-event").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: "admin/saveEvent",
        type: "POST",
        data: $("#form-event").serialize(),
        dataType: "JSON",
        success: function(data) {
          if (data.status == true) {
            //if success close modal and reload ajax table
            eventData = {
              id: data.id,
              title: $("#modal-event input[name=title]").val(),
              description: $("#modal-event textarea[name=description]").val(),
              start: moment(
                $("#modal-event input[name=start_date]").val()
              ).format("YYYY-MM-DD h:mm:ss"),
              end: moment($("#modal-event input[name=end_date]").val()).format(
                "YYYY-MM-DD h:mm:ss"
              ),
              color: $("#modal-event select[name=color]").val(),
            };

            $("#calendar").fullCalendar("refetchEvents", eventData, true); // stick? = true

            $("#form-event")[0].reset();
            $(".alert-notification").html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              "</div>"
            );
            $("#modal-event").modal("hide");

            // table.ajax.reload(null, false);

            hide_notify();
          } else {
            $(".alert-notification").html(
              '<div class="alert alert-danger alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
              data.notif +
              "</div>"
            );

            hide_notify();
          }

          $("#btnSave").text("Save"); //change button text
          $("#btnSave").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $(".alert-notification").html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
            "There is something wrong, please try again!" +
            "</div>"
          );

          hide_notify();
          $("#btnSave").text("save"); //change button text
          $("#btnSave").attr("disabled", false); //set button enable
        },
      });
      return false;
    }
  }

  function editDropResize(event) {
    start = event.start.format("YYYY-MM-DD h:mm:ss");
    if (event.end) {
      end = event.end.format("YYYY-MM-DD h:mm:ss");
    } else {
      end = start;
    }

    $.ajax({
      url: "admin/dragUpdateEvent",
      type: "POST",
      // data: 'calendar_id=' + event.id + '&title=' + event.title + '&start_date=' + start + '&end_date=' + end,
      data: {
        id: event.id,
        title: event.title,
        start_date: start,
        end_date: end,
      },
      dataType: "JSON",
      success: function(data) {
        if (data.status) {
          $(".alert-notification").html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            data.notif +
            "</div>"
          );
        } else {
          $(".alert-notification").html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
            data.notif +
            "</div>"
          );
        }

        hide_notify();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $(".alert-notification").html(
          '<div class="alert alert-danger alert-dismissible">' +
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
          '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
          "There is something wrong, please try again!" +
          "</div>"
        );
        hide_notify();
      },
    });
  }

  function editData(event) {
    $(":submit").click(function() {
      var $valid = $("#form-event").valid();
      if (!$valid) {
        // $validator.focusInvalid();
        $("#btnUpdate").text("Update"); //change button text
        $("#btnUpdate").attr("disabled", false); //set button enable
        return false;
      } else {
        // ajax adding data to database
        $.ajax({
          type: "POST",
          url: "admin/updateEvent",
          data: {
            id: event.id,
            title: $("#title").val(),
            description: $("#description").val(),
            start_date: moment(
              $("#modal-event input[name=start_date]").val()
            ).format("YYYY-MM-DD h:mm:ss"),
            end_date: moment($("#modal-event input[name=end_date]").val()).format(
              "YYYY-MM-DD h:mm:ss"
            ),
            color: $("#color").val(),
          },
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) {
              //if success close modal and reload ajax table
              event = {
                title: $("#modal-event input[name=title]").val(),
                description: $("#modal-event textarea[name=description]").val(),
                start: moment(
                  $("#modal-event input[name=start_date]").val()
                ).format("YYYY-MM-DD h:mm:ss"),
                end: moment($("#modal-event input[name=end_date]").val()).format(
                  "YYYY-MM-DD h:mm:ss"
                ),
                color: $("#modal-event select[name=color]").val(),
              };
              /* event.title = $('#modal-event input[name=title]').val();
              event.description = $('#modal-event textarea[name=description]').val();
              event.start = moment($('#modal-event input[name=start_date]').val()).format('YYYY-MM-DD h:mm:ss');
              event.end = moment($('#modal-event input[name=end_date]').val()).format('YYYY-MM-DD h:mm:ss');
              event.color = $('#modal-event select[name=color]').val(); */

              $("#calendar").fullCalendar("updateEvents", event, true); // stick? = true
              $("#calendar").fullCalendar("refetchEvents");

              $("#modal-event input[name=id]").val(0);
              $("#form-event")[0].reset();

              $(".alert-notification").html(
                '<div class="alert alert-success alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
                data.notif +
                "</div>"
              );
              $("#modal-event").modal("hide");

              // table.ajax.reload(null, false);

              hide_notify();
            } else {
              $(".alert-notification").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
                data.notif +
                "</div>"
              );

              hide_notify();
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $(".alert-notification").html(
              '<div class="alert alert-danger alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
              "There is something wrong, please try again!" +
              "</div>"
            );

            hide_notify();
          },
        });
      }
    });
  }

  function deleteData(event) {
    $("#modal-event .delete-event").click(function() {
      $.ajax({
        url: "admin/deleteEvent",
        type: "POST",
        data: {
          id: event.id,
        },
        dataType: "JSON",
        success: function(data) {
          $("#calendar").fullCalendar("removeEvents", event._id);

          $("#modal-event").modal("hide");
          $("#form-event")[0].reset();
          $("#modal-event input[name=id]").val(0);

          $(".alert-notification").html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            "Event has been successfully deleted!" +
            "</div>"
          );
          hide_notify();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $(".alert-validation").html(
            '<div class="box-body">' +
            '<div class="form-group">' +
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
            "There is something wrong about the server, please refresh!" +
            "</div>" +
            "</div>" +
            "</div>"
          );
          hide_notify();
        },
      });
    });
  }

  function hide_notify() {
    $(".alert-notification").show(1000);
    setTimeout(function() {
      $(".alert-notification").fadeOut(1000);
    }, 2000);
  }
</script>