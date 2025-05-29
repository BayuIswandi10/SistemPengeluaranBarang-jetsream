<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #ffffff; color: #000000; padding: 20px;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <tr>
            <td style="text-align: center; padding: 20px; background-color: #ffffff; color: #000000;">
                <img src="{{ $message->embed(public_path('assets/img/logo-YMI-DLTP.png')) }}" alt="YMI Logo" style="height: 50px;">
                <h1 style="margin: 10px 0;">Approval Notification</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; color: #333333;">
                <p><strong>Dari:</strong> {{ $approvedBy }}, {{ $fromDepartment }}</p>
                <p><strong>Pengeluaran Barang ID:</strong> {{ $pengeluaranBarangId }}</p>
                <p><strong>Status:</strong> {{ $status }}</p>

                @if (!empty($reason))
                    <p><strong>Alasan:</strong> {{ $reason }}</p>
                @endif
                
                <p>Silakan cek sistem untuk informasi lebih lanjut.</p>
                <p>Scan QR Code di bawah untuk melihat detail:</p>
                <p style="text-align: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($pengeluaranBarangId) }}" alt="QR Code">
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center; color: #777777;">
                <p>Terima kasih!</p>
                <p><strong>Hormat kami,</strong><br>YMI-DLTP</p>
            </td>
        </tr>
    </table>
</body>
</html>
