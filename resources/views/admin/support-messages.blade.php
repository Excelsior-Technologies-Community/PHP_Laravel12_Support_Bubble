{{-- resources/views/admin/support-messages.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | Support Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            padding: 30px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .dashboard-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
        }

        .back-link {
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .back-link:hover {
            color: #4f46e5;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-card .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-card .stat-label {
            color: #6b7280;
            font-size: 14px;
            margin-top: 8px;
        }

        .stat-card.pending .stat-value { color: #f59e0b; }
        .stat-card.resolved .stat-value { color: #10b981; }

        /* Table */
        .table-wrapper {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 16px 20px;
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #4b5563;
        }

        tr:hover {
            background: #f9fafb;
        }

        .message-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-resolved {
            background: #d1fae5;
            color: #059669;
        }

        .resolve-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .resolve-btn:hover {
            background: #059669;
        }

        .resolved-text {
            color: #10b981;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .empty-state {
            text-align: center;
            padding: 60px;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            th, td {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Support Messages</h1>
            <a href="/" class="back-link">← Back to Home</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $messages->count() }}</div>
                <div class="stat-label">Total Messages</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-value">{{ $messages->where('status', 'Pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card resolved">
                <div class="stat-value">{{ $messages->where('status', 'Resolved')->count() }}</div>
                <div class="stat-label">Resolved</div>
            </div>
        </div>

        <div class="table-wrapper">
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
                        <td class="message-preview" title="{{ $message->message }}">
                            {{ Str::limit($message->message, 60) }}
                        </td>
                        <td>
                            @if($message->status == 'Pending')
                                <span class="badge badge-pending">Pending</span>
                            @else
                                <span class="badge badge-resolved">Resolved</span>
                            @endif
                        </td>
                        <td>
                            @if($message->status == 'Pending')
                                <form action="/resolve/{{ $message->id }}" method="GET" style="margin:0">
                                    <button type="submit" class="resolve-btn">✓ Mark Resolved</button>
                                </form>
                            @else
                                <span class="resolved-text">✓ Resolved</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            No support messages yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>