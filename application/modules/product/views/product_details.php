<?php
include(APPPATH . "modules/product/views/add_product_modal.php");
include(APPPATH . "modules/product/views/view_product_image_modal.php");

?>

<?php echo isset($error) ? $error : ''; ?>


<table id="productDetailsTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

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


<script>
    var productTable;

    $(function() {

        //ALL USER TABLE
        if (!$.fn.DataTable.isDataTable('#productDetailsTable')) {
            productTable = $('#productDetailsTable').DataTable({
                pageLength: 10,
                order: [
                    [0, "asc"]
                ],
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


    $("#addProductBtn").click(function(e) {

        e.preventDefault(); // Prevent form submission/page reload


        console.log($("#productName").val());
        console.log($("#productPrice").val());
        console.log($("#productImage")[0].files[0]);

        var productName = $("#productName").val();
        var productPrice = $("#productPrice").val();

        var formData = new FormData(); // FormData for file upload

        formData.append("productName", productName);
        formData.append("productPrice", productPrice);

        var file = $("#productImage")[0].files[0];

        formData.append("productImage", file);



        $.ajax({
            url: "<?php echo base_url("add_product") ?>",
            type: "POST",
            dataType: "json",

            data: formData,

            contentType: false,
            processData: false,

            success: function(response) {

                $("#addProductModal").modal("hide");

                loadProduct()
                showToast(response.message);

            },

            error: function(xhr, status, error) {
                console.log("error:", xhr.responseText);
            }

        });
    });


    function loadProduct() {

        $.ajax({

            url: "<?php echo base_url("all_product") ?>",
            type: "GET",
            dataType: "json",

            success: function(response) {
                if (response.success) {
                    // console.log("all products", response.data), 



                    // loop to fetch all products:

                    productTable.clear();


                    $.each(response.data, function(index, item) {

                        productTable.row.add([
                            item.id,
                            item.p_name,
                            item.price,
                            '<button type="button" data-id="' + item.id + '" class="btn btn-info text-white view-product-image" data-bs-toggle="modal" data-bs-target="#viewImageModal">View Product Image</button>',

                        ])

                    });
                    productTable.draw();

                    console.log(response.data);


                }
            }


        });

    }

    $(document).on("click", ".view-product-image", function() {

        $('.imageArea').empty();
        $('.productName').empty();

        var id = $(this).data("id");

        $.ajax({

            url: "<?php echo base_url("all_product") ?>",
            type: "GET",
            dataType: "json",

            success: function(response) {
                if (response.success) {
                    $.each(response.data, function(index, item) {
                        if (item.id == id) {

                            $('.productName').append(
                                '<h2> ' + item.p_name + ' </h2>',
                                '<br />'

                            );


                            $('.imageArea').append(
                                '<img src="./uploads/' + item.image + '" alt="img" class="img-thumbnail">'
                            )

                        }


                    });





                }

            }

        });


    });
</script>