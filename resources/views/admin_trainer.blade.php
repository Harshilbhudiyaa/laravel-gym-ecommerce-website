@extends('admin_sidebar')

@section('sidebar')

<div class="nav-title">
    <h1 style="margin-left:30px; text-align:center">Trainers</h1>
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


    /* Modal Background */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* The Close Button */
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

</style>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="form-title">Add New Trainer</h2>
                    
                    <form method="POST" enctype="multipart/form-data" action="{{ url('/admin_trainer') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Trainer Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Trainer Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" >
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn-custom">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="table-container">
            <h2 class="table-title">Our Trainers</h2>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Trainer Name</th>
                            <th>Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainers as $trainer)
                        <tr>
                            <td>{{ $trainer->name }}</td>
                            <td><img src="{{ URL::to('/') }}/img/trainer/{{ $trainer->image }}" alt="Trainer Image" style="width: 100px; height: auto;"></td>
                            <td><a href="{{ route('trainer.edit', ['id' => $trainer->id]) }}" class="edit-link">Edit</a></td>
                            <td><a href="{{ route('trainer.delete', ['id' => $trainer->id]) }}" class="delete-link" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</a></td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<!-- Edit Modal -->
<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Trainer</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="editTrainerId" name="id">
            <div class="form-group">
                <label for="editName">Trainer Name</label>
                <input type="text" class="form-control" id="editName" name="name" value="">
            </div>
            <div class="form-group">
                <label for="editImage">Trainer Image</label>
                <input type="file" class="form-control-file" id="editImage" name="image">
            </div>
            <button type="submit" class="btn-custom">Update</button>
        </form>
    </div>
</div>



<script>

   document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('editModal');
    var span = document.getElementsByClassName('close')[0];

    function openModal(trainerId, trainerName, trainerImage) {
        modal.style.display = 'block';
        document.getElementById('editTrainerId').value = trainerId;
        document.getElementById('editName').value = trainerName;
        document.getElementById('editForm').action = '/admin_trainer/update/' + trainerId;
    }

    span.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    document.querySelectorAll('.edit-link').forEach(function (editLink) {
        editLink.addEventListener('click', function (e) {
            e.preventDefault();
            var trainerId = this.getAttribute('href').split('/').pop();
            var trainerName = this.closest('tr').querySelector('td:first-child').textContent;
            openModal(trainerId, trainerName);
        });
    });
});


</script>

@endsection
