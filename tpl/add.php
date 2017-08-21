<div class="container">
	<div class="row">
		<form action="" class="col-lg-6 col-lg-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1" method="POST">
			<div class="form-group">
				<div class="input-group"><div class="input-group-addon"><label for="theme">Тема:</label></div>
				<input type="text" id="theme" name="title" class="form-control" value="<?=@$this->post['title']?>">
			</div>
		</div><div class="form-group">
			<textarea name="post" cols="30" rows="10" class="form-control"><?=@$this->post['post']?></textarea>
		</div>
		
		<div class="form-group">
			<div class="btn-toolbar pull-right"><button type="submit" class="btn btn-success">Добавить</button><button type="reset" class="btn btn-danger">Сбросить</button></div>
		</div>
	</form>
</div>
</div>
