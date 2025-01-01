@extends('admin_sidebar')
@section('sidebar')

<h1 style="text-align:center">Messages</h1>
<style>
    .table-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
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
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
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

<div class="container table-container">
    <table class="table table-custom">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Message</th>
                <th scope="col">Reply</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
            <tr>
                <td>{{ $message->name }}</td>
                <td>{{ $message->email }}</td>
                <td>{{ $message->message }}</td>
                <td><a class="edit-link" href="#" onclick="openModal('{{ $message->id }}', '{{ $message->email }}')">Reply</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="replyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Reply to Message</h2>
        <form id="replyForm" method="POST" action="">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="replyMessage">Message:</label>
                <textarea id="replyMessage" name="replyMessage" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
    </div>
</div>

<script>
    function openModal(id, email) {
        document.getElementById('email').value = email;
        document.getElementById('replyForm').action = "{{ url('messages/reply') }}/" + id;
        document.getElementById('replyModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('replyModal').style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('replyModal')) {
            closeModal();
        }
    }

    document.getElementById('replyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        this.submit();
    });
</script>

@endsection
