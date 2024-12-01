<?php 
    namespace Classes\Binary;

    interface IComputation
    {
        public function isPassed();
        public function pairAmount();
        public function pairTreshold();
    }