<!-- <div class="flex">

<button id="latest-two" type="button" class="text-white btn bg-info mb-5">
                Latest 2 Orders of each User
</button>

<button id="all-orders" type="button" class="text-white btn bg-warning mb-5">
                All orders
</button>

</div> -->


    
<table id="userDetailsTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

<thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
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

        loadUser()
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
        item.email,
        // item.created_at
        '<button id="latestOrder" type="button" data-id="' + item.id +'" class="btn btn-success view_latest_order" data-bs-toggle="modal" data-bs-target="#viewLatestTwoOrders">View Latest Orders</button>',


      ])

      });
      userTable.draw();


        console.log(response.message);

      }
    }

  })
}




</script>



