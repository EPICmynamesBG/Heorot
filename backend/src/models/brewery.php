<?php
/**
 * @SWG\Definition(
 *  required={
 *      "name"
 *   }
 *  )
 */
class Brewery {
    
    /**
     * @SWG\Property()
     * @var int
     */
    public $id;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $name;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $location;
    
    function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->location = $data['location'];
    }
    
    public static function create($name, $location = null) {
        $db = DB::getInstance();
        $arr = array(
            'name' => $name,
            'location' => $location
        );
        
        $brew_id = $db->insert("Brewery", $arr);
        
        return Brewery::getById($brew_id);
    }
    
    public static function findOrCreate($brew) {
        $db = DB::getInstance();
        $results = $db->select('Brewery','*',[
            'name[~]' => $brew['name']
        ]);
        
        $brewery = null;
        
        if (sizeof($results) != 1 || !$results){
            if (sizeof($results) > 1){
                throw new Exception("Multiple instances of the brewery ".$brew['name']." found", 500);
            }
            if (isset($brew['location'])){
                $brewery = Brewery::create($brew['name']);
            } else {
                $brewery = Brewery::create($brew['name'], $brew['location']);
            }
            
        } else {
            $brewery = new Brewery($results[0]);
        }
        
        if ($brewery == null){
            throw new Exception("An error occured finding/creating the brewery", 500);
        }
        
        return $brewery;
    }
    
    public static function getById($brewId) {
        $db = DB::getInstance();
        $results = $db->select('Brewery','*',[
            'id' => $brewId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			return null;
		}
        
        return new Brewery($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Brewery','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $brews = array();
        
        for ($i=0; $i < sizeof($results); $i++){
            $b = new Brewery($results[$i]);
            array_push($brews, $b);
		}
        
        return $brews;
    }
    
}