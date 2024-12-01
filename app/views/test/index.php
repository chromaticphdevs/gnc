<html>
    <head>
      <script src="http://dev.mlm-breakthrough/public/js/core/conf.js"></script>
    </head>

    <body>

      <button id="ajaxBTN"> AJAX BTN </button>
      <script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>


      <script>

        $( document ).ready(function(evt) {

          $("#ajaxBTN").click(function(evt){

            let myURL = get_url('test/store');

            $.ajax({
              method:'post',
              action: get_url('test/store'),
              data: {id: '1'} ,

              success : function( response ){

                console.log(response);
              }
            });

          });
        });
      </script>
    </body>
  </html>