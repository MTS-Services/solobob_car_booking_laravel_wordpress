<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Accepted</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #10b981;
        }
        .header h1 {
            color: #10b981;
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px 0;
        }
        .booking-info {
            background: #f9fafb;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .booking-info h3 {
            margin-top: 0;
            color: #1f2937;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #6b7280;
        }
        .value {
            color: #1f2937;
        }
        .button {
            display: inline-block;
            padding: 14px 30px;
            background: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background: #059669;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .success-icon {
            text-align: center;
            font-size: 60px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Booking Accepted!</h1>
        </div>

        <div class="content">
            <div class="success-icon">
                ✅
            </div>

            <p>Dear <strong>{{ $booking->user->name }}</strong>,</p>

            <p>Great news! Your booking has been <strong style="color: #10b981;">accepted</strong> and is now confirmed.</p>

            <div class="booking-info">
                <h3>Booking Details</h3>
                <div class="info-row">
                    <span class="label">Booking Reference:</span>
                    <span class="value"><strong>{{ $booking->booking_reference }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Vehicle:</span>
                    <span class="value">{{ $booking->vehicle?->title ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Pickup Date:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y H:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Return Date:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y H:i A') }}</span>
                </div>
                {{-- <div class="info-row">
                    <span class="label">Pickup Location:</span>
                    <span class="value">{{ $booking->pickupLocation?->name ?? 'N/A' }}</span>
                </div> --}}
                <div class="info-row">
                    <span class="label">Total Amount:</span>
                    <span class="value"><strong>${{ number_format($booking->total_amount ?? 0, 2) }}</strong></span>
                </div>
            </div>

            <p>You can view your complete booking details by clicking the button below:</p>

            <center>
                <a href="{{ $bookingUrl }}" class="button">View Booking Details</a>
            </center>

            <p><strong>What's Next?</strong></p>
            <ul>
                <li>Please ensure all your documents are up to date</li>
                <li>Arrive at the pickup location on time</li>
                <li>Bring a valid ID and driver's license</li>
                <li>Review the rental agreement carefully</li>
            </ul>

            <p>If you have any questions or need to make changes to your booking, please don't hesitate to contact us.</p>

            <p>Thank you for choosing our service!</p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>