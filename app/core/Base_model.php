<?php
 	abstract class Base_model{

 		use DBHelperTrait;

    public $errors = [];
    public $messages = [];
    public $_retVal = [];
 		public $db;
    public $_dbConditionWrap = 'CONDITION_WRAP';
 		///DBVENDOR , DBHOST , DBNAME , DBUSER , DBPASS
 		public function __construct(){

 			$this->db = new Database();
      $this->dbHelper = new DatabaseHelper($this->db);
 		}


 		public function __add_model($modelName , $modelInstance)
 		{
 			$this->$modelName = $modelInstance;
 		}

 		public function __get_model($modelName){

 			if(property_exists($this, $modelName)){

 				return $this->$modelName;
 			}else{
 				die("Property '$modelName' Does not exists");
 				return false;
 			}
 		}

    public function dball()
    {
      $data =[
        $this->table,
        '*'
      ];

      return $this->dbHelper->resultSet(...$data);
    }
    /*
    *DO NOT CHANGE****
    *THIS WILL AFFECT A LOT OF MODELS BASING ON THIS METHOD NAME
    */
    public function store($values)
    {
      $data = [
        $this->table ,
        $values
      ];

      return $this->dbHelper->insert(...$data);
    }


    public function db_get_results($where = null , $limit = null)
    {
      $data = [
        $this->table ,
        '*',
        $where,
        $limit
      ];


      return $this->dbHelper->resultSet( ...$data);
    }
    public function dbupdate($values , $id)
    {
      if(is_array($id)) {
        $where  = $this->convertWhere($id);
      } else {
        $where = " id = '{$id}'";
      }

      $data = [
        $this->table ,
        $values,
        $where
      ];

      return $this->dbHelper->update(...$data);
    }

    public function dbdelete($id) {

      if(is_array($id)) {
        $where  = $this->convertWhere($id);
      } else {
        $where = " id = '{$id}'";
      }
      
      $data = [
        $this->table ,
        $where
      ];

      return $this->dbHelper->delete(...$data);
    }

    public function dbget($id)
    {
      if(is_array($id)) {
        $where = $this->convertWhere($id);
      } else {
        $where = " id = '{$id}'";
      }
      $data = [
        $this->table ,
        '*',
        $where
      ];

      return $this->dbHelper->single(...$data);
    }

    public function dbget_assoc($field, $where = null , $limit = null)
    {
      $data = [
        $this->table,
        '*',
        $where ,
        "$field ASC"
      ];

      if(!is_null($limit)) {
        array_push($data, $limit);
      }
      return $this->dbHelper->resultSet(...$data);
    }

    public function dbget_single($where)
    {
      $data = [
        $this->table,
        '*',
        $where
      ];

      return $this->dbHelper->single(...$data);
    }

    public function dbget_desc($field, $where = null , $limit = null)
    {
      $data = [
        $this->table,
        '*',
        $where,
        "$field DESC"
      ];

      if(!is_null($limit)) {
        array_push($data, $limit);
      }
      return $this->dbHelper->resultSet(...$data);
    }

    public function convertWhere($params , $defaultCondition = '=') {
      return $this->dbParamsToCondition($params, $defaultCondition);
    }

    public function dbParamsToCondition($params , $defaultCondition = '=')
    {
      $WHERE = '';
			$counter = 0;

			$errors = [];


			if(!is_array($params))
				return $params;
			/*
			*convert-where default concatinator is and
			*add concat on param values to use it
			*/
			$condition_operation_concatinator = 'AND';

			foreach($params as $key => $param_value) 
			{	
				if( $counter > 0)
					$WHERE .= " {$condition_operation_concatinator} "; //add space
				
				if($key == 'GROUP_CONDITION' && !empty($param_value)) {
					$WHERE .= '('.$this->convertWhere($param_value) . ')';
					$counter++;
					continue;
				}
				/*should have a condition*/
				if(is_array($param_value) && isset($param_value['condition']) ) 
				{
					$condition_operation_concatinator = $param_value['concatinator'] ?? $condition_operation_concatinator;

					//check for what condition operation
					$condition = $param_value['condition'];
					$condition_values = $param_value['value'] ?? '';
					$isField = isset($param_value['is_field']) ? true : false;

					if(is_numeric($key) && isEqual($condition, $this->_dbConditionWrap)) {
						$WHERE .= "({$param_value['value']})";

						if(isset($param_value['concatinator'])) {
							$WHERE .= " {$param_value['concatinator']} ";
						}
						continue;
					}

					if(isEqual($condition , 'not null'))
					{
						$WHERE .= "{$key} IS NOT NULL ";
					}

					if( isEqual($condition , ['between' , 'not between']))
					{
						if( !is_array($condition_values) )
							return _error(["Invalid query" , $params]);
						if( count($condition_values) < 2 )
							return _error("Incorrect between condition");

						$condition = strtoupper($condition);

						list($valueA, $valueB) = $condition_values;
						if($isField) {
							$WHERE .= " {$key} {$condition} {$valueA} AND {$valueB}";
						}else{
							$WHERE .= " {$key} {$condition} '{$valueA}' AND '{$valueB}'";
						}
					}

					if( isEqual($condition , ['equal' , 'not equal' , 'in' , 'not in']) )
					{
						$conditionKeySign = '=';

						if( isEqual($condition , 'not equal') )
							$conditionKeySign = '!=';

						if( isEqual( $condition , 'in'))
							$conditionKeySign = ' IN ';

						if( isEqual( $condition , 'not in'))
							$conditionKeySign = ' NOT IN ';

						if( is_array($condition_values) ){
							if($isField) {
								$WHERE .= "{$key} $conditionKeySign (".implode(",",$condition_values).") ";
							}else{
								$WHERE .= "{$key} $conditionKeySign ('".implode("','",$condition_values)."') ";
							}
						}else{
							$WHERE .= "{$key} {$conditionKeySign} '{$condition_values}' ";
						}
					}

					/*
					*if using like
					*add '%' on value 
					*/
					if(isEqual($condition , ['>' , '>=' , '<' , '<=' , '=', 'like']) )
					{
						if($isField){
							$WHERE .= "{$key} {$condition} {$condition_values}";
						}else{
							$WHERE .= "{$key} {$condition} '{$condition_values}'";
						}
					}
					$counter++;

					continue;
				}

				if( isEqual($defaultCondition , 'like')) 
					$WHERE .= " $key {$defaultCondition} '%{$param_value}%'";

				if( isEqual($defaultCondition , '=')) 
				{
					$isNotCondition = substr($param_value , 0 ,1); //get exlamation
					$isNotCondition = stripos($isNotCondition , '!');

					if( $isNotCondition === FALSE )
					{
						$WHERE .= " $key = '{$param_value}'";
					}else{
						
						$cleanRow = substr($param_value , 1);
						$WHERE .= " $key != '{$cleanRow}'";
					}
				}

				$counter++;
			}
			return $WHERE;
    }

    public function count($params = [], $alias = '') {
			$where = null;
			if(!empty($params['where'])){
				$where = " WHERE ". $this->convertWhere($params['where']);
			}

			if(!empty($alias)) {
				$alias = ' as '.$alias;
			}

      $this->db->query(
        "SELECT count(*) as totalCount
					FROM {$this->table} $alias
					{$where}"
      );
      
			return $this->db->single()->totalCount ?? 0;
		}

    public function addError($error)
    {
      $this->errors [] = $error;
    }

    public function getErrors()
    {
      return $this->errors;
    }
    public function getErrorString()
    {
      return implode(',' , $this->getErrors());
    }

    public function addMessage($message)
    {
      $this->messages [] = $message;
    }

    public function getMessages()
    {
      return $this->messages;
    }

    public function getMessageString()
    {
      return implode(',' , $this->getMessages());
    }

    public function getFillables($passedData) {

      $retVal = [];

      foreach ($passedData as $key => $row) {
        if (in_array($key, $this->_fillables)) {
          $retVal[$key] = $row;
        }
      }

      return $retVal;
    }

    public function _addRetval($name,$val) {
			$this->_retVal[$name] = $val;
			return $this;
		}

		public function _getRetval($name = null) {
			return is_null($name) ? $this->_retVal : $this->_retVal[$name] ?? false;
		}
 	}
