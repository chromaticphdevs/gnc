<?php   namespace BKTK;

    use BKTK\Base;

    require_once __DIR__.'/Base.php';

    class Timesheet extends Base
    {
        protected $controller = 'Timesheet';
        /**
         * GET ALL TIME SHEETS
         */
        public function getAll($parameters = [])
        {
            $timeSheets = $this->fetch('', $parameters);

            return $timeSheets;
        }

        public function getPending()
        {
            return $this->getAll([
                'status' => 'pending'
            ]);
        }

        public function getApproved()
        {
            return $this->getAll([
                'status' => 'approved'
            ]);
        }

        public function get($id)
        {
            $timeSheet = $this->fetch("show" , [
                'id' => $id
            ]);

            return $timeSheet;
        }

        public function approve($id)
        {
            $approveSheet = $this->post('approve' , [
                'id' => $id
            ]);

            return $approveSheet;
        }

        public function approveBulk($timesheetIds)
        {
            $approveSheet = $this->post('approveBulk' , [
                'timesheetIds' => $timesheetIds
            ]);

            return $approveSheet;
        }

        public function delete($id)
        {
            $deletePost = $this->post('delete' , [
                'id' => $id
            ]);

            return $deletePost;
        }
    }
?>