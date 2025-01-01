@extends('admin_sidebar')
@section('sidebar')

<h1 style="margin-left:30px; text-align:center;">Users</h1>

<style>
    /* Modal and table styles */
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
    /* Modal styles */
    /* Modal styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
    max-height: 80vh; /* Set a maximum height for the modal */
    overflow-y: auto; /* Enable vertical scrolling if content exceeds the maximum height */
    position: relative;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.modal-header {
    font-size: 24px;
    margin-bottom: 15px;
}

.modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
    font-size: 20px;
}

.modal-body {
    padding: 10px 0;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* Form Container */
form {
    max-width: 600px; /* Limit the form width */
    margin: 20px auto; /* Center the form */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9; /* Light background */
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

/* Labels */
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

/* Form Inputs */
.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Submit Button */
.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    text-align: center;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Success Message */
.alert-success {
    padding: 10px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 20px;
}


</style>

<br><br>
{{-- <center>
    <!-- Button to open the modal -->
    <button id="openModalBtn" class="btn btn-primary">Register New User</button>
</center> --}}



<center>
    <h2>Register New User</h2>
</center>

<!-- Success message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    {{-- <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div> --}}
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" class="form-control" id="dob" name="dob" required>
    </div>
    <div class="form-group">
        <label for="gender">Gender</label>
        <select class="form-control" id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="profile_pic">Profile Picture</label>
        <input type="file" class="form-control" id="profile_pic" name="profile_pic">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn-primary">Register</button>
    </div>
</form>

<!-- Modal Scripts -->
{{-- <script>
    // Open the modal
   // Open the modal
document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('registerModal').style.display = 'flex'; // Or 'block', based on your CSS
});

// Close the modal when clicking on 'x'
document.querySelector('.modal-close').addEventListener('click', function() {
    document.getElementById('registerModal').style.display = 'none';
});

// Close the modal if clicked outside of the content
window.addEventListener('click', function(event) {
    const modal = document.getElementById('registerModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

</script> --}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="table-container">
                <h2 class="table-title">User Information</h2>
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Gender</th>
                            <th>D.O.B</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Profile pic</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <!-- <th>Cart</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->dob }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->status }}</td>
                            <td><img src="{{ URL::to('/') }}/img/profile/{{ $user->profile }}" alt="" style="width: 100px; height: auto;"></td>
                            <td><a href="#" class="edit-link" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-gender="{{ $user->gender }}" data-dob="{{ $user->dob }}" data-address="{{ $user->address }}" data-status="{{ $user->status }}" data-profile_pic="{{ $user->profile }}">Edit</a></td>
                            <td><a href="{{ route('user.delete', $user->id) }}" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a></td>
                            <!-- <td><a href="#" class="view-cart-link" onclick="openCartModal('{{ $user->id }}')">View Cart</a></td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        margin: 10% auto;
        padding: 20px;
        width: 80%;
        max-width: 500px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .modal-header {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .modal-body ul {
        list-style-type: none;
        padding: 0;
    }

    .modal-body li {
        margin-bottom: 10px;
    }

    .modal-footer {
        text-align: right;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }
</style>

<script>
    function openCartModal(userId) {
        document.getElementById('cartModal' + userId).style.display = 'block';
    }

    function closeCartModal(userId) {
        document.getElementById('cartModal' + userId).style.display = 'none';
    }

    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
</script>

<!-- Edit Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2 class="modal-header">Edit User</h2>
        <form method="POST" action="" id="editForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit-id" name="id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" class="form-control" id="edit-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="edit-email">Email</label>
                    <input type="email" class="form-control" id="edit-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="edit-phone">Mobile Number</label>
                    <input type="text" class="form-control" id="edit-phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="edit-gender">Gender</label>
                    <input type="text" class="form-control" id="edit-gender" name="gender">
                </div>
                <div class="form-group">
                    <label for="edit-dob">D.O.B</label>
                    <input type="date" class="form-control" id="edit-dob" name="dob">
                </div>
                <div class="form-group">
                    <label for="edit-address">Address</label>
                    <textarea class="form-control" id="edit-address" name="address"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-status">Status</label>
                    <input type="text" class="form-control" id="edit-status" name="status" readonly>
                </div>
                <div class="form-group">
                    <label for="edit-profile-pic">Profile Picture</label>
                    <input type="file" class="form-control" id="edit-profile-pic" name="profile_pic">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-save">Save changes</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editModal');
    const closeBtn = document.querySelector('.modal-close');

    function openModal() {
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    closeBtn.addEventListener('click', closeModal);

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.querySelectorAll('.edit-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const userId = this.getAttribute('data-id');
            document.getElementById('edit-id').value = userId;
            document.getElementById('edit-name').value = this.getAttribute('data-name');
            document.getElementById('edit-email').value = this.getAttribute('data-email');
            document.getElementById('edit-phone').value = this.getAttribute('data-phone');
            document.getElementById('edit-gender').value = this.getAttribute('data-gender');
            document.getElementById('edit-dob').value = this.getAttribute('data-dob');
            document.getElementById('edit-address').value = this.getAttribute('data-address');
            document.getElementById('edit-status').value = this.getAttribute('data-status');
            
            document.getElementById('editForm').action = '{{ route("user.update", "") }}/' + userId;

            openModal();
        });
    });
});
</script>

@endsection