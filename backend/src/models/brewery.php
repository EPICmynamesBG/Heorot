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
    
    /**
     * @SWG\Property()
     * @var object
     */
    public $extendedInfo;
    
    function __construct($data) {
        $this->id = intval($data['id']);
        $this->name = $data['name'];
        $this->location = $data['location'];
        $this->extendedInfo = null;
    }
    
    function addExtendedInfo() {
        $brewDB = new BreweryDB();
        $this->extendedInfo = $brewDB->getInfoForBrewery($this->name);
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
            
            if (!isset($brew['location'])){
                $brewery = Brewery::create($brew['name']);
            } else {
                $brewery = Brewery::create($brew['name'], $brew['location']);
            }
            
        } else {
            $brewery = new Brewery($results[0]);
        }
        
        if ($brewery == null){
            throw new Exception("An error occured finding/creating the brewery ".$brew['name'], 500);
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
  
    public static function search($name) {
        $db = DB::getInstance();
        $results = $db->select('Brewery','*',[
            'name[~]' => $name,
            "ORDER" => "name",
            'LIMIT' => 10
        ]);
        
        if (sizeof($results) == 0 || !$results){
          return array();
        }
        $brews = array();
        
        for ($i=0; $i < sizeof($results); $i++){
            $b = new Brewery($results[$i]);
            $obj = array(
                'type'=> 'brewery',
                'brewery'=> $b
            );
            array_push($brews, $obj);
		    }
        
        return $brews;
        
    }
    
}