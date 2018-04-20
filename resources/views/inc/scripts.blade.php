<!-- JQuery -->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<!-- Materialize css -->
<script src="{{ asset('materialize-css/js/materialize.min.js') }}" charset="utf-8"></script>

<script type="text/javascript">
  $(".dropdown-button").dropdown();
  // side nav
  $(".button-collapse").sideNav();
  // select
  $('select').material_select();
  // modal
  $('#modal1').modal();
  // modal for help
  $('#modal2').modal();
  // DELETE using link
  $(function () {
      $('.data-delete').on('click', function (e) {
          if (!confirm('Are you sure you want to delete?')) return;
          e.preventDefault();
          $('#form-delete-' + $(this).data('form')).submit();
      });
  });
  // SHARE using link
  $(function () {
      $('.data-share').on('click', function (e) {
          if (!confirm('Are you sure you want to share?')) return;
          e.preventDefault();
          $('#form-share-' + $(this).data('form')).submit();
      });
  });
  // calendar
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false, // Close upon selecting a date,
    format: 'yyyy-mm-dd' // format the date
  });
  // search
  $(function() {
    $('#search').keypress(function(e) {
      if (e.which == 13) {
        console.log('enter pressed');
        e.preventDefault();
        $('#search-form').submit();
      }
    })
  });
  // sort
  $(function() {
    $('#sort').change(function(e) {
      console.log('select changed');
      $('#sort-form').submit();
    });
  });
</script>
<!-- data tables -->
<script src="{{ asset('DataTables/datatables.min.js') }}" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#myDataTable').DataTable({
      "paging": false,
      "dom": '<"right"i>r<"left"f><"clear">'
    });
});
</script>
<!-- for spinner -->
<script>
  document.addEventListener("DOMContentLoaded", function(){
  $('.preloader-background').delay(1000).fadeOut('slow');

  $('.preloader-wrapper')
    .delay(1000)
    .fadeOut();
  });
</script>
<!-- sideNav -->
<script>
$('.button-collapse').sideNav({
    menuWidth: 300, // Default is 300
    edge: 'left', // Choose the horizontal origin
    closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    draggable: true, // Choose whether you can drag to open on touch screens,
  }
);
</script>
<!-- enable/disable based on checkbox -->
<script type="text/javascript">
  $(function () {
      $("#isExpire").click(function () {
          if ($(this).is(":checked")) {
              $("#expirePicker").attr("disabled","disabled");
              $("#expirePicker").focus();
          } else {
              $("#expirePicker").removeAttr("disabled");
          }
      });
  });
</script>
<!-- collapsible -->
<script>
$(document).ready(function(){
  $('.collapsible').collapsible();
});
</script>
<!-- for checkbox multiple delete -->
<script type="text/javascript">
    $(document).ready(function () {

        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))
         {
            $(".sub_chk").prop('checked', true);
         } else {
            $(".sub_chk").prop('checked',false);
         }
        });

        $('.delete_all').on('click', function(e) {

            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            if(allVals.length <=0)
            {
                alert("Please select.");
            }  else {

                var check = confirm("Are you sure you want to delete these?");
                if(check == true){

                    var join_selected_values = allVals.join(",");

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }
            }
        });

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });

        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();

            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });

            return false;
        });
    });
</script>
<!-- switch -->
<script type="text/javascript">
$(".switch").find("input[type=checkbox]").on("change", function() {
  if($(this).prop('checked')) {
    $("#folderView").toggleClass('unshow');
    $("#tableView").toggleClass('unshow');
  } else {
    $("#folderView").toggleClass('unshow');
    $("#tableView").toggleClass('unshow');
  }
});
</script>
