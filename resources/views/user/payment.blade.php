<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h2>Menyiapkan pembayaran...</h2>

    <script type="text/javascript">
        window.onload = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert("Pembayaran berhasil!");
                    console.log(result);
                    window.location.href = "/subscription/success"; // ganti sesuai route kamu
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran...");
                    console.log(result);
                    window.location.href = "/subscription/pending";
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                    console.log(result);
                    window.location.href = "/subscription/error";
                }
            });
        };
    </script>
</body>
</html>
