
<div class="content-wrapper">
  <div class="container-fluid">
      <!-- Page Heading -->
      <h1 class="h3 mb-2 mt-2 text-gray-800">Scan barcode Pengeluaran Barang</h1>

      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Barang</h6>
          </div>
          <div class="card-body">
            <div class="container">
              <video id="preview" style="width: 100%; max-height: 250px; border-radius: 8px;"></video>
              <input type="text" style="width: 100%; max-height: 250px; border-radius: 8px;" id="scanResult" class="form-control mt-3" placeholder="Hasil scan akan muncul di sini" readonly>
            </div>
          </div>
      </div>
  </div>

  <audio id="beep" src="{{ asset('assets/sound/beep-sound-8333.mp3') }}" autostart="false" ></audio>
</div>


<script type="text/javascript">
  let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
  scanner.addListener('scan', function (content) {
    document.getElementById('scanResult').value = content;
    document.getElementById('beep').play();
  });
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });
</script>

