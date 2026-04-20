<table id="productDetailsTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

<thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Product Name</th>
      <th scope="col">Price</th>
    </tr>
  </thead>

<tbody class="tableBody">

    <!-- SHOULD BE EMPTY -->



    
    
  </tbody>

</table>


<script>

    var productTable;

     $(function(){

  //ALL USER TABLE
   if (!$.fn.DataTable.isDataTable('#productDetailsTable')) {
        productTable = $('#productDetailsTable').DataTable({
            pageLength: 10,
            order: [[0, "asc"]],
            columnDefs: [{
                orderable: false,
                targets: 2
            }]
        });
    }
    
 

  $.ajax({

    url: "<?php echo base_url("all_product") ?>",
    type: "GET",
    dataType: "json",

    success: function(response){
        if(response.success)
        {

            // loop to fetch all products:

            $.each(response.data, function(index, item){

            productTable.row.add([
                item.id,
                item.p_name,
                item.price,
            ])

            });
            productTable.draw();

            console.log(response.data);


        }
    }


  });

   });


</script>