@extends('layouts.app')

@section('title', 'Admin Dashboard | Support Desk')

@section('styles')
<style>
    .panel-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .header-card { background: white; border-radius: 12px; padding: 20px 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
    .header-card h1 { font-size: 24px; font-weight: 700; color: #1e1e2f; margin: 0; }
    .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 25px; }
    .card-widget { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .widget-value { font-size: 32px; font-weight: 700; color: #111827; }
    .widget-label { font-size: 13px; color: #6b7280; font-weight: 500; margin-top: 4px; }
    .widget-pending { color: #f59e0b !important; }
    .widget-resolved { color: #10b981 !important; }
    .table-container { background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
    .table-custom { width: 100%; border-collapse: collapse; margin: 0; }
    .table-custom th { background: #f9fafb; padding: 14px 20px; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; }
    .table-custom td { padding: 14px 20px; font-size: 14px; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .tag-badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block; }
    .tag-pending { background: #fef3c7; color: #d97706; }
    .tag-resolved { background: #d1fae5; color: #065f46; }
    .tag-bug { background: #fee2e2; color: #dc2626; }
    .tag-billing { background: #e0f2fe; color: #0369a1; }
    .tag-inquiry { background: #f3f4f6; color: #4b5563; }
    .btn-resolve-trigger { background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-resolve-trigger:hover { background: #059669; }
    .img-thumb { width: 40px; height: 40px; border-radius: 6px; object-fit: cover; cursor: pointer; border: 1px solid #e5e7eb; }
</style>
@endsection

@section('content')
<div class="panel-container">
    <div class="header-card">
        <h1>Support Tickets Desk</h1>
        <a href="/" class="btn btn-outline-secondary btn-sm">Exit Desk</a>
    </div>

    <div class="stats-row">
        <div class="card-widget">
            <div class="widget-value">{{ $messages->count() }}</div>
            <div class="widget-label">Total Submissions</div>
        </div>
        <div class="card-widget">
            <div class="widget-value widget-pending">{{ $messages->where('status', 'Pending')->count() }}</div>
            <div class="widget-label">Pending Reviews</div>
        </div>
        <div class="card-widget">
            <div class="widget-value widget-resolved">{{ $messages->where('status', 'Resolved')->count() }}</div>
            <div class="widget-label">Resolved Tasks</div>
        </div>
    </div>

    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Requester</th>
                    <th>Classification</th>
                    <th>Subject Description</th>
                    <th>Core Details</th>
                    <th>Attachment Screen</th>
                    <th>Status</th>
                    <th>Action Override</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr>
                    <td>
                        <div class="font-weight-600">{{ $msg->name }}</div>
                        <div class="small text-muted">{{ $msg->email }}</div>
                    </td>
                    <td><span class="tag-badge tag-{{ strtolower($msg->category) }}">{{ $msg->category }}</span></td>
                    <td>{{ $msg->subject }}</td>
                    <td title="{{ $msg->message }}">{{ Str::limit($msg->message, 50) }}</td>
                    <td>
                        @if($msg->attachment_path)
                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $msg->attachment_path) }}" class="img-thumb">
                            </a>
                        @else
                            <span class="text-muted small">None</span>
                        @endif
                    </td>
                    <td><span class="tag-badge tag-{{ strtolower($msg->status) }}">{{ $msg->status }}</span></td>
                    <td>
                        @if($msg->status === 'Pending')
                            <form action="{{ route('resolve.message', $msg->id) }}" method="POST" style="margin:0">
                                @csrf
                                <button type="submit" class="btn-resolve-trigger">Resolve</button>
                            </form>
                        @else
                            <span class="text-success small font-weight-600"><i class="fas fa-check-circle"></i> Complete</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted small">No active support interactions registered in system logs.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<audio id="alertPingNode" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-600.wav" preload="auto"></audio>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let originalTabTitle = document.title;
    let titleTickerInterval = null;

    function ringNotificationPipeline() {
        $.get('/support/unread-count', function(response) {
            if (response.new_messages && response.count > 0) {
                document.getElementById('alertPingNode').play().catch(e => console.log('Audio contextual blockage'));
                
                if (titleTickerInterval) clearInterval(titleTickerInterval);
                
                let flag = true;
                titleTickerInterval = setInterval(() => {
                    document.title = flag ? `(${response.count}) New Support Ticket!` : originalTabTitle;
                    flag = !flag;
                }, 1000);
            }
        });
    }

    $(document).ready(function() {
        setInterval(ringNotificationPipeline, 10000);
        $(window).on('focus', function() {
            if (titleTickerInterval) {
                clearInterval(titleTickerInterval);
                document.title = originalTabTitle;
            }
        });
    });
</script>
@endsection