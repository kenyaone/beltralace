<?php

class SEO{
    public static function checkSlug($slug, $current_record, $section){
        $connection =  DatabaseController::connect();
        $query = "SELECT * FROM ".$section." WHERE slug = ? ";
        $query_params = array($slug);
        
        if (isset($current_record)) {
            $query .= "AND id != ? ";
            $query_params[] = $current_record;
        }

        $statement = $connection->prepare($query);
        $statement->execute($query_params);
         DatabaseController::disconnect();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);

        if(count($results) == 0){
            return true;
        }

        return false;
    }
}