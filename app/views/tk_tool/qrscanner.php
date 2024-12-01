<?php build('content') ?>
	<div class="col-md-6 col-sm-12">
		<div class="form-group">
			<label for="#">Amount</label>
			<input type="text" id="amount" class="form-control">
		</div>

		<a href="#" id="scanner">Scanner</a>
		<div id="reader" width="600px"></div>
	</div>
<?php endbuild()?>
	
<?php build('scripts')?>
<script src="<?php echo URL.DS.'vendors/qrscanner/html5-qrcode/minified/html5-qrcode.min.js'?>"></script>
<script defer>

	$( document ).ready( function(evt) {
		$("#scanner").click( function() {
            callScanner();
        });
	});

	function callScanner()
	{
		// This method will trigger user permissions
		Html5Qrcode.getCameras().then(devices => {
		  /**
		   * devices would be an array of objects of type:
		   * { id: "id", label: "label" }
		   */
		  if (devices && devices.length) 
		  {
		    var cameraId = null;

		  	for(let i in devices) 
		  	{
		  		var cameraLabel = devices[i].label;

		  		cameraId = devices[0].id;
		  		if(cameraLabel.search('back'))
		  			cameraId = devices[i].id;
		  	}
		    // .. use this to start scanning.
		    html5QrCode.start(
			  cameraId, 
			  {
			    fps: 10,    // Optional frame per seconds for qr code scanning
			    qrbox: 250// Optional if you want bounded box UI
			  },
			  qrCodeMessage => 
			  {
			  	sendWallet(qrCodeMessage);
			  	html5QrCode.stop().then(ignore => {
				  // QR Code scanning is stopped.
				}).catch(err => {
				  // Stop failed, handle it.
				});
			  	// onScanSuccess(qrMessage);
			  },
			  errorMessage => {
			    // parse error, ignore it.
			    console.log('err');
			  })
			.catch(err => {
			  // Start failed, handle it.
			  console.log('catch');
			});
		  }
		}).catch(err => {
		  // handle err
		});

		const html5QrCode = new Html5Qrcode("reader", /* verbose= */ true);
	}

	function sendWallet(qrMessage) 
	{

		alert('yayari-in tayo');
	}
</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>