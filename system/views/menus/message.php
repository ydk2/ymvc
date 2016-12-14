 
        <div class="row" id="editmenu">
          <div class="col-md-12">
            <div class="jumbotron">
              <h1><?=$this->alert_header?></h1>
              <p><?=$this->alert_string?></p>
              <p> 
              	<a href="<?=HOST_URL?>?<?=$this->alert_link?>" class="btn btn-primary">OK</a>
              </p>
            </div>
    <script>
      $('a').click(function(event) {
        event.preventDefault();
        $.ajax({
          url: $(this).attr('href'),
          beforeSend: function() {
            $("#editmenu").replaceWith("<div id=\"editmenu\"><h1>Otwieram...</h1></div>");
          },
          success: function(response) {
            //alert(response)
            //$( "html" ).replaceWith( response);
            $("#editmenu").html($(response).find("#editmenu"));
          }
        })
        return false; //for good measure
      });
    </script>
          </div>
        </div>
  
