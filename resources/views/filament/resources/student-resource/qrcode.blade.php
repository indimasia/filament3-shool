<div class='flex'>
    <div>QRCode</div>
    <div id="qrcode" style="width:100px; height:100px; margin-top:12px; margin-left:80px"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width: 100,
        height: 100
    });

    function makeCode() {
        var elText = {{ $getRecord()->nis }};

        qrcode.makeCode(elText);
    }

    makeCode();
</script>