<div class="container">
<?php 
echo $this->pager->pagination($this->db);

foreach ($this->posts as $key => $value){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><a <?='href="/?comment/'.$value['id'].'"';?>><?=$value['title']?></a></h3>
	</div>
	<div class="panel-body"><?=$value['post']?></div>
	<div class="panel-footer">
		<?=$value['author']?>
		<span class="btn-toolbar">
		<a <?='href="/?edit/'.$value['id'].'"'?> class="btn btn-success btn-xs pull-right"><i class="glyphicon glyphicon-pencil"></i> Редактировать</a>
			<a <?='href="/?del/'.$value['id'].'"'?> class="btn btn-danger btn-xs pull-right" onclick="return confirm('Точно удалить?');"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
		</span>
	</div>
</div>

<?php }?>
</div>