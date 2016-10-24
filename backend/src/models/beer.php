<?php

require_once "brewery.php";
require_once __DIR__ . "/../util/breweryDB.php";
/**
 * @SWG\Definition(
 *  required={
 *      "name",
 *      "brewery",
 *      "cost",
 *      "style"
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
     * @var Style
     */
    public $style;
    
    /**
     * @SWG\Property()
     * @var date
     */
    public $featured;
    
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
        if (isset($data['style'])){
            $this->style = Style::getById($data['style']);
        } else if (isset($data['style']['id'])){
            $this->style = Style::getById($data['style']['id']);
        } else {
            throw new Exception('Style not provided', 500);
        }
        if (isset($data['featured']) && $data['featured'] != null){
            $this->featured = strtotime($date['date']);
        } else {
            $this->featured = null;
        }
        $this->extendedInfo = null;
    }
    
    function addExtendedInfo() {
        $brewDB = new BreweryDB();
        $this->extendedInfo = $brewDB->getInfoForBeer($this->name);
    }
    
    public static function create($name, $size = null, $ibu = null, $brewery = null, $abv = null, $description = null, $cost, $style, $featured = false) {
        
        $db = DB::getInstance();
        $arr = array(
            'name' => $name,
            'size' => $size,
            'ibu' => intval($ibu),
            'brewery_id' => $brewery != null ? $brewery->id: $brewery,
            'abv' => floatval($abv),
            'description' => $description,
            'cost' => floatval($cost),
            'style' => $style->id,
            'featured' => $featured ? time() : null
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
            $brewery = $null;
            if (isset($beer['brewery'])){
                $brewery = Brewery::findOrCreate($beer['brewery']);
                if ($brewery == null){
                    throw new Exception("An error occured finding/creating the brewery ".$beer['brewery']['name'], 500);
                }
            }
            
            $style = Style::findOrCreate($beer['style']);
            if ($brewery == null){
                throw new Exception("An error occured finding/creating the style ".$beer['style']['name'], 500);
            }
            
            $newbeer = Beer::create($beer['name'], 
                                    $beer['size'], 
                                    $beer['ibu'], 
                                    $brewery,
                                    $beer['abv'], 
                                    $beer['description'], 
                                    $beer['cost'],
                                    $style,
                                    $beer['featured']);
        } else {
            $newbeer = new Beer($results[0]);
            throw new Exception($newbeer->name . " already exists", 409);
        }
        
        if ($newbeer == null){
            throw new Exception("An error occured finding/creating the beer ".$beer['name'], 500);
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
    
    public static function search($name) {
        $db = DB::getInstance();
        $results = $db->select('Beer','*',[
            'name[~]' => $name,
            "ORDER" => "name",
            'LIMIT' => 10
        ]);
        
        if (sizeof($results) == 0 || !$results){
          return array();
        }
        $beers = array();
        
        for ($i=0; $i < sizeof($results); $i++){
            $b = new Beer($results[$i]);
            $obj = array(
                'type'=> 'beer',
                'beer'=> $b
            );
            array_push($beers, $obj);
        }
        
        return $beers;
        
    }
    
}