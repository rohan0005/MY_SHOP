<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Order Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
                    <div id="statusAlert" class="alert alert-primary" role="alert" style="display:none;">
                <P>Status Updated Successfully!</P>
                </div>
      <div class="modal-body">
         <div class="row">
          <div class="col-6 mb-3">
            <label for="first-name" class="col-form-label">First Name:</label>
            <p id="view-first-name" class="text-success form-control-plaintext"></p>
            <!-- <input type="text" id="view-first-name"> -->
          </div>
          <div class="col-6 mb-3">
            <label for="last-name" class="col-form-label">Last Name:</label>
            <p id="view-last-name" class="text-success form-control-plaintext">EXAMPLE LAST NAME</p>
          </div>
          <div class="col-6 mb-3">
            <label for="phone_number" class="col-form-label">Phone Number:</label>
            <p id="view-phone_number" class="text-success form-control-plaintext">EXAMPLE PHONE NUMBER</p>

          </div>
          <div class="col-6 mb-3">
            <label for="product-name" class="col-form-label">Product Name:</label>
            <p id="view-product-name" class="text-success form-control-plaintext">EXAMPLE PRODUCT NAME</p>

          </div>
          <div class="col-6 mb-3">
            <label for="price" class="col-form-label">Price:</label>
            <p id="view-price" class="text-success form-control-plaintext">EXAMPLE PRICE</p>

          </div>
          <div class="col-6 mb-3">
            <label for="quantity" class="col-form-label">Quantity:</label>
            <p id="view-quantity" class="text-success form-control-plaintext">EXAMPLE QUANTITY</p>
          </div>
          <div class="col-6 mb-3">
            <label for="order-date" class="col-form-label">Order Date:</label>
            <p id="view-order-date" class="text-success form-control-plaintext">EXAMPLE ORDER DATE</p>

          </div>

          <!-- action - pending, completed or cancelled -->
          <div class="col-6 mb-3">
            <label for="status" class="col-form-label">Status:</label>
            <!-- drop down -->
             <input type="hidden" name="id" id="orderID" value="">
            <div id="statusUpdate">
            <select id="view-status" class="form-select">
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
             <button type="button" id="updateStatus" class="btn btn-primary mt-2">Update Status</button>
            </div>

                <p id="statusText" class="form-control-plaintext text-danger fw-bold"></p>

          </div>

          <div class="col-6 mb-3">
            <span>TOTAL: <p id="view-total" class="total_amount text-success "></p></span>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" disabled class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <!-- <div id="deleteOrder">
            
            <button type="button" id="orderProduct" class="btn btn-primary ">DELETE ORDER</button>

        </div> -->

      </div>
    </div>
  </div>
</div> 

<script>


    function fetchOrderDetails(id)
    {
            $.ajax({


    
        url: "<?php echo base_url("view-details/")?>"  + id ,


        type: "GET",

        dataType: "json",

        success: function(response)
        {
            if (response.success)
            {
                console.log("RESPONSE IS: ")
                console.log(response.data);
                console.log(typeof response.success);

                // $("#view-first-name").text("ROHAN");

                $("#orderID").val(response.data.id);


                $("#view-first-name").text(response.data.f_name);
                $("#view-last-name").text(response.data.l_name);
                $("#view-phone_number").text(response.data.phone);

                $("#view-product-name").text(response.data.p_name);

                $("#view-price").text(response.data.price);

                $("#view-quantity").text(response.data.quantity);

                $("#view-order-date").text(response.data.created_at);

                $("#view-status").val(response.data.status);

                $("#view-total").text(response.data.total_price);

                if(response.data.status == "cancelled" || response.data.status == "completed")
                    {
                        $("#statusUpdate").hide(); 
                        $("#updateStatus").hide(); 
                        $("#statusText").text(response.data.status).show();

                    }

                    else
                    {
                        $("#statusUpdate").show();
                        $("#updateStatus").show();  
                        $("#statusText").hide(); 
                        $("#view-status").val(response.data.status);


                    }


            }

            // else
            // {
                
            // }
        },

        error: function(xhr, status, error){
        console.log("ERROR: " + status + " " + error);
    }

});
    }


$(document).on("click", ".viewDetailsbtn", function(){


    var id = $(this).data("id");

    console.log("ID IS", id)

    fetchOrderDetails(id);
    });





    // Update Status (eg: pending, completed....)
    $(function(){

    $(document).on("click", '#updateStatus', function(){
        
        var UpdatedStatus = $("#view-status").val();
        var orderID = $("#orderID").val();

        console.log("ORDER ID IS: ",orderID);

        $.ajax(
        {
            url: "<?php echo base_url("update-order-status/")  ?>" + orderID,
            
            type: "post",

            dataType: "json",

            data:{
                status: UpdatedStatus
            },

            success: function(response)

            {
                if(response.success)
                {

                    $("#statusAlert").show().fadeOut(4000);

                    fetchOrderDetails(orderID);
                }
            }

            



        });

    });



    });




</script>