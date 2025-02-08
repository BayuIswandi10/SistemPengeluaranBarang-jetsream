
<html>
<head>
    <title>Approval Notification</title>
</head>
<body>
    <p>Dear {{ $approvedBy }},</p>
    <p>Pengeluaran Barang ID: {{ $pengeluaranBarangId }}</p>
    <p>Status: {{ $status }}</p>
    <p>--------------------------------------------------</p>
    {{-- <p>Silakan scan QR Code berikut untuk melihat detail:</p>
    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(256)->generate($pengeluaranBarangId)) !!}"> --}}

    <p>Terima kasih! , Hormat kami YMI-DLTP</p>
</body>
</html>
