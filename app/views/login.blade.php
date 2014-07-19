@extends('master')

@section('title')
	<script type="text/javascript">
	    $(document).ready(function() {
	    	$("#signup").click(function (e) {
	            e.preventDefault();
	            $('#signup').disabled;
	            $('.loader').html('<img src="images/loader.gif" width="16"/> Please Wait...');

	            if($('#email').val() === '' || $('#password').val() === '') {
	            	//send error
	            	$('.error').html('<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>All feilds are required.</div>');
	            	$('.loader').html('');
	            	return false;
	            }

	            var email = $('#email').val();
	            var password = $('#password').val();

	            jQuery.ajax({
		            type: "POST",
		            url: "/signup", //Where form data is sent on submission
		            dataType:"HTML", // Data type, HTML, json etc.
		            data:{ email: email, password: password }, //Form variables
		            success:function(data){
		                $('#regform').html('');
		                $('.error').html(data);

		            },
		            error:function (xhr, ajaxOptions, thrownError){
		                $('.error').html('<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>'+ thrownError +'</div>');
		            	$('.loader').html('');
		            	return false;
		            }
	            });
	    	});
		});
	</script>
	<title>Simple PHP login using Qr-Code and Laravel</title>
@stop

@section('section')
	<div class="row container">
	  <div class="col-md-7">
	  	<h1>Simple PHP login using Qr-Code and Laravel</h1>
	  	<p>This is a simple implimentation of PHP login system using qrcode and laravel php framework. To register an account please click on the botton below.</p>
	  	<!-- Button trigger modal -->
		<button class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal">
		  SignUp
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="myModalLabel">User SignUp</h4>
		      </div>
		      <div class="modal-body">
		      	<div class="error"></div>
		        <form role="form" id="regform">
		        	<div class="form-group">
			        	<label for="email">Email:</label>
			        	<input type="email" class="form-control" id="email" placeholder="Email">
		        	</div>
		        	<div class="form-group">
			        	<label for="password">Password:</label>
			        	<input type="password" class="form-control" id="password" placeholder="Password">
		        	</div>
		        	<button id="signup" class="btn btn-danger btn-lg">SignUp</button> <span class="loader"></span>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
	  </div>
	  <div class="col-md-5">
		  	<h1>Login</h1>
		  	<p>Please use your qrcode to login below.</p>
	  	  	<div class="loginerror"></div>

			<div class="loginform">
				<div class="boxWrapper">
					<div id="example"></div>
				</div>

				<div class="button">
					<a id="button" class="btn btn-lg btn-primary">Scan QR code</a> <span class="lloader"></span>
				</div>
			</div>	
	  </div>
	</div>
@stop