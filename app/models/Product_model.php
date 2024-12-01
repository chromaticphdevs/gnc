<?php 	

	class Product_model extends Base_model {

		private $table_name = 'products';


		public function __construct(){

			parent::__construct();	
		}

		public function get_product_by_id(int $product_id)
		{
			$this->db->query("SELECT * FROM products where id = :product_id");
			$this->db->bind(":product_id" , $product_id);
			return $this->db->single();
		}

		public function getProduct($productid)
		{
			$this->db->query("SELECT * FROM products where id = :productid");
			$this->db->bind(":productid" , $productid);
			return $this->db->single();
		}

		//this shoud use interface
		public function get_products_with_key($keyword = [])
		{	
			$this->db->query("SELECT p.id as p_id , p.name as p_name , p.price as p_price , 
				 s.store_name as s_name , s.facebook_page as s_facebook_page 
				 FROM stores as s
				 left join products as p 
				 on s.id = p.store_id where name like '%{$keyword['keyword']}%'");

			$this->db->bind(':keyword' , $keyword['keyword']);

			return $this->db->resultSet();
		}

		public function get_list($params = null)
		{
			$this->db->query(
				"SELECT  p.id as id , p.name as p_name , p.price as p_price ,p.image as p_image,
				'samp_store' as s_name , 'store_fb' as s_facebook_page 
				from $this->table_name as p 
				$params"
			);

			return $this->db->resultSet();
		}
	}