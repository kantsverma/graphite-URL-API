 <?php
/*License
Copyright (c) 2014 Devender Kumar 

Permission is hereby granted, for free uses to any person
obtaining a copy of this software and associated documentation
files, to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software

Help : http://graphite.readthedocs.org/en/latest/render_api.html 
follow the url API here 

*/


/**
 * A simple PHP class for use of graphite URL API.
 *
 */
class GraphiteUrlService
{
    /**
     * Stores all the default values.
     * @var		array	$settings
     */
    private $settings = array(
        'host'			=> 'localhost',
        'port'			=> '8080',
        'apiurl'		=> '/render',		
        'useSSL'		=> false
    );
    /**
     * Simple construct function 
     */
    public function __construct() {}

    /**
     * Get a configuration parameter
     *
     * @param	string					$name	Name
     * @return	string|bool|int|null			Get parameter
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }

        return null;
    }

    /**
     * Set a configuration parameter 
     *
     * @param	string				$name	Name
     * @param	string|bool|int		$value	Value
     * @return	void
     */
    public function __set($name, $value)
    {
        $this->settings[$name] = $value;
    }	
	


    /**
     * Forward the POST request and analyze the result
     *
     * @param	string[]		$parameters		Parameters
     * @return	array|false						Array with data or error, or False when something went fully wrong
     */
    private function fetchData($jid, $service, $parameters = array())
    {
        $base = ($this->useSSL) ? "https" : "http";
        $url = $base . "://" . $this->host;

        $result = $this->doUrlFopen($url, $jid, $service, $parameters);
		
        if($result === false) {
            return false;
        } else {
            return $result;
        }

    }
	
    /**
     * Sends the actual URL and data request to graphite using fopen
     *
     * @param	string		$url			URL
     * @param	string[]	$parameters		Parameters
     * @return	string|false				Callback data from FOpen request
     */
    private function doUrlFopen($url, $jid, $service, $parameters)
    {
	
		$finalUrl = $url . ":" . $this->port . $this->apiurl . "?target=" .$jid.".desktop.".$service.'&'. http_build_query($parameters,'.');
		
		$fopen = fopen($finalUrl, 'r');

		$result = fread($fopen, 1024);
		fclose($fopen);
		
		return $result;
    }

    /**
     * Fetch the remote uses like CPU,Disk,Memory
     *
     * @param	string			$jid		JID from openfire
     * @param	string			$service	Which type of servie want to fetch 
     * @param	string			$service	Which type of servie want to fetch 
     * @return	array|false					Array with data or error, or False when something went fully wrong
     */
    public function get_remote_uses($jid, $service,$from = false,$format = false)
    {
		//render?target=53fb906de8073@remotetopc.com.desktop.cpu_load_sec&from=-2hour&format=json
		
		$parameters = array(
            'from'		=> $from,
            'format'	=> $format
        );
		
		
        return $this->fetchData($jid, $service, $parameters);
    }
	
	/**
     * Fetch the remote uses like CPU,Disk,Memory in graph output 
     *
     * @param	string			$jid		JID from openfire
     * @param	string			$service	Which type of servie want to fetch 
     * @param	string			$service	Which type of servie want to fetch 
     * @return	array|false					Array with data or error, or False when something went fully wrong
     */	
	function get_remote_metrics($jid, $service,$from = false,$width = false,$height = false){

		$parameters = array(
            'from'		=> $from,
            'format'	=> 'png',
            'format'	=> $width,
            'format'	=> $height
        );
		
		
        return $this->fetchData($jid, $service, $parameters);
		
	}
    
}
?>
