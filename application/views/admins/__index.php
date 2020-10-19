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
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">CPU Traffic</span>
            <span class="info-box-number">90<small>%</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Likes</span>
            <span class="info-box-number">41,410</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Sales</span>
            <span class="info-box-number">760</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">New Members</span>
            <span class="info-box-number">2,000</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

  <!-- Calendar Main Content -->
  <section class="content">
    <div class="row">
      <div class="alert alert-notification col-lg-9"></div>
    </div>

    <div class="row">
      <div class="col-md-9">
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

      <div class="col-md-3">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Urgent List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <th>Date</th>
                <th>Event</th>
              </tr>
              <tr>
                <td>183</td>
                <td>John Doe</td>
              </tr>
              <tr>
                <td>219</td>
                <td>Alexander Pierce</td>
              </tr>
              <tr>
                <td>657</td>
                <td>Bob Doe</td>
              </tr>
              <tr>
                <td>175</td>
                <td>Mike Doe</td>
              </tr>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $.validator.setDefaults({
      highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
      },
      errorElement: 'span',
      errorClass: 'error-message',
      errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    var $validator = $("#form-event").validate({
      rules: {
        title: {
          required: true,
        }
      },
      messages: {
        title: {
          required: "Event\'s title is required!"
        }
      }
    });

    $('.input-datetime').datetimepicker({
      //language:  'fr',
      format: 'yyyy-mm-dd hh:ii:00',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });

    var date = new Date();
    var currentDate; // Holds the day clicked when adding a new event
    var currentEvent; // Holds the event object when editing an event

    $("#color").colorpicker(); // Colopicker

    var base_url = "<?php echo base_url(); ?>"; // Here i define the base_url

    // Fullcalendar
    $("#calendar").fullCalendar({
      header: {
        left: "prev, next, today",
        center: "title",
        right: "month, agendaWeek, agendaDay, listMonth",
      },
      // Get all events stored in database
      defaultDate: moment().format('YYYY-MM-DD h:mm:ss'),
      eventLimit: true, // allow "more" link when too many events
      selectable: true,
      selectHelper: true,
      editable: true, // Make the event resizable true
      eventSources: [{
        events: function(start, end, timezone, callback) {
          $.ajax({
            url: '<?php echo base_url(); ?>admin/getEvents',
            // type: 'get',
            dataType: 'json',
            data: {
              // hypothetical feed requires UNIX timestamps
              start: start.unix(),
              end: end.unix()
            },
            success: function(data) {
              var events = data.events;
              callback(events);
            }
          })
        }
      }],
      select: function(start, end) {
        $("#start_date").val(moment(start).format("YYYY-MM-DD h:mm:ss"));
        $("#end_date").val(moment(end).format("YYYY-MM-DD h:mm:ss"));

        // Open modal to add event
        modal({
          // Available buttons when adding
          buttons: {
            add: {
              id: "add-event", // Buttons id
              css: "btn-success", // Buttons class
              label: "Add", // Buttons label
            },
          },
          title: "Add Event", // Modal title
        });
      },
      eventDrop: function(event, delta, revertFunc, start, end) {
        start = event.start.format("YYYY-MM-DD h:mm:ss");
        if (event.end) {
          end = event.end.format("YYYY-MM-DD h:mm:ss");
        } else {
          end = start;
        }

        $.post(
          "admin/dragUpdateEvent", {
            id: event.id,
            title: event.title,
            start_date: start,
            end_date: end,
          },
          function(data) {
            if (data.status) {
              $('.alert-notification').html(
                '<div class="alert alert-success alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
                data.notif +
                '</div>'
              );
            } else {
              $('.alert-notification').html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
                data.notif +
                '</div>'
              );
            }

            hide_notify();
            $("#calendar").fullCalendar("refetchEvents");
          }
        );
      },
      eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
        start = event.start.format("YYYY-MM-DD h:mm:ss");
        if (event.end) {
          end = event.end.format("YYYY-MM-DD h:mm:ss");
        } else {
          end = start;
        }

        $.post(
          "admin/dragUpdateEvent", {
            id: event.id,
            title: event.title,
            start_date: start,
            end_date: end,
          },
          function(data) {
            if (data.status) {
              $('.alert-notification').html(
                '<div class="alert alert-success alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
                data.notif +
                '</div>'
              );
            } else {
              $('.alert-notification').html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
                data.notif +
                '</div>'
              );
            }

            hide_notify();
            $("#calendar").fullCalendar("refetchEvents");
          }
        );
      },
      // Get detail hover
      eventRender: function(event, element) {
        element.popover({
          title: event.title,
          content: event.description,
          html: true,
          animation: 'true',
          trigger: 'hover',
          placement: 'auto',
          container: 'body'
        });
        // element.find('.fc-title').append("<br/>" + event.description);
      },
      // Handle Existing Event Click
      eventClick: function(calEvent, jsEvent, view) {
        // Set currentEvent variable according to the event clicked in the calendar
        currentEvent = calEvent;

        // Open modal to edit or delete event
        modal({
          // Available buttons when editing
          buttons: {
            delete: {
              id: "delete-event",
              css: "btn-danger",
              label: "Delete",
            },
            update: {
              id: "update-event",
              css: "btn-success",
              label: "Update",
            },
          },
          title: 'Edit Event "' + calEvent.title + '"',
          event: calEvent,
          start: calEvent.start.format("YYYY-MM-DD h:mm:ss"),
          end: calEvent.end.format("YYYY-MM-DD h:mm:ss"),
        });
      },
    });

    // Prepares the modal window according to data passed
    function modal(data) {
      // Set modal title
      $(".modal-title").html(data.title);
      // Clear buttons except Cancel
      $('.modal-footer button:not(".btn-default")').remove();
      // Set input values
      $("#title").val(data.event ? data.event.title : "");
      $("#description").val(data.event ? data.event.description : "");

      // moment($('#start_date').val(data.event ? moment(data.event.start).format('YYYY-MM-DD h:mm:ss') : moment().format('YYYY-MM-DD h:mm:ss'))).format('YYYY-MM-DD h:mm:ss');

      if (data.event) {
        $("#start_date").val(data.event.start);
      } else {
        $("#start_date").val();
      }

      // moment($('#end_date').val(data.event ? moment(data.event.end).format('YYYY-MM-DD h:mm:ss') : moment().add(1, 'days').format('YYYY-MM-DD h:mm:ss'))).format('YYYY-MM-DD h:mm:ss'); // or it can be add by hours
      if (data.event) {
        $("#end_date").val(data.event.end);
      } else {
        $("#end_date").val();
      }

      $("#color").val(data.event ? data.event.color : "#008000");
      // Create Butttons
      $.each(data.buttons, function(index, button) {
        $(".modal-footer").prepend(
          '<button type="button" id="' +
          button.id +
          '" class="btn ' +
          button.css +
          '">' +
          button.label +
          "</button>"
        );
      });
      //Show Modal
      $("#modal-event").modal("show");
    }

    // Handle Click on Add Button
    $("#modal-event").on("click", "#add-event", function(e) {
      if (validator(["title", "description"])) {
        $.post(
          "admin/saveEvent", {
            title: $("#title").val(),
            description: $("#description").val(),
            color: $("#color").val(),
            start: start,
            end: end,
          },
          function(data) {
            $('.alert-notification').html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );

            $("#modal-event").modal("hide");
            $("#calendar").fullCalendar("refetchEvents");

            hide_notify();
          }
        );
      }
    });

    // Handle click on Update Button
    $("#modal-event").on("click", "#update-event", function(e) {
      if (validator(["title", "description"])) {
        $.post(
          "admin/updateEvent", {
            id: currentEvent.id,
            title: $("#title").val(),
            description: $("#description").val(),
            color: $("#color").val(),
            star_date: moment($('#modal-event input[name=start_date]').val()).format('YYYY-MM-DD h:mm:ss'),
            end_date: moment($('#modal-event input[name=end_date]').val()).format('YYYY-MM-DD h:mm:ss'),
          },
          function(data) {
            $('.alert-notification').html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );

            $("#modal-event").modal("hide");
            $("#calendar").fullCalendar("refetchEvents");

            hide_notify();
          }
        );
      }
    });

    // Handle Click on Delete Button
    $("#modal-event").on("click", "#delete-event", function(e) {
      $.get("admin/deleteEvent?id=" + currentEvent._id, function(data) {
        $('.alert-notification').html(
          '<div class="alert alert-success alert-dismissible">' +
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
          '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
          data.notif +
          '</div>'
        );

        $("#modal-event").modal("hide");
        $("#calendar").fullCalendar("refetchEvents");
        hide_notify();
      });
    });

    function hide_notify() {
      $('.alert-notification').show(1000);
      setTimeout(function() {
        $('.alert-notification').fadeOut(1000);
      }, 3000);
    }

    // Dead Basic Validation For Inputs
    function validator(elements) {
      var errors = 0;
      $.each(elements, function(index, element) {
        if ($.trim($("#" + element).val()) == "") errors++;
      });
      if (errors) {
        $(".error").html("Please insert title and description");
        return false;
      }
      return true;
    }
  });
</script>