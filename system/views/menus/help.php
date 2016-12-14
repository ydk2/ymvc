
        <div class="row" id="editmenu">
          <div class="col-md-12">
            <h1>Heading</h1>
          </div>

          <div class="col-md-4">
            <pre>
              <code>&lt;section&gt;</code>
            </pre>
          </div>
          <div class="col-md-8">
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
              <a type="button" href="<?=HOST_URL ?>?admin:menus" class="btn btn-primary" >Edit Menu</a>
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
