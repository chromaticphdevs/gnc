<?php

  class FNProductReleasePaymentModel extends Base_model
  {
    public $table = 'fn_product_release_payment';

    public function getPayment($loanId)
    {
    	$returnData = [
    		'deliveryAmount' => 0,
    		'productAmount' => 0,
    		'total'    => 0
    	];

    	$this->db->query(
    		"SELECT sum(amount) as total , category FROM $this->table as payment 
    			WHERE loanid = '{$loanId}'
    			GROUP BY category "
    	);

    	$result = $this->db->resultSet();

    	$total = 0;

    	if($result) 
    	{
    		foreach($result as $key => $row) 
    		{
    			if(isEqual($row->category , 'delivery-fee')) 
    				$returnData['deliveryAmount'] = $row->total;

    			if(isEqual($row->category , 'product-loan'))
    				$returnData['productAmount'] = $row->total;

    			$returnData['total'] += $row->total;
    		}
    	}

    	return $returnData;
    }


    public function getPayments($loadId)
    {
    	$data = [
    		$this->table,
    		'*',
    		" loanId = '{$loadId}' "
    	];

    	return $this->dbHelper->resultSet( ...$data );
    }

    public function getTotal($userId)
    {
        $this->db->query(
            "SELECT SUM(amount) as total
                FROM $this->table
                WHERE userid = '$userId'
                GROUP BY userid "
        );

        return $this->db->single()->total ?? 0;
    }
  }
