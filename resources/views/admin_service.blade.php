@extends('admin_sidebar')

@section('sidebar')

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

    .table-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
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

    /* Modal Background */
.modal-custom {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
}

/* Modal Content */
.modal-content-custom {
    position: relative;
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/* Close Button */
.close-custom {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #111;
    cursor: pointer;
}

.close-custom:hover {
    color: red;
}



</style>

<div class="h1">
    <h1 style="margin-left:30px; text-align:center;">Service</h1>
</div><br>

<div class="container"> 
    <div class="form-container">
        <h2 class="text-center mb-4">Add New Service</h2>
        <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" >
                <span class="text-danger">
                    @error('title')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" ></textarea>
                <span class="text-danger">
                    @error('description')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                <span class="text-danger">
                    @error('image')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>
</div>

<div class="container"> 
    <div class="table-container">
        <h2 class="table-title">Services</h2>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->description }}</td>
                            <td><img src="{{ URL::to('/') }}/img/service/{{ $service->img }}" alt="Image" style="width: 100px; height: auto;"></td>
                            <td><a href="{{ route('service.index') }}?edit={{ $service->id }}" class="edit-link">Edit</a></td>
                            <td><a href="{{ route('service.delete', $service->id) }}" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<!-- Edit Modal -->
<div id="editModal" class="modal-custom">
    <div class="modal-content-custom">
        <span class="close-custom">&times;</span>
        <h5 class="modal-title" id="editModalLabel">Edit Service</h5>
        <form method="POST" action="{{ route('service.update', '') }}" enctype="multipart/form-data" id="editForm">
            @csrf
            <input type="hidden" id="edit-id" name="id">
            <div class="form-group">
                <label for="edit-title">Title</label>
                <input type="text" class="form-control" id="edit-title" name="title" required>
            </div>
            <div class="form-group">
                <label for="edit-description">Description</label>
                <textarea class="form-control" id="edit-description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="edit-image">Image</label>
                <input type="file" class="form-control-file" id="edit-image" name="image" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" onclick="closeModal()">Close</button>
                <button type="submit" class="btn btn-custom">Save changes</button>
            </div>
        </form>
    </div>
</div>



<script>


document.addEventListener('DOMContentLoaded', function() {
    // Get modal element
    const modal = document.getElementById('editModal');
    
    // Get close button
    const closeBtn = document.querySelector('.close-custom');

    // Function to open modal
    function openModal() {
        modal.style.display = 'block';
    }

    // Function to close modal
    function closeModal() {
        modal.style.display = 'none';
    }

    // Close modal when clicking close button
    closeBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside of modal content
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            closeModal();
        }
    });

    // Check for edit parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');

    if (editId) {
        const services = @json($services);
        const service = services.find(s => s.id == editId);

        if (service) {
            document.getElementById('edit-id').value = service.id;
            document.getElementById('edit-title').value = service.title;
            document.getElementById('edit-description').value = service.description;

            // Optionally set image preview here

            document.getElementById('editForm').action = '{{ route("service.update", "") }}/' + service.id;
            
            // Open modal
            openModal();
        }
    }
});

</script>

@endsection
