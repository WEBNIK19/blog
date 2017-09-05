

	<div class="row">
		<div class="col-lg-offset-2 col-lg-8">
			<h1 class="page-header"><?=$this->post['title']?></h1>
			<div class="container-fluid">
				<p class="lead text-justify"><?=$this->post['post']?></p>
				<?php if($this->user){?><div class="btn-toolbar pull-right">
					<a <?='href="/?edit/'.$this->post['id'].'"'?> class="btn  btn-success btn-lg pull-right"><i class="glyphicon glyphicon-pencil"></i> Редактировать</a>
					<a <?='href="/?del/'.$this->post['id'].'"'?> class="btn  btn-danger btn-lg pull-right" onclick="return confirm('Точно удалить?');"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
				</div><?php }?>
			</div>
			<hr>
			<div class="comments">
				<?php foreach($this->comments as $key=>$c){?>
				<div class="comment">
					<b><?=$c['author']?></b>: <?=$c['comment']?>
					<?php if($this->user) { ?> <a href="/?delComment/<?=$c['id'].'/'.$this->post['id']?>" class="btn btn-danger btn-xs" onclick="return confirm('Точно удалить?');" >Удалить</a><?php } ?>
					<hr>
				</div>
				<?php } ?>
			</div>

			<form action="/?addComment/<?=$this->post['id']?>" method="post" class="thumbnail">

				<label for="comname">Ваше имя</label>
				<input type="text" class="form-control" id="comname" name="author" value=<?=$_COOKIE['cmntr']?>>

				<label for="addComment">Ваш комментарий</label>
				<textarea name="comment" id="addComment" cols="30" rows="10" class="form-control well">	
				</textarea>

				<div class="btn-toolbar">
					<button class="btn btn-success pull-right" type="submit">Добавить</button>
				</div>

			</form>
			
		</div>
	</div>
