<!DOCTYPE html>
<html>
<head>
    <title>Tugasku</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background:#f4f6f9;
            padding:40px;
        }

        .container{
            max-width:800px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 15px rgba(0,0,0,0.1);
        }

        h1{
            text-align:center;
            margin-bottom:30px;
            color:#2c3e50;
        }

        form{
            margin-bottom:20px;
        }

        label{
            font-weight:bold;
            display:block;
            margin-bottom:5px;
        }

        input[type="text"],
        input[type="date"]{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            margin-bottom:15px;
        }

        button{
            background:#3498db;
            color:white;
            border:none;
            padding:10px 18px;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#2980b9;
        }

        .task-card{
            border:1px solid #e0e0e0;
            border-radius:10px;
            padding:15px;
            margin-bottom:15px;
            background:#fafafa;
        }

        .task-title{
            font-size:18px;
            font-weight:bold;
            color:#2c3e50;
        }

        .task-date{
            color:#666;
            margin-top:5px;
            margin-bottom:10px;
        }

        .completed{
            color:green;
            font-weight:bold;
        }

        .actions{
            margin-top:10px;
        }

        .actions form{
            display:inline;
        }

        .btn-success{
            background:#27ae60;
        }

        .btn-success:hover{
            background:#219150;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>📋 Tugasku</h1>

    <form action="/tasks" method="POST">
        @csrf

        <label>Nama Tugas</label>
        <input type="text" name="title" required>

        <label>Deadline</label>
        <input type="date" name="due_date" required>

        <button type="submit">
            Tambah Tugas
        </button>
    </form>

    <hr style="margin:20px 0;">

    @forelse($tasks as $task)

        <div class="task-card">

            <div class="task-title">
                {{ $task->title }}
            </div>

            <div class="task-date">
                Deadline: {{ $task->due_date }}
            </div>

            @if($task->completed)

                <div class="completed">
                    ✅ Selesai
                </div>

            @else

            <div class="actions">

                <form action="/tasks/{{ $task->id }}/complete"
                      method="POST">
            
                    @csrf
                    @method('PATCH')
            
                    <button class="btn-success" type="submit">
                        Tandai Selesai
                    </button>
            
                </form>
            
                <a href="/tasks/{{ $task->id }}/edit">
                    <button type="button">
                        Edit
                    </button>
                </a>
            
                <form action="/tasks/{{ $task->id }}"
                      method="POST"
                      style="display:inline;">
            
                    @csrf
                    @method('DELETE')
            
                    <button
                        type="submit"
                        onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                        Hapus
                    </button>
            
                </form>
            
            </div>

            @endif

        </div>

    @empty

        <p>Belum ada tugas.</p>

    @endforelse

</div>

</body>
</html>