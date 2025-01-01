@extends('admin_sidebar')
@section('sidebar')

<div class="nav-title">
    <h1 style="text-align:center;">Products</h1>
</div>

<style>
    .form-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-title {
        text-align: center;
        margin-bottom: 20px;
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
    .error {
        color: red;
        font-size: 0.9em;
    }
    .table-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
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
    /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px; /* Max width for the modal */
    border-radius: 8px;
}

/* Close Button */
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-container">
                <h2 class="form-title">Add New Product</h2>
                <form method="POST" enctype="multipart/form-data" action="{{ route('products.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        <span class="error">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        <span class="error">
                            @error('image')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        <span class="error">
                            @error('description')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}">
                        <span class="error">
                            @error('price')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="category">Product Category</label>
                        <select class="form-control" id="category" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error">
                            @error('category_id')
                                {{ $message }}
                            @enderror
                        </span>

                        
                    </div>
                    <button type="submit" class="btn btn-custom">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<br><br>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="table-responsive">
                <div class="table-container">
                    <h2 class="table-title">Products List</h2>
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>discount</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)     
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->description}}</td>
                                <td>₹{{$product->price}}</td>
                                <td>₹{{$product->discounted}}</td>
                                <td>{{$product->categories}}</td>
                                <td><img src="{{ asset('img/products/' . $product->image) }}" alt="Product Image" style="width:100px;"></td>
                                <td><a href="#" class="edit-link" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-description="{{ $product->description }}" data-price="{{ $product->price }}" data-image="{{ $product->image }}" data-category="{{ $product->category }}">
                                    Edit</a></td>

                                <td>
                                    <a href="{{ route('products.delete', ['id' => $product->id]) }}" class="delete-link" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close">&times;</span>
        <h2>Edit Product</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="POST"> <!-- Set method to POST -->
            <input type="hidden" name="id" id="editProductId">
            <div class="form-group">
                <label for="editName">Product Name</label>
                <input type="text" class="form-control" id="editName" name="name">
            </div>
            <div class="form-group">
                <label for="editImage">Product Image</label>
                <input type="file" class="form-control-file" id="editImage" name="image">
            </div>
            <div class="form-group">
                <label for="editDescription">Product Description</label>
                <textarea class="form-control" id="editDescription" name="description" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="editPrice">Product Price</label>
                <input type="number" class="form-control" id="editPrice" name="price" step="0.01">
            </div>
            <div class="form-group">
                <label for="editCategory">Product Category</label>
                <select class="form-control" id="editCategory" name="category">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-custom">Update</button>
        </form>
    </div>
</div>


<script>

document.querySelectorAll('.edit-link').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const description = this.getAttribute('data-description');
        const price = this.getAttribute('data-price');
        const image = this.getAttribute('data-image');
        const category = this.getAttribute('data-category'); // Get category from data attribute

        // Populate the form fields
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editPrice').value = price;
        document.getElementById('editProductId').value = id;

        // Set the category dropdown
        const categoryDropdown = document.getElementById('editCategory');
        for (let option of categoryDropdown.options) {
            option.selected = option.value === category;
        }

        // Set the form action with the product ID
        document.getElementById('editForm').action = '/products/update/' + id;

        // Show the modal
        document.getElementById('editModal').style.display = 'block';
    });
});

// Close the modal when the user clicks on the "x" button
document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('editModal').style.display = 'none';
});

// Close the modal if the user clicks anywhere outside of the modal
window.addEventListener('click', function (event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

</script>

@endsection
