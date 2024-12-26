<?php 
    // wp-json/rank-your-sites/v1/getToken
    add_action('rest_api_init', function() {
        register_rest_route( 'rank-your-sites/v1', '/getToken', array(
            'methods' => 'POST',
            'callback' => 'getToken',
        ));
    });  
    // wp-json/rank-your-sites/v1/PlannerTokengetToken
    add_action('rest_api_init', function() {
        register_rest_route( 'rank-your-sites/v1', '/PlannerTokengetToken', array(
            'methods' => 'POST',
            'callback' => 'PlannerTokengetToken',
        ));
    });  

    function getToken($request) {
        // Check if the Authorization header is present
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            // Get the Authorization header value
            $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];

            // Check if the Authorization header starts with 'Bearer'
            if (strpos($authorizationHeader, 'Bearer') === 0) {
                // Extract the token from the Authorization header
                $token = substr($authorizationHeader, 7); // Remove 'Bearer ' prefix
                $post_data = $request->get_params();
                                
                global $wpdb;
                if (isset($post_data['access_token'])) {
                   $res = update_option('rys_ga4access_token',json_encode($post_data));
                   if($res){
                        echo json_encode(array('status'=>1,'msg'=>'The token has been successfully updated on your site'));
                        die;
                   }else{
                       echo json_encode(array('status'=>2,'msg'=>'We did not receive an access token, please try again'));
                       die;  
                   }
                }else{                    
                    echo json_encode(array('status'=>3,'msg'=>'We did not receive an access token, please try again.'));
                    die;  
                }
                die;
            } else {
                // Invalid Authorization header format
                echo json_encode(array('status'=>4,'msg'=>'Invalid Authorization header format'));
                die;                 
            }
        } else {
            // Authorization header is not present
            echo json_encode(array('status'=>5,'msg'=>'Authorization header is not present'));
            die;            
        }
        die;       
    }
    function PlannerTokengetToken($request) {
        // Check if the Authorization header is present
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            // Get the Authorization header value
            $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];

            // Check if the Authorization header starts with 'Bearer'
            if (strpos($authorizationHeader, 'Bearer') === 0) {
                // Extract the token from the Authorization header
                $token = substr($authorizationHeader, 7); // Remove 'Bearer ' prefix
                $post_data = $request->get_params();
                                
                global $wpdb;
                if (isset($post_data['access_token'])) {
                   $res = update_option('rys_plannerToken',json_encode($post_data));
                   if($res){
                        echo json_encode(array('status'=>1,'msg'=>'The token has been successfully updated on your site'));
                        die;
                   }else{
                       echo json_encode(array('status'=>2,'msg'=>'We did not receive an access token, please try again'));
                       die;  
                   }
                }else{                    
                    echo json_encode(array('status'=>3,'msg'=>'We did not receive an access token, please try again.'));
                    die;  
                }
                die;
            } else {
                // Invalid Authorization header format
                echo json_encode(array('status'=>4,'msg'=>'Invalid Authorization header format'));
                die;                 
            }
        } else {
            // Authorization header is not present
            echo json_encode(array('status'=>5,'msg'=>'Authorization header is not present'));
            die;            
        }
        die;       
    }
    

?>