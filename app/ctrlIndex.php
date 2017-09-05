<?php

class ctrlIndex extends ctrl{


	function index($page = 1){
		
		$this->pager = pager::getPager($page);
		$this->posts = $this->pager->GetAllPosts($this->db);
		$this->out('posts.php');	
	}
	
	function login(){

		if(!empty($_POST['email']) && !empty($_POST['password'])){
			$this->user = $this->db->query("SELECT * FROM admin WHERE email = '?' AND password = '?'", $_POST['email'], md5($_POST['password']))->assoc();

			if($this->user){
				
				$this->authCookie();
				header("Location: /");
			}else{
				$this->error="Неправильный эмейл или пароль";
			} 
		}
		$this->out('login.php');
	}

	function logoff(){
		setcookie('uid','',0, '/');
		setcookie('key','',0, '/');
		header("Location: /");
	}

	function signup(){
		
		if(!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password']) /*&& !empty($_FILES['avatar']['name'])*/&& $_POST['password'] == $_POST['repassword']){

      $avatar = file_get_contents($_FILES['avatar']['tmp_name']);

      

			$this->db->query("INSERT INTO admin(login,email,password,avatar) VALUES ('?','?','?','?')",$_POST['login'],$_POST['email'],md5($_POST['password']),$avatar);

			$this->user = $this->db->query("SELECT * FROM admin WHERE email = '?' AND password = '?'", $_POST['email'], md5($_POST['password']))->assoc();

			$this->authCookie();
				//header("Location: /");
		}elseif($_POST['password'] !== $_POST['repassword']){

			$this->error=array('style' => 'has-error',
			'message' => "Пароли не совпадают");
		;
		} 
		$this->out("signup.php");
	}

	function add(){

		if(!$this->user) return header("Location: /");

		if(!empty($_POST['title']) && !empty($_POST['post'])){

			$this->db->query("INSERT INTO post(author,ctime,title,post) VALUES('?','?','?','?')",$_COOKIE['name'],time(),htmlspecialchars($_POST['title']),htmlspecialchars($_POST['post']));
			header("Location: /");
		}

		$this->out('add.php');
	}

	function del($id){
		if(!$this->user) return header("Location: /");
		$this->db->query("DELETE FROM post WHERE id='?'", $id);
		header("Location: /");
	}
	function edit($id){
		if(!$this->user) return header("Location: /");
		if(!empty($_POST)){
			$this->db->query("UPDATE post SET title='?', post='?' WHERE id='?'", htmlspecialchars($_POST['title']),htmlspecialchars($_POST['post']),$id);
			header("Location: /");
		}
		$this->post = $this->db->query("SELECT * FROM post WHERE id='?'",$id)->assoc();
		$this->out('add.php');
	}

	function comment($id){
		$this->post = $this->db->query("SELECT * FROM post WHERE id='?'",$id)->assoc();
		$this->comments = $this->db->query("SELECT * FROM comments WHERE pid='?' ORDER BY id DESC",$id)->all();
		$this->out('comment.php');
	}

	function addComment($id){
		setcookie('cmntr',$_POST['author'],0,'/');
		$this->db->query("INSERT INTO comments(pid,author,comment) VALUES ('?','?','?')",$id,htmlspecialchars($_POST['author']),htmlspecialchars($_POST['comment'])); 
		header("Location: /?comment/".intval($id));
	}

	function delComment($id,$pid){
		if(!$this->user) return header("Location: /");
		$this->db->query("DELETE FROM	comments WHERE id='?'",$id);
		header("Location: /?comment/".intval($pid));
	}

  function image($login){
  	
		$this->image = $this->db->query("SELECT avatar FROM admin WHERE login='?'",$login)->row();
  	$this->out("image.php",true);
  }
}