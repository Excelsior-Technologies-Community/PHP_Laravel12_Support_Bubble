<!DOCTYPE html>
<html>

<head>

    <title>Support Dashboard</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#0f172a;
            padding:30px;
            color:white;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
            flex-wrap:wrap;
            gap:20px;
        }

        .top-bar h1{
            font-size:32px;
        }

        .stats{
            display:flex;
            gap:20px;
            flex-wrap:wrap;
        }

        .card{
            background:#1e293b;
            padding:20px;
            border-radius:15px;
            min-width:180px;
            box-shadow:0 5px 15px rgba(0,0,0,0.4);
        }

        .card h2{
            font-size:28px;
            margin-bottom:10px;
        }

        .card p{
            color:#94a3b8;
        }

        .table-container{
            overflow-x:auto;
            background:#1e293b;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,0.4);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        thead{
            background:#2563eb;
        }

        th{
            padding:18px;
            text-align:left;
            font-size:15px;
        }

        td{
            padding:18px;
            border-bottom:1px solid #334155;
            font-size:14px;
        }

        tr:hover{
            background:#273449;
        }

        .pending{
            background:#f59e0b;
            color:white;
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .resolved{
            background:#10b981;
            color:white;
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .resolve-btn{
            background:#10b981;
            color:white;
            text-decoration:none;
            padding:10px 16px;
            border-radius:8px;
            font-size:13px;
            transition:0.3s;
        }

        .resolve-btn:hover{
            background:#059669;
        }

        .message-box{
            max-width:250px;
            word-break:break-word;
        }

        @media(max-width:768px){

            .top-bar{
                flex-direction:column;
                align-items:flex-start;
            }

            .stats{
                width:100%;
            }

            .card{
                width:100%;
            }

        }

    </style>

</head>

<body>

    <div class="top-bar">

        <h1>🎧 Support Dashboard</h1>

        <div class="stats">

            <div class="card">

                <h2>{{ $messages->count() }}</h2>

                <p>Total Messages</p>

            </div>

            <div class="card">

                <h2>{{ $messages->where('status','Pending')->count() }}</h2>

                <p>Pending</p>

            </div>

            <div class="card">

                <h2>{{ $messages->where('status','Resolved')->count() }}</h2>

                <p>Resolved</p>

            </div>

        </div>

    </div>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Subject</th>

                    <th>Message</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($messages as $message)

                <tr>

                    <td>#{{ $message->id }}</td>

                    <td>{{ $message->name }}</td>

                    <td>{{ $message->email }}</td>

                    <td>{{ $message->subject }}</td>

                    <td class="message-box">
                        {{ $message->message }}
                    </td>

                    <td>

                        @if($message->status == 'Pending')

                            <span class="pending">
                                Pending
                            </span>

                        @else

                            <span class="resolved">
                                Resolved
                            </span>

                        @endif

                    </td>

                    <td>

                        @if($message->status == 'Pending')

                            <a href="/resolve/{{ $message->id }}"
                               class="resolve-btn">

                               Resolve

                            </a>

                        @else

                            ✅ Done

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" style="text-align:center;padding:30px;">
                        No support messages found.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</body>

</html>