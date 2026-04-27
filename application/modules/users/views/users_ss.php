<table id="usersTable" class="table table-bordered table-striped mx-auto " style="width: 90%;">

    <thead>
        <tr>
            <th scope="col">uid</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Phone</th>
            <th scope="col">email</th>
            <th scope="col">Created At</th>
        </tr>
    </thead>

    <tbody class="tableBody">

        <!-- SHOULD BE EMPTY -->


    </tbody>

</table>


<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
    $("#usersTable").DataTable({
        ajax: {
            url: "<?php echo base_url("all-users") ?>",
            type: "POST",
        },

        processing: true,
        serverSide: true,

        columns: [{
                data: "id"
            },
            {
                data: "fname"
            },
            {
                data: "lname"
            },
            {
                data: "phone"
            },
            {
                data: "email"
            },
            {
                data: "createdat"
            },
        ]
    });
</script>