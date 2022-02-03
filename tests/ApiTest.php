sk<?php 

use PHPUnit\Framework\TestCase;
use vzhabonos\vindecoder\Api;

class ApiTest extends TestCase
{
    public function testShouldReturnErrorNotRegonizedOnDecodeInfo()
    {	
        if ( !empty(getenv('VINCARIO_API_KEY')) && !empty(getenv('VINCARIO_API_SECRET')) ) {		
            $apiKey = getenv('VINCARIO_API_KEY');
            $apiSecret = getenv('VINCARIO_API_SECRET');
            $vinNumber = getenv('VINCARIO_VIN_NUMBER');	
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
                
            $dotenv->required('VINCARIO_API_KEY', 'VINCARIO_API_SECRET', 'VINCARIO_VIN_NUMBER');
            
            $apiKey = $_ENV['VINCARIO_API_KEY'];
            $apiSecret = $_ENV['VINCARIO_API_SECRET'];
            $vinNumber = $_ENV['VINCARIO_VIN_NUMBER'];
        }
        
        $api = new Api($apiKey, $apiSecret);
        
        $data = $api->decodeInfo($vinNumber);
        
        $this->assertEquals(
            '1',
            $data['error']
        );

        $this->assertEquals(
            'Not recognized',
            $data['message']
        );
    }
	
	public function testShouldReturnVehicleMakeLabelOnDecodeInfo()
    {	
        if ( !empty(getenv('VINCARIO_API_KEY')) && !empty(getenv('VINCARIO_API_SECRET')) ) {		
            $apiKey = getenv('VINCARIO_API_KEY');
            $apiSecret = getenv('VINCARIO_API_SECRET');
            $vinNumber = getenv('VINCARIO_VIN_NUMBER2');	
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
                
            $dotenv->required('VINCARIO_API_KEY', 'VINCARIO_API_SECRET', 'VINCARIO_VIN_NUMBER2');
            
            $apiKey = $_ENV['VINCARIO_API_KEY'];
            $apiSecret = $_ENV['VINCARIO_API_SECRET'];
            $vinNumber = $_ENV['VINCARIO_VIN_NUMBER2'];
        }
        
        $api = new Api($apiKey, $apiSecret);
        
        $data = $api->decodeInfo($vinNumber);
		
		$array = array( $data['decode'] );

        $this->assertContains(
			'Make', 
			$array[0], 
			"Array doesn't contains 'Make' as Value"
		);

    }
    
    public function testShouldReturnErrorNotRegonizedOnDecode()
    {		
        if ( !empty(getenv('VINCARIO_API_KEY')) && !empty(getenv('VINCARIO_API_SECRET')) ) {		
            $apiKey = getenv('VINCARIO_API_KEY');
            $apiSecret = getenv('VINCARIO_API_SECRET');
            $vinNumber = getenv('VINCARIO_VIN_NUMBER');	
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
                
            $dotenv->required('VINCARIO_API_KEY', 'VINCARIO_API_SECRET', 'VINCARIO_VIN_NUMBER');
            
            $apiKey = $_ENV['VINCARIO_API_KEY'];
            $apiSecret = $_ENV['VINCARIO_API_SECRET'];
            $vinNumber = $_ENV['VINCARIO_VIN_NUMBER'];
        }
        
        $api = new Api($apiKey, $apiSecret);
        
        $data = $api->decode($vinNumber);

        $this->assertEquals(
            '1',
            $data['error']
        );

        $this->assertEquals(
            'Not recognized',
            $data['message']
        );
    }
	
	public function testShouldReturnVehicleMakeOnDecode()
    {		
        if ( !empty(getenv('VINCARIO_API_KEY')) && !empty(getenv('VINCARIO_API_SECRET')) ) {		
            $apiKey = getenv('VINCARIO_API_KEY');
            $apiSecret = getenv('VINCARIO_API_SECRET');
            $vinNumber = getenv('VINCARIO_VIN_NUMBER2');	
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
                
            $dotenv->required('VINCARIO_API_KEY', 'VINCARIO_API_SECRET', 'VINCARIO_VIN_NUMBER2');
            
            $apiKey = $_ENV['VINCARIO_API_KEY'];
            $apiSecret = $_ENV['VINCARIO_API_SECRET'];
            $vinNumber = $_ENV['VINCARIO_VIN_NUMBER2'];
        }
        
        $api = new Api($apiKey, $apiSecret);
        
        $data = $api->decode($vinNumber);
				
		$this->assertEquals(
            'Seat',
            $data['decode'][1]['value']
        );

    }
    
    public function testShouldReturnInformationStolenCheck()
    {		
        if ( !empty(getenv('VINCARIO_API_KEY')) && !empty(getenv('VINCARIO_API_SECRET')) ) {
            $apiKey = getenv('VINCARIO_API_KEY');
            $apiSecret = getenv('VINCARIO_API_SECRET');
            $vinNumber = getenv('VINCARIO_VIN_NUMBER');
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
                
            $dotenv->required('VINCARIO_API_KEY', 'VINCARIO_API_SECRET', 'VINCARIO_VIN_NUMBER');
            
            $apiKey = $_ENV['VINCARIO_API_KEY'];
            $apiSecret = $_ENV['VINCARIO_API_SECRET'];
            $vinNumber = $_ENV['VINCARIO_VIN_NUMBER'];
        }
        
        $api = new Api($apiKey, $apiSecret);
        
        $data = $api->stolenCheck($vinNumber);

        $this->assertEquals(
            isset($_ENV['VINCARIO_VIN_NUMBER']) ? $_ENV['VINCARIO_VIN_NUMBER'] : getenv('VINCARIO_VIN_NUMBER'),
            $data['vin']
        );

        $this->assertEquals(
            'vincario',
            $data['stolen'][6]['code']
        );
    }
    
    public function testShouldReturnCurrentBelance()
    {		
        if ( !empty(getenv('VINCARIO_API_KEY')) && !empty(getenv('VINCARIO_API_SECRET')) ) {		
            $apiKey = getenv('VINCARIO_API_KEY');
            $apiSecret = getenv('VINCARIO_API_SECRET');		
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
                
            $dotenv->required('VINCARIO_API_KEY', 'VINCARIO_API_SECRET');
            
            $apiKey = $_ENV['VINCARIO_API_KEY'];
            $apiSecret = $_ENV['VINCARIO_API_SECRET'];
        }
        
        $api = new Api($apiKey, $apiSecret);
        
        $data = $api->balance();
        
        $this->assertEquals(
            '19',
            $data['API Decode']
        );

        $this->assertEquals(
            '4',
            $data['API Stolen Check']
        );
    
        $this->assertEquals(
            '5',
            $data['API Vehicle Market Value']
        );
    }
}

?>