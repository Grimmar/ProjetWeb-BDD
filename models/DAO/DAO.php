<?php

interface DAO {
	
        //Select One
        public function get($id);
        
        //Select All With Criteria
        public function find($a);
        
        //Count
        public function count($entity);
        
        //Insert
        public function insert($entity);

        //Update
        public function update($entity);
        
        //Delete
        public function delete($id);
	
}
?>
