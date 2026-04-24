<div class="modal fade" id="viewLatestTwoOrders" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">LATEST 2 ORDERS of a Customer:</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <table id="LatestOrders" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script>
    var LatestOrders;


    $(function() {


        LatestOrders = $('#LatestOrders').DataTable({
            "searching": false,
            "lengthChange": false,
            "paging": false,
            "info": false,
        });

    });

    $(document).on("click", ".view_latest_order", function() {

        var UserOrderId = $(this).data("id");

        $.ajax({

            url: "<?php echo base_url("latest_order/") ?>" + UserOrderId,
            type: "GET",
            dataType: "json",

            success: function(response) {
                if (response.success) {

                    LatestOrders.clear();
                    // SHOW DATA
                    console.log("RESPONSE DATA ISSSSSSS:", response.data);

                    $.each(response.data, function(index, item) {
                        console.log(item);


                        LatestOrders.row.add([
                            item.id,
                            item.f_name,
                            item.l_name,
                            item.p_name,
                            item.quantity,
                            item.price,
                            item.order_date,
                        ]);

                    });
                    LatestOrders.draw();


                }
            },

            error: function(xhr, status, error) {
                console.log("ERROR: " + status + " - " + error);
            }


        });


    });
</script>