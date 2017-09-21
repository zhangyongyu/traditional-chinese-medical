<?php

class User {

	protected $db;
	protected $user;

	public function __construct($db,$id)
	{
		$this->db=$db;
		$sth = $db->prepare('SELECT id,name
		    FROM users
		    WHERE id = ?');
		$sth->execute(array($id));
		$this->user = $sth->fetch();
	}

	public function getName()
	{
		return $this->user['name'];
	}

	public function getId()
	{
		return $this->user['id'];
	}

}