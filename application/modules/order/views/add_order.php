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
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="email" class="form-control" id="email">
          </div>


          <!-- PRODUCT SELECTION  START -->
           
          <div class="chooseProduct">

          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">Product Name:</label>
            <!-- <input type="text" class="form-control" id="product-name"> -->

            <select class="form-select" id="product-name" >
              <option selected>PRODUCT NAME</option>
            </select>



          </div>

          <div class="row">
            <div class="col-6">
                <div class="mb-1">
                    <label class="col-form-label">Price:</label>
                    <input disabled type="number" min="1" class="form-control" id="price">
                </div>
            </div>

            <div class="col-6">
                <div class="mb-1">
                    <label class="col-form-label">Quantity:</label>
                    <input type="number" min="1" class="form-control" id="quantity">
                </div>
            </div>
        </div>

          </div>

          <button type="button" class="btn btn-warning text-white" id="addProductToSummary" >Add</button>
              <br />
              <br />



          <!-- PRODUCT SELECTION END-->



          <!-- PRODUCT SUMMARY START-->

          <div class="productSummaryDiv">
            <!-- <div class="card" style="width: 18rem;">
              <div class="card-header">
                <h5>
                  Product Summary:
                </h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Radio</li>
                <li class="list-group-item">Laptop</li>
                <li class="list-group-item">Mobile</li>
              </ul>
            </div> --> 

             <div class="card-header">
                <h5>
                  Product Summary:
                </h5>
              </div>

            <table id="productSummaryTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

              <thead>
                  <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>

              <tbody class="tableBody">
                  <!-- SHOULD BE EMPTY -->
              </tbody>

            </table>

          </div>

          <!-- PRODUCT SUMMARY START-->




          
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="orderProduct" class="btn btn-primary ">ORDER</button>
      </div>
    </div>
  </div>
</div> 



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>



var productSummaryList;



$(function(){

     $(function(){

        //ALL USER TABLE
        if (!$.fn.DataTable.isDataTable('#productSummaryTable')) {
                productSummaryList = $('#productSummaryTable').DataTable({
                    paging: false,
                    searching: false,
                    info: false,
                    ordering: false,    
                    lengthChange: false
                });
            }
            
        
        // LOADING ALL THE PRODUCT IN THE list
        });






  $.ajax({
    url: "<?php echo base_url("all_product") ?>",
    type: "GET",
    dataType: "json",

    success: function(response)
    {
      console.log("ALLL PRODUCTs", response.data);

      $.each(response.data, function(index, item){
        
          
        $("#product-name").append
        (
          '<option  id="productid" value="'+item.id+'"  data-price="'+ item.price +'" data-pid="'+ item.id +'"> ' + item.p_name + '</option>',
        )

      });
      
    }

  });


  // SHOW PRICE ACCORDING TO PRODUCT SELECTED
  $("#product-name").change(function(){

      var selectedPrice = $(this).find("option:selected").data("price");
      $("#price").val(selectedPrice);


  });
  


// SHOWING SELECTED PRODUCTS IN SUMMARY TABLE.
  $("#addProductToSummary").click(function(){
      
      var price = parseFloat($("#price").val());
      var id = $("#product-name").val();

      var product_name = $("#product-name option:selected").text().trim();
      var quantity = parseInt($("#quantity").val());
      var total_price = price * quantity;

      if(!isNaN(price) && !isNaN(quantity))
      {
          console.log("CLLICKED : ", price, product_name, total_price)
          showToast("Product Added To List!!");

          productSummaryList.row.add([
                product_name,
                price,
                quantity,
                total_price,
                '<button type="button"  data-total="' +total_price+ '"  data-pid="' +id+ '" data-quantity="' +quantity+ '"  data-productname="' +product_name+ '" class="btn btn-danger btn-sm removeProduct">X</button>',

          ]).draw();


          $("#quantity").val("");
          $("#price").val("");
          $("#product-name").prop("selectedIndex", 0);

          
      }

      else
      {
          console.log("NOT SELECTED")
      }
  
  });


  
    $("#orderProduct").click(function(){

        var first_name = $("#first-name").val();
            var last_name = $("#last-name").val();
            var phone_number = $("#phone_number").val();
            var product_id = $("#product-name").val();
            var price = parseFloat($("#price").val());
            var quantity = parseInt($("#quantity").val());
            var total_price = price * quantity;
            var email = $("#email").val();


            $.ajax({

            url: "<?php echo base_url('order/place_order'); ?>",
            type: "POST",

            data:{
                f_name : first_name,
                l_name: last_name,
                phone: phone_number,
                product_id: product_id,
                price: price,
                quantity: quantity,
                total_price: total_price,
                email: email,
            },

            dataType: "json",

            success: function(response)
            {

            if(response.success)
            {
                showToast(response.message);


                $("#first-name").val("");
                $("#last-name").val("");
                $("#phone_number").val("");
                $("#product-name").val("");
                $("#price").val("");
                $("#quantity").val("");
                $("#email").val("");

                
                $("#addModal").modal("hide");
                lodeData();
            }
            else
            {
               showToast(response.message);

            }
                 
            },

            error: function(xhr, status, error)
            {
                console.log("Status:", status);
                console.log("Error:", error);
                console.log("Response:", xhr.responseText); // Shows exact error
                alert(xhr.responseText); // Shows full error message
            }

        });

     });


  // CLOSE PLACE ORDER MODAL:

  $("#addModal").on('hidden.bs.modal', function(){


    productSummaryList.clear().draw();

    $("#first-name").val("");
    $("#last-name").val("");
    $("#phone_number").val("");
    $("#email").val("");
    $("#quantity").val("");
    $("#price").val("");
    $("#product-name").prop("selectedIndex", 0);


  });



  // REMOVE THE PRODUCT FROM SUMMARY LIST:

$(document).on("click", ".removeProduct", function(){


    var quantity = $(this).data("quantity");
    var product_name = $(this).data("productname");
    var price = $(this).data("total");
    var pid = $(this).data("pid");


    // REMOVE SELECTED ROW.

    var row = $(this).closest("tr");

    productSummaryList
        .row(row)
        .remove()
        .draw();

  });

});

</script>