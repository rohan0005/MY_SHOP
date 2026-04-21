<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form>

      <div class="modal-body">
          <div class="mb-1">
            <label class="col-form-label">Product Name:</label>
            <input type="text" class="form-control" id="productName">
          </div>
          <div class="mb-1">
            <label class="col-form-label">Price:</label>
            <input type="number" min=1 class="form-control" id="productPrice">
          </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="addProductBtn" class="btn btn-primary ">Add Product</button>
      </div>
        </form>

    </div>
  </div>
</div> 


