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
        <a class="navbar-brand"><h2 class="text-success">MY SHOP</h2></a>

        <a class="navbar-brand" href=""><h6 class="text-success">USERS</h6></a>
        <a class="navbar-brand" href=""><h6 class="text-success">PRODUCTS</h6></a>

        <form class="d-flex">
            <button type="button" class="text-white btn bg-success" data-bs-toggle="modal" data-bs-target="#addModal">
                ADD ORDER
            </button>
        </form>
    </div>
</nav>

<div
    class="container mt-5"
>

<?php $this->load->view($page_content); ?>
</div>



<!-- jQuery FIRST -->

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- MAIN SCRIPT -->

   


<script>

var table;

$(function () {

    // myTable - ALL ORDER DETAILS
    if (!$.fn.DataTable.isDataTable('#myTable')) {
        table = $('#myTable').DataTable({
            pageLength: 10,
            order: [[0, "asc"]],
            columnDefs: [{
                orderable: false,
                targets: 2
            }]
        });
    }

});


// LOAD ORDER DETAILS IN TABLE

function lodeData()
{
    $.ajax(
    {
        url: "<?php echo base_url('view-all-orders'); ?>",
        type: "GET",
        dataType: "json",

        success: function(response)
        {
            if(response.success == true)
            {
                // console.log(response.data);

                // Clear existing table data
                if (table) {
                    table.clear().draw();
                }

                // Populate table with new data

                $.each(response.data, function(index, item){

                    table.row.add([
                        item.id,
                        item.f_name,
                        item.l_name,
                        item.p_name,
                        '<button type="button" data-id="' + item.id +'" class="btn btn-primary viewDetailsbtn" data-bs-toggle="modal" data-bs-target="#viewDetailsModal">View Detailsss</button>',

                    ]);

                });

                table.draw();

            }
        }


    });

}

lodeData();


    // $(document).on("click", "#viewDetailsbtn", function(){
    //     alert("clicked");

    // });


</script>

</body>


</html>