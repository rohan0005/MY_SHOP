<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addProductForm" enctype="multipart/form-data">

        <div class="modal-body">
          <div class="mb-1">
            <label class="col-form-label">Product Name:</label>
            <input type="text" class="form-control" id="productName">
          </div>
          <div class="mb-1">
            <label class="col-form-label">Price:</label>
            <input type="number" min=1 class="form-control" id="productPrice">
          </div>

          <div class="mb-1">
            <label class="col-form-label">Stock:</label>
            <input type="number" min=1 class="form-control" id="productStock">
          </div>

          <div class="mb-1">
            <label class="col-form-label">Warehouse Location:</label>
            <input type="text" class="form-control" id="productWarehouse">
          </div>

          <div class="mb-1">
            <label class="col-form-label">Supplier Name:</label>
            <input type="text" class="form-control" id="productSupplier">
          </div>

          <!-- IMAGE UPLOAD -->

          <div class="mb-1">
            <label class="col-form-label">Product Image:</label>
            <input type="file" class="form-control" id="productImage" name="productImage">
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" value="upload" id="addProductBtn" class="btn btn-primary ">Add Product</button>
        </div>
      </form>

    </div>
  </div>
</div>