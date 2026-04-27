<a href="<?php echo base_url('export') ?>"
    class="btn btn-success">
    Download Excel
</a>

<div class="modal fade" id="viewOrderDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Order Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <p id="view_phone_number" class="text-success form-control-plaintext"></p>

                    </div>

                    <div class="col-6 mb-3">
                        <label for="order-date" class="col-form-label">User creation Date:</label>
                        <p id="view-created-at" class="text-success form-control-plaintext"></p>

                    </div>

                    <table class="table table-bordered table-striped mx-auto ">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="productsDetailsTableBody">
                        </tbody>
                    </table>

                    <br />

                    <!-- action - pending, completed or cancelled -->
                    <div class="col-6 mb-3">
                        <label for="status" class="col-form-label">Status:</label>
                        <!-- drop down -->
                        <input type="hidden" name="id" id="orderID" value="">
                        <div id="statusUpdate">
                            <select disabled id="view-status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <!-- <button type="button" id="updateStatus" class="btn btn-primary mt-2">Update Status</button> -->
                        </div>

                        <p id="statusText" class="form-control-plaintext text-danger fw-bold"></p>

                    </div>

                    <div class="col-6 mb-3">
                        <span>TOTAL: <p id="view-total" class="total_amount text-success "></p></span>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <!-- <div id="deleteOrder">

          <button type="button" id="del-order" class="btn btn-danger ">DELETE ORDER</button>

        </div> -->

            </div>
        </div>
    </div>
</div>

<table id="allOrdersTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

    <thead>
        <tr>
            <th scope="col">order_id</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Total Price</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

    <tbody class="tableBody">

        <!-- SHOULD BE EMPTY -->



    </tbody>

</table>





<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script>
    $("#allOrdersTable").DataTable({
        ajax: {
            url: "<?php echo base_url("get_all_orders") ?>",
            type: "POST",
        },

        processing: true,
        serverSide: true,

        columns: [{
                data: "id"
            },
            {
                data: "f_name"
            },
            {
                data: "l_name"
            },
            {
                data: "total"
            },
            {
                data: "status"
            },
            {
                data: "action",
                orderable: false
            }

        ]

    });


    $(document).on("click", ".viewOrderDetails", function() {

        var order_id = $(this).data("id")

        var status = $(this).data("status")
        var f_name = $(this).data("fname")
        var l_name = $(this).data("lname")
        var total = $(this).data("total")
        var created_date = $(this).data("createdat")
        var phone = $(this).data("phone")

        $("#view-first-name").empty();
        $("#view-last-name").empty();

        $("#view-first-name").append(
            '<span>' + f_name + '</span>'
        );

        $("#view-last-name").append(
            '<span>' + l_name + '</span>'
        );

        $("#view-total").append(
            '<span>' + total + '</span>'
        );

        $("#view-created-at").append(
            '<span>' + created_date + '</span>'
        );

        $("#view_phone_number").append(
            '<span>' + phone + '</span>'
        );




        $.ajax({
            url: "<?php echo base_url('view-details/'); ?>" + order_id,
            type: "GET",
            dataType: "json",

            success: function(response) {
                if (response.success) {
                    $("#productsDetailsTableBody").html(""); // ✅ Clear

                    response.data.forEach(function(product) {
                        var row = `
                        <tr>
                            <td>${product.p_name}</td>
                            <td>${product.quantity}</td>
                            <td>${product.price}</td>
                        </tr>
                    `;
                        $("#productsDetailsTableBody").append(row);
                    });
                }
            }
        });






    });
</script>