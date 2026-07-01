<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; }
        .email-card { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .email-header { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #ffffff; padding: 30px 20px; text-align: center; }
        .email-header h2 { margin: 0; font-size: 24px; font-weight: 600; }
        .email-body { padding: 30px; }
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .meta-table td { padding: 12px 10px; border-bottom: 1px solid #f3f4f6; font-size: 14px; }
        .meta-label { font-weight: 600; color: #4b5563; width: 30%; }
        .meta-value { color: #1f2937; }
        .badge-cat { background: #e0e7ff; color: #4f46e5; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .message-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; color: #334155; font-size: 15px; line-height: 1.6; margin-top: 10px; }
        .email-footer { background: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #f3f4f6; }
        .btn-panel { display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="email-header">
            <h2>New Support Ticket Raised</h2>
        </div>
        <div class="email-body">
            <table class="meta-table">
                <tr>
                    <td class="meta-label">Complainant</td>
                    <td class="meta-value">{{ $support->name }}</td>
                </tr>
                <tr>
                    <td class="meta-label">Email Address</td>
                    <td class="meta-value">{{ $support->email }}</td>
                </tr>
                <tr>
                    <td class="meta-label">Category Group</td>
                    <td class="meta-value"><span class="badge-cat">{{ $support->category }}</span></td>
                </tr>
                <tr>
                    <td class="meta-label">Subject Issue</td>
                    <td class="meta-value">{{ $support->subject }}</td>
                </tr>
            </table>
            <div style="font-weight: 600; color: #4b5563; font-size: 14px;">User Description Message:</div>
            <div class="message-box">
                {{ $support->message }}
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('admin.messages') }}" class="btn-panel">Open Control Desk</a>
            </div>
        </div>
        <div class="email-footer">
            <p style="margin: 0; font-size: 12px; color: #9ca3af;">Automated customer support routing pipeline system</p>
        </div>
    </div>
</body>
</html>