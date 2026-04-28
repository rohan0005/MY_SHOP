<table id="productsWithStock" class="table table-bordered table-striped mx-auto " style="width: 90%;">

    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">stock</th>
            <th scope="col">Warehouse location</th>
            <th scope="col">Supplier name</th>

        </tr>
    </thead>

    <tbody class="tableBody">

        <!-- SHOULD BE EMPTY -->


    </tbody>

</table>



<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
    // DATA TABLE:
    $("#productsWithStock").DataTable({
        ajax: {
            url: "<?php echo base_url('getProductAndStock') ?>",
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
                data: 'stock'
            },
            {
                data: 'warehouse_location'
            },
            {
                data: 'supplier_name'
            },


        ]

    });
</script>