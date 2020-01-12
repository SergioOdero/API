<?php

class FootballData {
    
    public $config;
    public $baseUri;
    public $reqPrefs = array();
        
    public function __construct() {
        $this->config = parse_ini_file('config.ini', true);

	if($this->config['authToken'] == 'YOUR_AUTH_TOKEN' || !isset($this->config['authToken'])) {
		exit('Get your API-Key first and edit config.ini');
	}
        
        $this->baseUri = $this->config['baseUri']; 
        
        $this->reqPrefs['http']['method'] = 'GET';
        $this->reqPrefs['http']['header'] = 'X-Auth-Token: ' . $this->config['authToken'];
    }
    
         
    public function buscarcompeticionporid($id) {
        $resource = 'competitions/' . $id;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
   
    public function partidosproximosrango($start, $end) {
        $resource = 'competitions/PD/matches/?dateFrom=' . $start . '&dateTo=' . $end;

        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
    public function buscarpartidosdejornada($c, $m) {
     
 $resource = 'competitions/' . $c . '/matches/?matchday=' . $m;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }

    public function clasificacion($id) {
	$resource = 'competitions/' . $id . '/standings';
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));

        return json_decode($response);
    }

    
    public function buscarpartidoscasa($teamId) {
        $resource = 'teams/' . $teamId . '/matches/?venue=HOME';
        

        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response)->matches;
    }
    
   
    public function buscarpartidoporid($id) {
        $resource = 'matches/' . $id;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    

    public function buscarequipoporid($id) {
        $resource = 'teams/' . $id;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
    
    public function buscarequipo($keyword) {
        $resource = 'teams/?name=' . $keyword;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }    


}
