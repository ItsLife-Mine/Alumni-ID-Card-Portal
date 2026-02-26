<?php

require_once 'dbconfig.php';

class ADMINFEEDATE
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	public function adminfee($program,$semester,$firstDate,$secondDate,$thirdDate,$forthDate,$firstFineamount,$secondFineAmount)
	{
		try
		{							
			$stmt = $this->conn->prepare("INSERT INTO feesubmitdate(program,semester,firstDate,secondDate,thirdDate,forthDate,firstFineamount,secondFineAmount) 
			       VALUES(:program1,:semester1,:firstDate1,:secondDate1,:thirdDate1,:forthDate1,:firstFineamount1,:secondFineAmount1)");
			$stmt->bindparam(":program1",$program);
			$stmt->bindparam(":semester1",$semester);
			$stmt->bindparam(":firstDate1",$firstDate);
			$stmt->bindparam(":secondDate1",$secondDate);
			$stmt->bindparam(":thirdDate1",$thirdDate);
			$stmt->bindparam(":forthDate1",$forthDate);
			$stmt->bindparam(":firstFineamount1",$firstFineamount);
			$stmt->bindparam(":secondFineAmount1",$secondFineAmount);
			$stmt->execute();	
			return $stmt;
			
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function adminbatch($program,$batch)
	{
		try
		{							
			$stmt = $this->conn->prepare("INSERT INTO batchupdate(programID,batch) 
			       VALUES(:program1,:batch1)");
			$stmt->bindparam(":program1",$program);
			$stmt->bindparam(":batch1",$batch);
			$stmt->execute();	
			return $stmt;
			
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function adminfeeAmount($program,$batch,$feeAmount,$cautionFee,$alumniFee)
	{
		try
		{							
			$stmt = $this->conn->prepare("INSERT INTO feeamountupdate(programID,batchID,feeAmount,cautionFee,alumniFee) 
			       VALUES(:program1,:batch1,:feeAmount1,:cautionFee1,:alumniFee1)");
			$stmt->bindparam(":program1",$program);
			$stmt->bindparam(":batch1",$batch);
			$stmt->bindparam(":feeAmount1",$feeAmount);
			$stmt->bindparam(":cautionFee1",$cautionFee);
			$stmt->bindparam(":alumniFee1",$alumniFee);
			$stmt->execute();	
			return $stmt;
			
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
}