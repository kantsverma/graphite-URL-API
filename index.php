// include the main library 
// Here is the code for uses of graphite service 
// below i have show how to call the class and use of 
			require_once ('graphite-library.php');

			// Create the GraphiteUrlService object.
			$gofus = new GraphiteUrlService();
			
			// Set the required config parameters
			$gofus->host = "remotetopc.com";
			$gofus->port = "8080";  // default 9090
			
			/**
			 * Fetch the remote uses like CPU,Disk,Memory
			 *
			 * @param	string			$jid		53fb906de8073@example.com mandatory  
			 * @param	string			$service	Which type of servie want to fetch mandatory
			 * @param	string			$time		fetch the data from time string last -1 hours ,-1 minutes etc 
			 * @param	string			$format		Set the height of graph raw, csv, json, svg
			 * @return	array|false					Array with data or error, or False when something went fully wrong
			 */				
			$data1 = $gofus->get_remote_uses('53fb906de8073@remotetopc.com','cpu_load_sec','-20minute','json');
			
			echo '<pre>';
			print_r($data1);
			echo '</pre>';
			
			// fetch the remote uses as a graph
			/**
			 * Fetch the remote uses like CPU,Disk,Memory in graph output 
			 *
			 * @param	string			$jid		53fb906de8073@example.com mandatory  
			 * @param	string			$service	Which type of servie want to fetch mandatory
			 * @param	string			$time		fetch the data from time string last -1 hours ,-1 minutes etc 
			 * @param	string			$height		Set the height of graph
			 * @param	string			$width		Set the width of graph
			 * @return	array|false					Array with data or error, or False when something went fully wrong
			 */	
			$data = $gofus->get_remote_metrics('53fb906de8073@remotetopc.com','cpu_load_sec','-20minute','800','600');
			
			echo '<pre>';
			print_r($data);
			echo '</pre>';
