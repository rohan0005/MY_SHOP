<?php 
include(APPPATH . "modules/product/views/add_product_modal.php");
 ?>

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
            
        
        // LOADING ALL THE PRODUCT IN THE PAGE
        loadProduct();
            
        })


    
   // ADDING NEW PRODUCT  


    $("#addProductBtn").click(function(){

    var productName = $("#productName").val();
    var productPrice = $("#productPrice").val();



        $.ajax({
        url:  "<?php  echo base_url("add_product")?>",
        type:   "POST",
        dataType: "json",

        data: {
            productName : productName,
            productPrice : productPrice,
        },

        success: function(response)
        {
            
            $("#addProductModal").modal("hide");

            loadProduct()
            showToast(response.message);

        }


    });
    });


function loadProduct(){

  $.ajax({

    url: "<?php echo base_url("all_product") ?>",
    type: "GET",
    dataType: "json",

    success: function(response){
        if(response.success)
        {
            // console.log("all products", response.data), 



            // loop to fetch all products:

            productTable.clear();


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

}


</script>