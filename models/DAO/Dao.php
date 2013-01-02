<?php

interface Dao {
	
        //Select One
        public function get($id);
        
        //Select All With Criteria
        public function find($a);
        
        //Count All With Criteria
        public function count($a);
        
        //Insert
        public function insert($entity);

        //Update
        public function update($entity);
        
        //Delete
        public function delete($id);
	
}
?>
