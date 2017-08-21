<?php

class ctrlIndex extends ctrl{

	function index(){

		$this->posts = $this->db->query("SELECT * FROM post ORDER BY ctime DESC")->all();
		
		$this->out('posts.php');
		
	}
	
	function login(){

		if(!empty($_POST['email']) && !empty($_POST['password'])){
			$this->user = $this->db->query("SELECT * FROM admin WHERE email = ? AND password = ?", $_POST['email'], md5($_POST['password']))->assoc();

			if($this->user){
				
				$key = md5(microtime().rand(0,10000));
				setcookie('uid',$this->user['id'],time() + 86400*30, '/');
				setcookie('key',$key,time() + 86400*30, '/');
				setcookie('name',$this->user['login'],time() + 86400*30, '/');

				$this->db->query("UPDATE admin SET cookie = ? WHERE id = ?",$key,$this->user['id']);
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
	function add(){

		if(!$this->user) return header("Location: /");

		if(!empty($_POST['title']) && !empty($_POST['post'])){

			$this->db->query("INSERT INTO post(author,ctime,title,post) VALUES(?,?,?,?)",$_COOKIE['name'],time(),htmlspecialchars($_POST['title']),htmlspecialchars($_POST['post']));
			header("Location: /");

		}
		$this->out('add.php');
	}

	function del($id){
		if(!$this->user) return header("Location: /");
		$this->db->query("DELETE FROM post WHERE id=?", $id);
		header("Location: /");
	}
	function edit($id){
		if(!$this->user) return header("Location: /");
		if(!empty($_POST)){
			$this->db->query("UPDATE post SET title=?, post=? WHERE id=?", htmlspecialchars($_POST['title']),htmlspecialchars($_POST['post']),$id);
			header("Location: /");
		}
		$this->post = $this->db->query("SELECT * FROM post WHERE id=?",$id)->assoc();
		$this->out('add.php');
		
	}

	function comment($id){
		$this->post = $this->db->query("SELECT * FROM post WHERE id=?",$id)->assoc();
		$this->comments = $this->db->query("SELECT * FROM comments WHERE pid=? ORDER BY id DESC",$id)->all();
		$this->out('comment.php');
	}

	function addComment($id){
		setcookie('cmntr',$_POST['author'],0,'/');
		$this->db->query("INSERT INTO comments(pid,author,comment) VALUES (?,?,?)",$id,htmlspecialchars($_POST['author']),htmlspecialchars($_POST['comment'])); 
		header("Location: /?comment/".intval($id));
	}

	function delComment($id,$pid){
		if(!$this->user) return header("Location: /");
		$this->db->query("DELETE FROM	comments WHERE id=?",$id);
		header("Location: /?comment/".intval($pid));
	}

}