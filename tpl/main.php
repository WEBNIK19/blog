<!DOCTYPE html>
<html lang="ru">
<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>/<?php echo $this->title; ?></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css" >
	<!-- Optional theme -->
	<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" >
</head>

<body>
	<nav class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				</div>
				<div class="collapse navbar-collapse" id="responsive-menu">
					<ul class="nav navbar-nav">
						<li><a href="/?">Главная</a></li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">Категории <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Бокс</a></li>
								<li><a href="#">Программирование</a></li>
								<li><a href="#">Музыка</a></li>
							</ul>
						</li>
						<?php if($this->user) { ?>
						<li><a href="/?add">Создать пост</a></li>
						<li><a href="/?logoff">Выйти</a></li>
						<?php } else{ ?>
						<li><a href="/?login">Войти</a></li>
						<li><a href="/?signup">Зарегистрироваться</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">

			<?php $this->out($this->tpl,true); ?>
		</div>
		
		<script src="bootstrap/js/jquery.js"></script>
		<script src="bootstrap/js/bootstrap.js" ></script>
		<script src="http://gregpike.net/demos/bootstrap-file-input/bootstrap.file-input.js"></script>
		<script> 
			$('input[type=file]').bootstrapFileInput();
			$('.file-inputs').bootstrapFileInput();
		</script>
	</body>
	</html>
