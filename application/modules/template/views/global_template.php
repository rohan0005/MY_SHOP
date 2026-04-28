<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY SHOP</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
</head>

<body>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid mx-2">
            <a href="<?php echo base_url("") ?>" class="navbar-brand">
                <h2 class="text-success">MY SHOP</h2>
            </a>

            <a class="navbar-brand" href="<?php echo base_url("users") ?>">
                <h6 class="text-success">USERS</h6>
            </a>
            <a class="navbar-brand" href="<?php echo base_url("product") ?>">
                <h6 class="text-success">PRODUCTS</h6>
            </a>

            <a class="navbar-brand" href="<?php echo base_url("productSS") ?>">
                <h6 class="text-success">SS PRODUCTS</h6>
            </a>

            <a class="navbar-brand" href="<?php echo base_url("all-orders") ?>">
                <h6 class="text-success">SS All Orders</h6>
            </a>

            <a class="navbar-brand" href="<?php echo base_url("user-details") ?>">
                <h6 class="text-success">SS All USERS</h6>
            </a>

            <a class="navbar-brand" href="<?php echo base_url("productAndStockPage") ?>">
                <h6 class="text-success">Product And Stock</h6>
            </a>




            <form class="d-flex">
                <?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'home') { ?>

                    <button type="button" class="text-white btn bg-success" data-bs-toggle="modal" data-bs-target="#addModal">
                        ADD ORDER
                    </button>



                <?php

                } elseif ($this->uri->segment(1) == 'product') { ?>

                    <button type="button" class="text-white btn bg-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        ADD PRODUCT
                    </button>


                <?php } ?>


            </form>
        </div>
    </nav>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast border-0 shadow-lg" role="alert">
            <div class="toast-header bg-success text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <strong class="me-auto">MY SHOP</strong>
                <small class="text-white opacity-75">Just now</small>
                <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body d-flex align-items-center gap-2 bg-white" id="toastMessage">
                <!-- message goes here -->
            </div>
        </div>
    </div>

    <div
        class="container mt-5">

        <?php $this->load->view($page_content); ?>

    </div>



    <!-- jQuery FIRST -->

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- MAIN SCRIPT -->



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //toast message

        function showToast(message, type = 'success') {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }



        var table;

        $(function() {

            // myTable - ALL ORDER DETAILS
            if (!$.fn.DataTable.isDataTable('#myTable')) {
                table = $('#myTable').DataTable({
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

        });


        // LOAD ORDER DETAILS IN TABLE

        function lodeData() {
            $.ajax({
                url: "<?php echo base_url('view-all-orders'); ?>",
                type: "GET",
                dataType: "json",

                success: function(response) {
                    if (response.success == true) {
                        // console.log(response.data);

                        // Clear existing table data
                        if (table) {
                            table.clear().draw();
                        }

                        // Populate table with new data

                        $.each(response.data, function(index, item) {

                            table.row.add([
                                item.id,
                                item.f_name,
                                item.l_name,
                                item.p_name,
                                '<button type="button" data-id="' + item.id + '" class="btn btn-primary viewDetailsbtn" data-bs-toggle="modal" data-bs-target="#viewDetailsModal">View Detailsss</button>',

                            ]);

                        });

                        table.draw();

                    }
                }


            });

        }

        lodeData();
    </script>

</body>


</html>