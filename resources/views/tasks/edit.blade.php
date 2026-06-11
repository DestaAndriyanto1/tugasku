<!DOCTYPE html>
<html>
<head>
    <title>Edit Tugas</title>

    <style>
        body{
            font-family:Arial;
            background:#f4f6f9;
            padding:40px;
        }

        .container{
            max-width:700px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:12px;
        }

        input{
            width:100%;
            padding:10px;
            margin-bottom:15px;
        }

        button{
            padding:10px 20px;
            border:none;
            background:#3498db;
            color:white;
            border-radius:8px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Edit Tugas</h1>

    <form action="/tasks/{{ $task->id }}"
          method="POST">

        @csrf
        @method('PATCH')

        <label>Nama Tugas</label>

        <input
            type="text"
            name="title"
            value="{{ $task->title }}"
            required>

        <label>Deadline</label>

        <input
            type="date"
            name="due_date"
            value="{{ $task->due_date }}"
            required>

        <button type="submit">
            Simpan Perubahan
        </button>

    </form>

</div>

</body>
</html>