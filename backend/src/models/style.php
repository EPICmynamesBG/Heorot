<?php
/**
 * @SWG\Definition(
 *  required={
 *      "name"
 *   }
 *  )
 */
class Style {
    
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
        
    function __construct($data) {
        $this->id = intval($data['id']);
        $this->name = $data['name'];
    }
        
    public static function create($name) {
        $db = DB::getInstance();
        $arr = array(
            'name' => $name
        );
        
        $id = $db->insert("Style", $arr);
        
        return Style::getById($id);
    }
    
    public static function findOrCreate($style) {
        $db = DB::getInstance();
      
        if (isset($style['id'])){
            return Style::getById($style['id']);
        }
        
        $results = $db->select('Style','*',[
            'name[~]' => $style['name']
        ]);
        
        $newStyle = null;
        
        if (sizeof($results) != 1 || !$results){
            if (sizeof($results) > 1){
                throw new Exception("Multiple instances of the style ".$style['name']." found", 500);
            }
            
            $newStyle = Style::create($style['name']);
            
        } else {
            $newStyle = new Style($results[0]);
        }
        
        if ($newStyle == null){
            throw new Exception("An error occured finding/creating the style ".$style['name'], 500);
        }
        
        return $newStyle;
    }
    
    public static function getById($id) {
        $db = DB::getInstance();
        $results = $db->select('Style','*',[
            'id' => $id
        ]);
        
        if (sizeof($results) == 0 || !$results){
			return null;
		}
        
        return new Style($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Style','*',["ORDER" => "name"]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $arr = array();
        
        for ($i=0; $i < sizeof($results); $i++){
            $s = new Style($results[$i]);
            array_push($arr, $s);
		}
        
        return $arr;
    }
  
    public static function search($name) {
        $db = DB::getInstance();
        $results = $db->select('Style','*',[
            'name[~]' => $name,
            "ORDER" => "name",
            'LIMIT' => 10
        ]);
        
        if (sizeof($results) == 0 || !$results){
          return array();
        }
        $arr = array();
        
        for ($i=0; $i < sizeof($results); $i++){
            $s = new Style($results[$i]);
            $obj = array(
                'type'=> 'style',
                'style'=> $s
            );
            array_push($arr, $obj);
        }
        
        return $arr;
        
    }
    
}