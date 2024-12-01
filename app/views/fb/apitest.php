<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


	<form method="post">
		
	</form>
	<div class="fb-post" 
		data-href="https://www.facebook.com/markangelogonzales13/posts/2620612101366942?notif_id=1575746085856218&notif_t=feedback_reaction_generic&ref=notif" 
		data-width="500" 
		data-show-text="true" 
		id="sharelink">
	</div>


	<button onclick="shareme()">
		dreambusinessbuildersint@gmail.com

		socialnetwork111
	</button>

	<script type="text/javascript">


	  let sharelink = document.getElementById('sharelink');

	  function shareme(){
	    FB.init({ appId : '571613676982309', autoLogAppEvents : true,  xfbml : true, version : 'v3.2' });
	    FB.ui({
	      method: 'like',
	      href: sharelink.dataset.href,
	      }, 
	      function(response) {
	        if (response && !response.error_code) {
	          // alert('Kumita kana');
	          $('#sharesuccessModal').modal({
	            backdrop: 'static',
	            keyboard: false
	        })         
	      }else{
	      	alert('Error while posting.');
	      }
	    });
	  }
	</script>

	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>
</body>
</html>