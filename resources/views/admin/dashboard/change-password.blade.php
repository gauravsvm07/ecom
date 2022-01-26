<div class="card">
<div class="card-body">
	<h5 class="card-title">Change Password</h5>

	<div class="alert alert-danger print-error-msg" style="display:none">
		<button type="button" class="close" data-dismiss="alert">×</button>
        <ul></ul>
    </div>
    <div class="alert alert-danger error_msg" style="display:none"> 
      <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    <div class="alert alert-success success_msg" style="display:none">
      <button type="button" class="close" data-dismiss="alert">×</button>
     </div>
	<div class="row">
		   
		<div class="col-md-10 col-lg-6">
			<form id="pwd_form">
				<div class="form-group">
					<label>Old Password</label>
					<input name="current_password" id="current_password" type="password" class="form-control">
				</div>
				<div class="form-group">
					<label>New Password</label>
					<input name="password" type="password" id="password" class="form-control">
				</div>
				<div class="form-group">
					<label>Confirm Password</label>
					<input name="password_confirmation" id="password_confirmation" type="password" class="form-control">
				</div>
				<button class="btn btn-primary pwdBtn" type="button">Save Changes</button>
			</form>
		</div>
	</div>
</div>
</div>

<script>
$(document).ready(function(){

$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
			}
		});

$('.pwdBtn').on('click',function(){
var current_password = $('#current_password').val();
var password = $('#password').val();
var password_confirmation = $('#password_confirmation').val();
var csrf_token = $('input[name="csrf_token"]').val();
$.ajax({
url: "{{url('auth/update-password')}}",
type: "post",
data: {current_password:current_password,password:password,password_confirmation:password_confirmation,_token:csrf_token},
success:function(data){
// alert(data.success);	
if($.isEmptyObject(data.errors)){
if(data.success == 'true')	
{
$('.error_msg').hide();	
$('.success_msg').show();	
$('.success_msg').text(data.msg);
$('.print-error-msg').hide();
$('pwd_form')[0].reset()
}else
{
$('.error_msg').show();	
$('.success_msg').hide();	
$('.print-error-msg').hide();
$('.error_msg').text(data.msg);
}

}else{
$('.print-error-msg').show();
printErrorMsg(data.errors);
}
}
});
});


function printErrorMsg (msg) {
$(".print-error-msg").find("ul").html('');
$(".print-error-msg").css('display','block');
$.each( msg, function( key, value ) {
$(".print-error-msg").find("ul").append('<li>'+value+'</li>');
});
}

});	
</script>