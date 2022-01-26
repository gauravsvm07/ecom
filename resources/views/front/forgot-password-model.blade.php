<!-- The login Modal -->
<div class="user-popup modal fade" id="forgotModal">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header close-btn">
            <h4 class="modal-title">Forgot Password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="comment-form">
               <span class="text-success success_msg_forgot"></span><br><br>
               <form class="row">
                  <div class="col-sm-12">
                     <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="forgot_email" id="forgot_email" placeholder="Email Address">
                     </div>
                  </div>


                  <div class="col-sm-12">
                     <div class="form-group">
                        <div class="user-login-btn contact-btn">
                           <button type="button" class="btn blue-btn" id="forgotBtn">Submit</button>
                        </div>
                     </div>
                  </div>

               </form>
            </div>
         </div>
      </div>
   </div>
</div>


<script>
   $(document).ready(function() {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         }
      });



      /////////////Start Reset Password///////////////

      $('#forgotBtn').on('click', function() {
         var forgot_email = $('#forgot_email').val();
         var csrf_token = $('input[name="csrf_token"]').val();

         $.ajax({
            url: "{{url('reset-password')}}",
            type: "post",
            data: {
               forgot_email: forgot_email,
               _token: csrf_token
            },
            success: function(data) {
               $('.success_msg_forgot').show();
               $('.success_msg_forgot').text(data.msg);
               $('.text-danger').hide();
            },
            error: function(response) {
               $(document).find("span.text-danger").empty();
               $(".textdanger").empty();
               $.each(response.responseJSON.errors, function(field_name, error) {
                  $(document).find('[name=' + field_name + ']').after('<span class="text-strong danger text-danger">' + error + '</span>').focus();
               });
            }

         });


      });

      ///////////////////////End Reset Password/////////////////////////////


   });
</script>