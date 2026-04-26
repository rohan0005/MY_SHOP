<?php echo isset($error) ? $error : '';

include(APPPATH . "modules/product/views/view_product_image_modal.php");


?>


<table id="productsTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">IMAGE</th>

        </tr>
    </thead>

    <tbody class="tableBody">

        <!-- SHOULD BE EMPTY -->


    </tbody>

</table>


<div class="modal fade" id="productImageViewModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Product Image</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>

                <div class="modal-body">

                    <div class="pName">

                    </div>



                    <div class="mb-1 iName">



                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
    // DATA TABLE:
    $("#productsTable").DataTable({
        ajax: {
            url: "<?php echo base_url('get_product_ss') ?>",
            type: "POST",
        },
        processing: true, // Shows loading spinner animation
        serverSide: true, // Enables server side

        columns: [

            {
                data: 'id'
            },
            {
                data: 'p_name'
            },
            {
                data: 'price'
            },
            {
                data: 'action',
                orderable: false
            },

        ]

    });

    $(document).on("click", ".productImageViewModal", function() {

        var image = $(this).data("image");
        var product = $(this).data("productname");
        console.log(image, product)

        $('.iName').empty();
        $('.pName').empty();


        $(".pName").append(
            '<h2> ' + product + ' </h2>',
            '<br />'
        )

        $(".iName").append(
            '<img src="./uploads/' + image + '" alt="img" class="img-thumbnail">'
        )

    });
</script>