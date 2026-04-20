
    
<table id="userDetailsTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

<thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Created at</th>
    </tr>
  </thead>

<tbody class="tableBody">

    <!-- SHOULD BE EMPTY -->



    
    
  </tbody>

</table>



<script>

  var userTable;

  $(function(){

  //ALL USER TABLE
   if (!$.fn.DataTable.isDataTable('#userDetailsTable')) {
        userTable = $('#userDetailsTable').DataTable({
            pageLength: 10,
            order: [[0, "asc"]],
            columnDefs: [{
                orderable: false,
                targets: 2
            }]
        });
    }


  });





function loadUser(){

  $.ajax({

    url: "<?php echo base_url('get_users_data') ?>",
    type: "GET",
    dataType: 'json',

    success: function(response)
    {
      if(response.success)
      {

      // LOOP - for fetching all users
      $.each(response.message, function(index, item){

      userTable.row.add([
        item.id,
        item.f_name,
        item.l_name,
        item.phone,
        item.created_at
      ])

      });
      userTable.draw();


        console.log(response.message);

      }
    }

  })
}




loadUser()






</script>



