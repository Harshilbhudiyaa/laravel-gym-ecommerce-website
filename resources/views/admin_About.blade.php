@extends('admin_sidebar')
@section('sidebar')

<div class="nav-title">
    <h1 style="margin-left:30px; text-align:center">About Us</h1>
</div>

<style>
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

    /* Custom Modal Styles */
    .modal-custom {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }
    .modal-content-custom {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        width: 500px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        position: relative;
    }
    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-close {
        cursor: pointer;
        font-size: 24px;
        color: red;
    }
    .modal-body-custom {
        margin-top: 15px;
    }
    .modal-footer-custom {
        text-align: right;
    }
</style>

<div class="container mt-5">
    <div class="form-container">
        <form action="/admin_About" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="imageInput" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="imageInput" name="image" accept="image/*">
                    <span class="text-danger">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label for="descriptionInput" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="descriptionInput" name="description" rows="5" placeholder="Enter description"></textarea>
                    <span class="text-danger">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn-custom">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container mt-5">
    <div class="table-container">
        <h2 class="table-title">About Us</h2>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aboutUsData as $item)
                        <tr>
                            <td><img src="{{ URL::to('/') }}/img/about/{{$item->img}}" alt="Image" style="width: 100px; height: auto;"></td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <a href="#" class="edit-link" data-id="{{ $item->id }}" data-description="{{ $item->description }}">Edit</a>
                            </td>
                            <td>
                                <a href="{{ url('/admin_About/delete/' . $item->id) }}" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Custom Modal for Edit About Us -->
<div class="modal-custom" id="editModal">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5>Edit About Us Information</h5>
            <span class="modal-close" id="modalClose">&times;</span>
        </div>
        <form id="editUserForm" method="POST" action="/admin_About/update" enctype="multipart/form-data">
            @csrf
            <div class="modal-body-custom">
                <input type="hidden" id="edit_about_us_id" name="id">
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_image">Image</label>
                    <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-custom" id="modalCloseBtn">Close</button>
                <button type="submit" class="btn-custom">Save changes</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editModal');
        var modalClose = document.getElementById('modalClose');
        var modalCloseBtn = document.getElementById('modalCloseBtn');
        
        // Open modal
        document.querySelectorAll('.edit-link').forEach(function(editLink) {
            editLink.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                var description = this.getAttribute('data-description');
                
                // Set form data
                document.getElementById('edit_about_us_id').value = id;
                document.getElementById('edit_description').value = description;
                document.getElementById('editUserForm').action = '/admin_About/update/' + id;
                
                // Show modal
                editModal.style.display = 'flex';
            });
        });

        // Close modal
        modalClose.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
        modalCloseBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
        });

        // Close modal when clicking outside content
        window.addEventListener('click', function(event) {
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        });
    });
</script>

@endsection
