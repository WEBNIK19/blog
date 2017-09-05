<?php

class ctrl {

	public function __construct(){
		$this->db = db::getDB();
		if(!empty($_COOKIE['uid']) && !empty($_COOKIE['key'])){

			$this->user = $this->db->query("SELECT * FROM admin WHERE id = '?' AND cookie = '?'",$_COOKIE['uid'],$_COOKIE['key'])->assoc();

		} else $this->user = false;
	}
	public function authCookie(){
		$key = md5(microtime().rand(0,10000));
		setcookie('uid',$this->user['id'],time() + 86400*30, '/');
		setcookie('key',$key,time() + 86400*30, '/');
		setcookie('name',$this->user['login'],time() + 86400*30, '/');

		$this->db->query("UPDATE admin SET cookie = '?' WHERE id = '?'",$key,$this->user['id']);
	}

	public function out($tplname,$nested=false){
		if(!$nested){
			$this->tpl = $tplname;
			include "tpl/main.php";
		}else 
		include "tpl/".$tplname;
	}
	
}

class app {

	public function __construct($path){
		
		$this->route = explode('/',$path);

		$this->run();

	}

	private function run(){

		$url = array_shift($this->route);

		if(!preg_match('#^[a-zA-Z0-9.,-]*$#', $url)) echo 'Invalid path';
		
		$ctrlName = 'ctrl'.ucfirst($url);

		if(file_exists('app/'.$ctrlName)){

			$this->runController($ctrlName);

		}else {

			array_unshift($this->route, $url);

			$this->runController('ctrlIndex');

		}
		
	}

	private function runController($ctrlName){
		
		include "app/".$ctrlName.".php";

		$ctrl = new $ctrlName();

		if(empty($this->route[0])) {
			$method = 'index';
		}else if(!empty($this->route[0])) 

		$method = array_shift($this->route);

		if(method_exists($ctrl,$method)){
			if(empty($this->route[0])){
				$ctrl->$method();
			}
			else {
				call_user_func_array(array($ctrl,$method), $this->route);
			} 
		} else{
			array_unshift($this->route,$method);
			$method = 'index';
			call_user_func_array(array($ctrl,$method), $this->route);
		}
		
	}
}

class pager{
	public static $page;
	public static $start;
	public static $limit = 3;

	private static $instance = null;

	private function __construct(){ }
	private function __clone(){ }

	public static function getPager($page){
		if(is_null(self::$instance)) self::$instance = new self();
		self::$page = $page;
		self::$start = self::getStart();

		return self::$instance; 
	}

	function getAllPosts(db $db){
		$posts = $db->query("SELECT * FROM post ORDER BY ctime DESC LIMIT ?, ?",self::$start,self::$limit)->all();
		return $posts;
	}

	function countPosts(db $db){
		$row = $db->query("SELECT COUNT('id') FROM post")->row();
		return $row[0];
	}

	public static function getStart(){
		return self::$limit*(self::$page-1);
	}

	function pagination(db $db){
//Общее колличество постов(строк в БД)
		$post_count = $this->CountPosts($db);
//Общее колличество страниц  
		$count_pages = ceil($post_count/self::$limit);

		if(self::$page > $count_pages){
			self::$page = $count_pages;
		}

		$prev = self::$page - 1;
		$next = self::$page + 1;
		if($prev < 1 ) $prev = 1;
		if($next > $count_pages) $next = $count_pages;
		$pagination = "";

		if($count_pages > 1){

			if(self::$page == 1){
				$pagination .= "<ul class='pagination'><li class='disabled'><a href=''>Первая</a></li><li class='disabled'><a href=''>Предыдущая</a></li>";
			}else{
				$pagination .= '<ul class="pagination"><li><a href="/?1">Первая</a></li>';
				$pagination .='<li><a href="/?'.$prev.'">Предыдущая</a></li>';
			}
			for($i = 1; $i <= $count_pages; $i++){
				if($i == self::$page)
					$pagination .= '<li class="disabled"><a>'.$i.'</a></li>';
				else      
					$pagination .= '<li><a href="/?'.$i.'">'.$i.'</a></li>';
			}
			if(self::$page == $count_pages){
				$pagination .= "<li class='disabled'><a>Следующая</a></li><li class='disabled'><a>Последняя</a></li></ul>";
			}else{
				$pagination .= '<li><a href="/?'.$next.'">Следующая</a></li>';
				$pagination .= '<li><a href="/?'.$count_pages.'">Последняя</a></li></ul>';
			}
		}
		return $pagination;
	}
}
