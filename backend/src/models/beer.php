<?php
/**
 * @SWG\Definition(
 *  required={
 *      "name",
 *      "brewery_id",
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
     * @var int
     */
    public $brewery_id;
    
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
    
    function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->size = $data['size'];
        $this->ibu = $data['ibu'];
        $this->brewery_id = $data['brewery_id'];
        $this->abv = $data['ibv'];
        $this->description = $dta['description'];
        $this->cost = $data['cost'];
    }
    
    public static function create($name, $size = null, $ibu = null, $brewery, $abv = null, $description = null, $cost) {
        $db = DB::getInstance();
        $arr = array(
            'name' => $name,
            'size' => $size,
            'ibu' => intval($ibu),
            'brewery_id' => $brewery->id,
            'abv' => floatval($abv),
            'description' => $description
            'cost' => $cost
        );
        
        $beer_id = $db->insert("Beer", $arr);
        
        return Beer::getById($beer_id);
    }
    
    public static function findOrCreate($beer) {
        
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
