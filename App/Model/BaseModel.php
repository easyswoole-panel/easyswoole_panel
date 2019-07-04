<?php

namespace App\Model;

/**
 * BaseModel
 * Class BaseModel
 * Create With Automatic Generator
 */
class BaseModel
{
	protected $db;


	public function __construct(\EasySwoole\Mysqli\Mysqli $dbObject)
	{
		$this->db = $dbObject;
	}


	public function getDb(): \EasySwoole\Mysqli\Mysqli
	{
		return $this->db;
	}
}

