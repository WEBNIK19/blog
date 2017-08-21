<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6">
			<form action="" method="POST">
				<div class="form-group">
				<label for="email">E-mail</label>
				<input name="email" id="email" type="text" class="form-control">
				</div>
				<div class="form-group">
				<label for="pass">Password</label>
				<input name="password" id="pass" type="password" class="form-control" aria-describedby="passhelp">
				</div>
				<span class="help-block" id="passhelp">
				<?=@$this->error;?></span>
				<div class="form-group">
				<button class="btn btn-success" type="submit">Войти</button>
				</div>			
			</form>
		</div>
	</div>
</div>