<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest CDN Template</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid mx-2">
        <a class="navbar-brand"><h2 class="text-success">MY SHOP</h2></a>
        <form class="d-flex" role="search">
        <!-- <button class="text-white btn bg-success" type="submit"></button> -->
        <button type="button" class="text-white btn bg-success" data-bs-toggle="modal" data-bs-target="#addModal" data-bs-whatever="@mdo">ADD ORDER</button>

        </form>
    </div>
    </nav>

    <?php $this->load->view($page_content); ?>
    

    <!-- jQuery (Needed for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Place an order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">First Name:</label>
            <input type="text" class="form-control" id="first-name">
          </div>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">Last Name:</label>
            <input type="text" class="form-control" id="last-name">
          </div>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">Phone Number:</label>
            <input type="tel" class="form-control" id="phone_number">
          </div>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">Product Name:</label>
            <input type="text" class="form-control" id="product-name">
          </div>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">Price:</label>
            <input type="number" min="1" class="form-control" id="price">
          </div>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">Quantity:</label>
            <input type="number" min="1" class="form-control" id="quantity">
          </div>
          <div class="mb-1">
            <p>TOTAL: <span class="total_amount"></span></p>
            <input type="hidden" name="total_amount" id="total_amount_hidden" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="orderProduct" class="btn btn-primary ">ORDER</button>
      </div>
    </div>
  </div>
</div> 

    <footer>
        <div class="container mt-5">
            <p class="text-center mt-4">© 2026 MY SHOP. All rights reserved.</p>
        </div>
    </footer>


<script>

    $(function(){

    table = $("#myTable").DataTable({
      "pageLength": 10,
      "order": [[0, "asc"]],
      "columnDefs": [{
        "orderable": false, "targets": 2
      }]
    });

    });

     $("#orderProduct").click(function(){

        var first_name = $("#first-name").val();
            var last_name = $("#last-name").val();
            var phone_number = $("#phone_number").val();
            var product_name = $("#product-name").val();
            var price = parseFloat($("#price").val());
            var quantity = parseInt($("#quantity").val());
            var total_price = price * quantity;


            $.ajax({

            url: "<?php echo base_url('order/place_order'); ?>",
            type: "POST",

            data:{
                f_name : first_name,
                l_name: last_name,
                phone: phone_number,
                product_name: product_name,
                price: price,
                quantity: quantity,
                total_price: total_price,
            },

            dataType: "json",

            success: function(response)
            {

            if(response.success)
            {
                alert(response.message);

                $("#first-name").val("");
                $("#last-name").val("");
                $("#phone_number").val("");
                $("#product-name").val("");
                $("#price").val("");
                $("#quantity").val("");
                
                $("#addModal").modal("hide");
            }
            else
            {
                alert("Error occurred while placing the order.");
            }
                 
            },

            error: function(xhr, status, error)
            {
                alert("AJAX request failed.");
            }




        });


     });

    



</script>

</body>
</html>

<!-- 
    $(function(){

    table = $("#myTable").DataTable({
      "pageLength": 10,
      "order": [[0, "asc"]],
      "columnDefs": [{
        "orderable": false, "targets": 2
      }]
    });


    $(function(){

        // var first_name = $(this).data("first-name");
        // var last_name = $(this).data("last-name");
        // var phone_number = $(this).data("phone-number");
        // var product_name = $(this).data("product-name");
        // var price = $(this).data("price");
        // var quantity = $(this).data("quantity");
        // var total_amount = price * quantity;

        $("#orderProduct").click(function(){
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var phone_number = $("#phone_number").val();
            var product_name = $("product_name").val();
            var price = parseFloat($("#price").val());
            var quantity = parseInt($("#quantity").val());
            var total_price = price * quantity;



            //setting the total amount in the modal.


            // $.ajax({

            // url: "<?php echo base_url('order/place_order'); ?>",
            // type: "POST",

            // data:{
            //     first_name : first_name,
            //     last_name: last_name,
            //     phone_number: phone_number,
            //     product_name: product_name,
            //     price: price,
            //     quantity: quantity,
            //     total_price: total_price,
            // },

            // dataType: "json",

            // success: function(response)
            // {
                 
            // },





            // });

        });








    })






  })




</script> -->