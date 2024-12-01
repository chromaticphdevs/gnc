<?php build('content') ?>
<div class="col-md-5 mx-auto" style="margin-top:50px; margin-bottom: 50px;">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">SCAN QR</h4>
    </div>
    <div class="card-body">
      <?php Flash::show();?>
      <div id="reader" width="600px" height="600px"></div>
      <input type="file" id="qr-input-file" accept="image/*">
        <div id="formContainer" style="display:none">
          <form method="post" enctype="multipart/form-data">
          	<div class="form-group">
          		<?php Form::hidden('qrValue','', ['id' => 'qrValue'])?>
          	</div>

          	<div class="form-group">
          		<?php
          			Form::submit('', 'SCAN QR', [
          				'class' => 'btn btn-primary btn-sm mt-3',
          			]);
          		?>
          	</div>
          </form>
        </div>
    </div>
  </div>
</div>
<?php endbuild()?>

<?php build('scripts')?>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script type="text/javascript" defer>
    const html5QrCode = new Html5Qrcode(/* element id */ "reader");
    // File based scanning
    const fileinput = document.getElementById('qr-input-file');
    fileinput.addEventListener('change', e => {
      if (e.target.files.length == 0) {
        // No file selected, ignore 
        return;
      }

      const imageFile = e.target.files[0];
      // Scan QR Code
      html5QrCode.scanFile(imageFile, true)
      .then(decodedText => {
        // success, use decodedText
        $("#formContainer").show();
        $("#qrValue").val(decodedText);
      })
      .catch(err => {
        // failure, handle it.
        console.log(`Error scanning file. Reason: ${err}`)
      });
    });

    // Note: Current public API `scanFile` only returns the decoded text. There is
    // another work in progress API (in beta) which returns a full decoded result of
    // type `QrcodeResult` (check interface in src/core.ts) which contains the
    // decoded text, code format, code bounds, etc.
    // Eventually, this beta API will be migrated to the public API.
  </script>
<?php endbuild()?>
<?php occupy('templates/tmp/landing')?>