<?php
    namespace Services;

    class QualifierService {
        public static function requirementsCheck($requirementType, $data) {
            $retVal = [
                'response' => false,
                'html' => '',
                'responseHTML' => '<span class="badge" style="background-color:red">FAILED</span>',
                'msgTxt' => ''
            ];
            if(empty($data)) {
                $retVal['msgTxt'] = '0';
                return $retVal;
            }
                
    
            switch($requirementType) {
                case 'two_valid_id' :
                    $validIds = 0;
                    $retVal['html'] .= '<ul>';
                    foreach($data as $key => $row) {
                        $retVal['html'] .= '<li class="list-hidden">' .$row->type. '<span class="badge badge-info">'. $row->status. '</span>'. '</li>';
                        if(!isEqual($row->status,'deny'))
                            $validIds++;
                    }

                    if(count($data) > 2) {
                        $retVal['html'] .= '<li>...</li>';
                    }
                    $retVal['html'] .= '</ul>';
    
                    if ($validIds >= 2) {
                        $retVal['response'] = true;
                        $retVal['responseHTML'] = '<span class="badge" style="background-color:blue">PASSED</span>';
                    }

                    $retVal['msgTxt'] = $validIds;
                break;
    
                case 'two_referrals' : 
                    $retVal['html'] .= '<ul>';
                        foreach($data as $key => $row) {
                            $retVal['html'] .= '<li class="list-hidden">' .$row->firstname. ' '. $row->lastname .'</li>';
                        }
                    if(count($data) > 2) {
                        $retVal['html'] .= '<li>...</li>';
                    }

                    $retVal['html'] .= '</ul>';
                    if(count($data) >= 2) {
                        $retVal['response'] = true;
                        $retVal['responseHTML'] = '<span class="badge" style="background-color:blue">PASSED</span>';
                    }
                    $retVal['msgTxt'] = count($data);
                break;
    
                case 'qr_login':
                    $retVal['html'] .= '<ul>';
                        foreach ($data as $key => $row) {
                            $retVal['html'] .= '<li class="list-hidden">' .$row->date_time.'</li>';
                        }
                    if(count($data) > 4) {
                        $retVal['html'] .= '<li>...</li>';
                    }
                    $retVal['html'] .= '</ul>';
    
                    if(count($data) >= 4) {
                        $retVal['response'] = true;
                        $retVal['responseHTML'] = '<span class="badge" style="background-color:blue">PASSED</span>';
                    }

                    $retVal['msgTxt'] = count($data);
                break;
            }
            
            return $retVal;
        }
    }