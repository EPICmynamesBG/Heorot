<?php

require_once "brewery.php";
require_once __DIR__ . "/../util/breweryDB.php";
/**
 * @SWG\Definition(
 *  required={
 *      "name",
 *      "brewery",
 *      "cost"
 *   }
 *  )
 */
class Beer {
    
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
    public $size;
    
    /**
     * @SWG\Property()
     * @var int
     */
    public $ibu;
    
    /**
     * @SWG\Property()
     * @var Brewery
     */
    public $brewery;
    
    /**
     * @SWG\Property()
     * @var double
     */
    public $abv;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $description;
    
    /**
     * @SWG\Property()
     * @var double
     */
    public $cost;
    
    /**
     * @SWG\Property()
     * @var object
     */
    public $extendedInfo;
    
    function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->size = $data['size'];
        $this->ibu = intval($data['ibu']);
        if (isset($data['brewery_id'])){
            $this->brewery = Brewery::getById($data['brewery_id']);
        } else if (isset($data['brewery']['id'])){
            $this->brewery = Brewery::getById($data['brewery']['id']);
        } else {
            throw new Exception('Brewery not provided', 500);
        }
        $this->abv = floatval($data['abv']);
        $this->description = $data['description'];
        $this->cost = floatval($data['cost']);
        $this->extendedInfo = null;
    }
    
    function addExtendedInfo() {
        $brewDB = new BreweryDB();
        $this->extendedInfo = $brewDB->getInfoForBeer($this->name);
    }
    
    public static function create($name, $size = null, $ibu = null, $brewery, $abv = null, $description = null, $cost) {
        $db = DB::getInstance();
        $arr = array(
            'name' => $name,
            'size' => $size,
            'ibu' => intval($ibu),
            'brewery_id' => $brewery->id,
            'abv' => floatval($abv),
            'description' => $description,
            'cost' => floatval($cost)
        );
        
        $beer_id = $db->insert("Beer", $arr);
        
        return Beer::getById($beer_id);
    }
    
    public static function findOrCreate($beer) {
        $db = DB::getInstance();
        $results = $db->select('Beer','*',[
            'name[~]' => $beer['name']
        ]);
        
        $newbeer = null;
        
        if (sizeof($results) != 1 || !$results){
            if (sizeof($results) > 1){
                throw new Exception("Multiple instances of the beer ".$beer['name']." found", 500);
            }
            $brewery = Brewery::getById($beer['brewery']['id']);
            if ($brewery == null){
                $brewery = Brewery::findOrCreate($beer['brewery']);
            }
            
            $newbeer = Beer::create($beer['name'], 
                                    $beer['size'], 
                                    $beer['ibu'], 
                                    $brewery,
                                    $beer['abv'], 
                                    $beer['description'], 
                                    $beer['cost']);
        } else {
            $newbeer = new Beer($results[0]);
        }
        
        if ($newbeer == null){
            throw new Exception("An error occured finding/creating the brewery", 500);
        }
        
        return $newbeer;
    }
    
    public static function getById($beerId) {
        $db = DB::getInstance();
        $results = $db->select('Beer','*',[
            'id' => $beerId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			return null;
		}
        
        return new Beer($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Beer','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $beers = array();
        
        for ($i=0; $i < sizeof($results); $i++){
            $b = new Beer($results[$i]);
            array_push($beers, $b);
		}
        
        return $beers;
    }
    
}
