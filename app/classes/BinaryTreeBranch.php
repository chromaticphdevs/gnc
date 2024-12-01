<?php   

    class BinaryTreeBranch
    {

        public static function printTree($geneology)
        {
            extract($data);

            return $notEmptyGenelogy = [];

            foreach($geneology as $key => $row) 
            {
                /** IF LEVEL HAS CONTENT */
                if(self::levelEmpty($row)){
                    break;
                }else{
                    $notEmptyGenelogy[] = $row;
                }
            }

            self::printGeneology($notEmptyGenelogy);
        }

        public static function levelEmpty($branch) 
        {
            $noInput = TRUE;

            foreach($branch as $row) {
                if(! is_null($row['id'])) {
                    $noInput = FALSE;
                    break;
                }
            }

            return $noInput;
        }

        public static function printGeneology($geneology)
        {
            $oldBranchPosition = null;

            foreach($geneology as $level => $branches) {

                foreach($branches as $branchPosition => $branch) 
                {
                    $oldBranchPosition = $oldBranchPosition ?? $branchPosition;

                    if($oldBranchPosition != $branchPosition) 
                    {
                        /**BUILD NEW UL */
                    }else{
                        /**APPEND LI */
                    }
                }
            }
        }
    }