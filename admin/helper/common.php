<?php 
    /**
     * The admin-specific functionality of the plugin.
     *
     * @link       https://http://localhost/wordpress
     * @since      1.0.0
     *
     * @package    Komodo_Blog
     * @subpackage Komodo_Blog/admin
     */

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Komodo_Blog
     * @subpackage Komodo_Blog/admin
     * @author     # <Ravi.kushwah@pixelnx.com>
    */

     /**	 
	 * @param text $text  Function to calculate word count.
	 */ 
    function countWords($text) {
        return str_word_count($text);
    }  
     /**	 
	 * @param text $text   Function to calculate character count.
	 */ 
    function countCharacters($text) {
        return strlen($text);
    }
    /**	 
	 * @param text $text   Function to calculate character count without spaces.
	 */   
    function countCharactersWithoutSpaces($text) {
        return strlen(str_replace(' ', '', $text));
    }
    /**	 
	 * @param text $text   Function to calculate sentence count.
	 */
    
    function countSentences($text) {
        return preg_match_all('/[^\s](\.|\!|\?)(?!\w)/', $text, $matches);
    }   
    /**	 
	 * @param text $text  Function to calculate paragraph count.	
	 */
    function countParagraphs($text) {
        return substr_count($text, "\n") + 1;
    }
   
    /**	 
	 * @param text $text   cFunction to calculate reading time in minutes.	
	 */
    function calculateReadingTime($text) {
        $words_per_minute = 200; // Average reading speed
        $word_count = countWords($text);
        $total_minutes = $word_count / $words_per_minute;
        $hours = floor($total_minutes / 60);
        $minutes = floor($total_minutes % 60);
        $seconds = floor(($total_minutes - floor($total_minutes)) * 60);
        return [
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds
        ];
    }
    /**	 
	 * @param text $text   content grammarlly check .	
	 */
    function checkGrammar($text) {
        $url = 'https://api.languagetool.org/v2/check';
    
        $data = array(
            'text' => $text,
            'language' => 'en-US'
        );
    
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
    
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            die('Error occurred while checking grammar.');
        }
    
        $resultData = json_decode($result, true);
    
        return $resultData;
    }   
   

    /**
	 * Check Traversable contains an element.
	 *
	 * @param \Traversable $array  The set of values to search.
	 * @param mixed        $search The value to look for.
	 * @param bool         $strict Whether to enable strict (`===`) comparison.
	 *
	 * @return bool `true` if `$search` was found in `$array`, `false` otherwise.
	 */
	function includes_traversable( $array, $search, $strict = true ) {
		foreach ( $array as $value ) {
			if ( ( $strict && $search === $value ) || $search == $value ) { // phpcs:ignore
				return true;
			}
		}

		return false;
	}
    /**
	 * Insert a single array item inside another array at a set position
	 *
	 * @param array $array    Array to modify. Is passed by reference, and no return is needed.
	 * @param array $new      New array to insert.
	 * @param int   $position Position in the main array to insert the new array.
	 */
	function insert( &$array, $new, $position ) {
		$before = array_slice( $array, 0, $position - 1 );
		$after  = array_diff_key( $array, $before );
		$array  = array_merge( $before, $new, $after );
	}
	/**
	 * Push an item onto the beginning of an array.
	 *
	 * @param array $array Array to add.
	 * @param mixed $value Value to add.
	 * @param mixed $key   Add with this key.
	 */
	function prepend( &$array, $value, $key = null ) {
		if ( is_null( $key ) ) {
			array_unshift( $array, $value );
			return;
		}

		$array = [ $key => $value ] + $array;
	}
    /**
	 * Update array add or delete value
	 *
	 * @param array $array Array to modify. Is passed by reference, and no return is needed.
	 * @param array $value Value to add or delete.
	 */
	function add_delete_value( &$array, $value ) {
		if ( ( $key = array_search( $value, $array ) ) !== false ) { // @codingStandardsIgnoreLine
			unset( $array[ $key ] );
			return;
		}

		$array[] = $value;
	}
    /**
	 * Create an array from string.
	 *
	 * @param string $string    The string to split.
	 * @param string $separator Specifies where to break the string.
	 *
	 * @return array Returns an array after applying the function to each one.
	 */
	function from_string( $string, $separator = ',' ) {
		return array_values( array_filter( array_map( 'trim', explode( $separator, $string ) ) ) );
	}
    /** 
	 * @param int $len custom Stringe Generate 
	*/
    
	function shortCodeGen($len=4){		
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXYZ'; 
		$randomString = ''; 
		for ($i = 0; $i < $len; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
		}  
		return $randomString;
	}
    /** 
	 * @param int $len custom Stringe Generate 
	*/
	function generateString($len=4){		
		$characters = '=abcdefghij=klmn=opq=rstuvws=xyzABCDEF=GHIJKLMN=OPQR=ST=UV=WXYZ=123='; 
		$randomString = ''; 
		for ($i = 0; $i < $len; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
		}  
		return $randomString;
	}
    /** 
	 * @param int $Number custom Stringe Generate 
	*/
	function intigerTOStringValue($Number){
    	$words = [
          'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
          'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        ];
    
        $tens = [
            '', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
        ];
    
        if ($Number < 20) {
            return  $words[$Number];
        } elseif ($Number < 100) {
            return  $tens[$Number / 10] . ($Number % 10 ? ' ' . $words[$Number % 10] : '');
        } elseif ($Number < 1000) {
            return  $words[$Number / 100] . ' hundred' . ($Number % 100 ? ' and ' . numberToWords($Number % 100) : '');
        } else {
            return '';
        }
	}
    /** 
	 * Content Spin Open Ai 
	*/
    function SpintextCheck(){

		$user_id = get_current_user_id();	
		$meta_key = 'kb_openAiKey';
		
		/* current user smtp all details get */
		$openAiKeyData = get_option($meta_key);
		$openAiKey = json_decode($openAiKeyData ,true);
		
		if(!empty($openAiKeyData)){
			// Replace 'YOUR_API_KEY' with your OpenAI API key
			$apiKey = $openAiKey[0]['Key'];
			
			// OpenAI API endpoint for text completion (GPT-3)
			$apiEndpoint = 'https://api.openai.com/v1/completions';
	
			// Text to be spun
			$textToSpin = $_POST['promt'];
	
			// Prepare the request data
			$data = array(
				'prompt' => 'spin the following content '.$textToSpin,
				'model'	 => 'gpt-3.5-turbo-instruct',
				'max_tokens' => 1000,  // You can adjust this parameter to control the length of the spun text
			);
						
			$ch = curl_init($apiEndpoint);
	
			// Set cURL options
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $apiKey,
			));
	
			
			$response = curl_exec($ch);			
			// Check for cURL errors
			if (curl_errno($ch)) {
				$msg ='cURL error: ' . curl_error($ch);
			} else {
				// Process the API response
				$result = json_decode($response, true);				
				if ($result && isset($result['choices'][0]['text'])) {
					// Output the spun text
					$data = $result['choices'][0]['text'];
					$msg = 'Successfully Spin Text';					
				} else {
					$msg = 'Error processing API response.';					
				}
			}
			echo json_encode(array('status'=>1,'msg'=>$msg,'data'=>$data));
			curl_close($ch);

		}else{
			$msg = 'Open AI is not key so you can`t spin content';
			echo json_encode(array('status'=>0,'msg'=>$msg,'data'=>$data));
		}
		wp_die();
	}
