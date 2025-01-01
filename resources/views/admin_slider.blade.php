@extends('admin_sidebar')

@section('sidebar')


<h1 style="text-align:center">Slider</h1>

<style>
    .form-container {
        max-width: 600px;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: auto;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-control-file {
        overflow: hidden;
    }
    .btn-custom {
        background-color: #11101D;
        border-color: #11101D;
        border-radius: 20px;
        padding: 10px 20px;
        color: white;
    }
    .btn-custom:hover {
        background-color: white;
        border-color: #11101D;
        color: #11101D;
    }
    .table-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .table-title {
        text-align: center;
        margin-bottom: 20px;
    }
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }
    .table-custom th, .table-custom td {
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: center;
    }
    .table-custom th {
        background-color: #343a40;
        color: white;
    }
    .table-custom tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .edit-link {
        color: green;
        cursor: pointer;
    }
    .delete-link {
        color: red;
        cursor: pointer;
    }
    .error {
        color: red;
        font-size: 0.875em;
    }

    /* Modal Styles */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0, 0, 0); 
    background-color: rgba(0, 0, 0, 0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    max-width: 500px;
    border-radius: 8px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

</style>


<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Add New Slider</h2>
        <form method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" value="{{ old('productName') }}">
                @error('productName')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" class="form-control-file" id="productImage" name="productImage" accept="image/*">
                @error('productImage')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="productPrice">Product Price</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" value="{{ old('productPrice') }}">
                @error('productPrice')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>
</div>



<div class="container mt-5">
    <div class="table-container">
        <h2 class="table-title">Product List</h2>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                
                <tbody>
                    @foreach($sliders as $slider)
                        <tr>
                            <td data-id="{{ $slider->id }}">{{ $slider->name }}</td>
                            <td>${{ $slider->Price }}</td>
                            <td><img src="{{ asset('img/slider/' . $slider->image) }}" alt="Product Image" class="img-fluid" width="50"></td>
                            <td><a href="#" class="edit-link">Edit</a></td>
                            <td>
                                <a href="{{ route('slider.delete', ['id' => $slider->id]) }}" class="delete-link" onclick="return confirm('Are you sure you want to delete this slider?')">Delete</a>
                                 </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>



<!-- Edit Slider Modal -->
<!-- Edit Slider Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Slider</h2>
        <!-- Form with Dynamic Action URL -->
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST') <!-- Use POST as the method -->
            <input type="hidden" id="editSliderId" name="id">
            <div class="form-group">
                <label for="editProductName">Product Name</label>
                <input type="text" class="form-control" id="editProductName" name="productName">
            </div>
            <div class="form-group">
                <label for="editProductImage">Product Image</label>
                <input type="file" class="form-control-file" id="editProductImage" name="productImage" accept="image/*">
            </div>
            <div class="form-group">
                <label for="editProductPrice">Product Price</label>
                <input type="number" class="form-control" id="editProductPrice" name="productPrice" step="0.01">
            </div>
            <button type="submit" class="btn btn-custom">Update</button>
        </form>
    </div>
</div>



<script>

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById("editModal");
    var span = document.getElementsByClassName("close")[0];

    document.querySelectorAll('.edit-link').forEach(function (editBtn) {
        editBtn.addEventListener('click', function (event) {
            event.preventDefault();

            // Get the data from the row
            var row = this.closest('tr');
            var sliderId = row.querySelector('td[data-id]').getAttribute('data-id');
            var productName = row.querySelector('td:nth-child(1)').textContent.trim();
            var productPrice = row.querySelector('td:nth-child(2)').textContent.trim().replace('$', '');

            // Fill the form fields with the data
            document.getElementById('editSliderId').value = sliderId;
            document.getElementById('editProductName').value = productName;
            document.getElementById('editProductPrice').value = productPrice;

            // Set the form action to the correct update route
            document.getElementById('editForm').action = '/admin_slider/update/' + sliderId;

            // Open the modal
            modal.style.display = "block";
        });
    });

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});


</script>

@endsection
