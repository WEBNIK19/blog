<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-6 col-lg-offset-3">
		
			<form enctype="multipart/form-data" action=""  method="post">
				<div class="form-group">
					<label for="log">Login</label>
					<input id="log" name="login" type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="em">Email</label>
					<input id="em" name="email" type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="im">Avatar</label>
					<input id="im" name="avatar" type="file" >
				</div>
				<div class="form-group <?=@$this->error['style']?>">
					<label for="pass" class="control-label">Password</label>
					<input id="pass" name="password" type="password" class="form-control" aria-describedby="passhelp1">
					<span class="help-block" id="passhelp1"><?=@$this->error['message']?></span>
				</div>
				<div class="form-group <?=@$this->error['style']?>">
					<label for="pass" class="control-label">Retype password</label>
					<input id="repass" name="repassword" type="password" class="form-control" aria-describedby="passhelp2">
					<span class="help-block" id="passhelp2"><?=@$this->error['message']?></span>
				</div>
				<div class="form-group btn-toolbar">
					<div class="btn-group">
						<input type="submit" class="btn btn-success" onclick="alert('Вы успешно зарегистрировались!')" value="Зарегистрироваться">
						<input type="reset" class="btn btn-danger" value="Сбросить"> 
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

