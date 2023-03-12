<div id="form_success" style="background-color:green; color:#fff;"></div>
<div id="form_error" style="background-color:red; color:#fff;"></div>

<form id="enquiry_form">


      <?php wp_nonce_field('wp_rest');?>

      <label>Greeting</label><br />
      <input type="text" name="greeting"><br /><br />

      <button type="submit">Submit form</button>

</form>

<script>

      jQuery(document).ready(function($){


            $("#enquiry_form").submit( function(event){

                  event.preventDefault();

                  $("#form_error").hide();

                  var form = $(this);

                  $.ajax({


                        type:"POST",
                        url: "<?php echo get_rest_url(null, 'v1/greetings-form/submit');?>",
                        data: form.serialize(),
                        success: function(res){

                              $("#form_success").html(res).fadeIn();


                        },
                        error: function(){
                              $("#form_error").html("There was an error submitting").fadeIn();
                        }


                  })


            });


      });

</script>