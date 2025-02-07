<x-guest-layout>
  <head>
      <style>
          body {
              display: flex;
              align-items: center;
              justify-content: center;
              height: 100vh;
              margin: 0;
              background-repeat: no-repeat;
              background-size: cover;
          }

          .login-box {
              width: 400px;
          }

          .nav-static-top {
              top: 0;
              left: 0;
              right: 0;
              position: fixed;
              height: 70px;
              width: 100% !important;
              box-shadow: 0px 2px 0px 0px #eee;
              background-color: white;
              z-index: 4;
              opacity: 0.9;
          }

          .login-card {
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
              border-radius: 8px;
          }
      </style>
  </head>

  <body>
    <div class="nav-static-top d-flex justify-content-between align-items-center p-3 bg-light">
        <div class="float-left">
            <a href="#">
                <img class="mt-3 ml-4" src="{{ asset('assets/img/logo YMI-DLT.png') }}" style="height:40px;">
            </a>
        </div>

    </div>

    <div class="login-box">
        <div class="card card-outline card-primary login-card">
            <div class="card-body">
              <video id="preview"></video>
              <input type="text" id="scanResult" class="form-control mt-3" placeholder="Hasil scan akan muncul di sini" readonly>
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

  </body>
</x-guest-layout>


