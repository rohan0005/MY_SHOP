<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest CDN Template</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid mx-2">
        <a class="navbar-brand"><h2 class="text-success">MY SHOP</h2></a>
        <form class="d-flex" role="search">
        <button class="text-white btn bg-success" type="submit">ADD ORDER</button>
        </form>
    </div>
    </nav>

    <?php $this->load->view($page_content); ?>
    

    <!-- jQuery (Needed for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    

    <footer>
        <div class="container mt-5">
            <p class="text-center mt-4">© 2026 MY SHOP. All rights reserved.</p>
        </div>
    </footer>


<script>

    $(function(){

    table = $("#myTable").DataTable({
      "pageLength": 10,
      "order": [[0, "asc"]],
      "columnDefs": [{
        "orderable": false, "targets": 2
      }]
    });

  })

</script>

</body>
</html>