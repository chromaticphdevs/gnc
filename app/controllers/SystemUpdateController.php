<?php   

    class SystemUpdateController extends Controller
    {
        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function index()
        {   
            $this->db->query( "SELECT * FROM system_logs order by id desc");
            
            $updates =  $this->db->resultSet();

            $data = [
                'updates' => $updates
            ];
            $this->view('tools/updatelogs' , $data);
        }
        public function store()
        {
            /** CREATEA UPDATE NOTES */
            if($this->request() === 'POST') {

                $developer = $_POST['developer'];
                $title     = $_POST['title'];
                $description = $_POST['description'];

                $this->db->query(
                    "INSERT INTO system_logs(developer , title , description) 
                    VALUES('$developer'  , '$title' , '$description')"
                );

                $result = $this->db->execute();

                if($result) {
                    Flash::set("Updated Posted");
                    return;
                }else{
                    Flash::set( " SOMETHING WENT WRONG " , 'danger');
                }
            }
            $data =[ 
                'title' => 'System Log'
            ];
            
            $this->view('tools/updatelog' , $data);
        }
    }


    /** DATASE */

    // create table system_logs(
    //     id int(10) not null primary key auto_increment,
    //     developer varchar(100),
    //     title varchar(100) , 
    //     description text,
    //     created_at timestamp default now()
    // );