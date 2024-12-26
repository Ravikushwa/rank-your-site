<?php

class Db_access {   
    public function select_data($field , $table , $where = '' , $limit = '' , $order = '' , $like = '' , $join_array = '' , $or_like = '',$where_in =''){
        $sql_query = 'SELECT ';
        $sql_query .= $field;
        $sql_query .= ' FROM ';
        $sql_query .= $table;
       
        if($join_array != ''){
            $sql_query .= ' INNER JOIN  '.$join_array[0].'  ON '.$join_array[1].'';	
        }
        if($like != ""){
            $ck = !empty($where) ? 'AND' : 'WHERE';
            $sql_query .= ' '.$ck.' '.$like[0].' LIKE  "%'.$like[1].'%"';				
        }
        if($or_like != ""){
            $ck = !empty($where) ? 'AND' : 'WHERE';
            $sql_query .= ' LIKE  '.$or_like[0].' %'.$or_like[1].'%  OR '.$or_like[0].' LIKE %'.$or_like[2].'%';				
        }
        if($where != ""){ 
            $sql_query .= ' WHERE  '.$where[0].' = '.$where[1].'';		
		}
	    if($where_in !='' ){
            $sql_query .= ' WHERE  '.$where_in[0].' IN '.explode(',',$where_in[1]).'';	           
        }       
		
		if($order != ""){
            $sql_query .= ' ORDER BY '.$order['0'].' '.$order['1'].' ';			
		}				
		if($limit != ""){
            $sql_query .= ' LIMIT  '.$limit[0].' OFFSET '.$limit[1].'';
			
		}		
        // print_r($sql_query);
        // die;
        $results = $wpdb->get_results($sql_query, ARRAY_A);
		echo "<pre>"; print_r( $results);
		die();
       					
						
    }

    public function wpTableOperations($table="",$key="",$operation="",$data=array() ){
      
        if($operation=="add"){
            if($table=="option"){
                $results = add_option($key,$data);
            }else if($table=="post"){
                $results = wp_insert_post($data); // array('post_title'    => 'My New Post','post_content'  => 'This is the content of my new post.','post_status'   => 'publish','post_author'   => 1,'post_category' => array(8,39));
            }else if($table=="postmeta"){
                $results = add_post_meta($data['id'],$key,$data);
            }else if($table=="usermeta"){
                $results = add_user_meta($data['id'],$key,$data['value']);
            }else if($table=="users"){
                $results = wp_create_user($data); // 'username', 'password', 'user@example.com'           
            }else if($table=="links"){
                $results = wp_insert_link($data); //array('link_id' => 'Updated Term Name','link_name'=>'link name '));
            }else if($table=="comments"){
                $results = wp_insert_comment($key,$data);  // array('comment_post_ID' => $post_id,'comment_author' => 'Author Name','comment_author_email' => 'author@example.com','comment_content' => 'This is a comment.','comment_approved' => 1,);
            }else if($table=="commentmeta"){
                $results = add_comment_meta($data['id'],$key,$data['value']);
            }else if($table=="termmeta"){
                $results = add_term_meta($data['id'],$key,$data);
            }else if($table=="terms"){
                $results = wp_insert_term($key,$data); //array('name' => 'Updated Term Name'));
            }
        }
        if($operation=="Get"){
            if($table=="option"){
                $results = get_option($key);
            }else if($table=="post"){
                $results = get_post($data['id']);
            }else if($table=="postmeta"){
                $results = get_post_meta($data['id'],$key,true);
            }else if($table=="usermeta"){
                $results = get_user_meta($data['id'],$key,true);
            }else if($table=="users"){
                $results = get_userdata($data['id']);
            }else if($table=="links"){
                $results = get_bookmark($data['id']); 
            }else if($table=="comments"){
                $results = get_comment($data['id']);
            }else if($table=="commentmeta"){
                $results = get_comment_meta($data['id'],$key,true);
            }else if($table=="termmeta"){
                $results = get_term_meta($data['id'],$key,true);
            }else if($table=="terms"){
                $results = get_term($data['id']);
            }
        }
        if($operation=="Update"){
            if($table=="option"){
                $results = update_option($key);
            }else if($table=="post"){
                $results = wp_update_post($data); //array('ID'=> $post_id,'post_title'   => 'My Updated Post Title','post_content' => 'This is the updated content of my post.');
            }else if($table=="postmeta"){
                $results = update_post_meta($data['id'],$key,$data);
            }else if($table=="usermeta"){
                $results = update_user_meta($data['id'],$key,$data['value']);
            }else if($table=="users"){
                $results = wp_update_user($data);
            }else if($table=="links"){
                $results = wp_update_link($data); //array('link_id' => 'Updated Term Name','link_name'=>'link name '));
            }else if($table=="comments"){
                $results = wp_update_comment($data);  //array('comment_ID' => '1','comment_content'=>'demo test  '));
            }else if($table=="commentmeta"){
                $results = update_comment_meta($data['id'],$key,$data['value']);
            }else if($table=="termmeta"){
                $results = update_term_meta($data['id'],$key,$data);
            }else if($table=="terms"){
                $results = wp_update_term($data['id'],$key,$data['value']); //array('name' => 'Updated Term Name'));
            }
        }
        if($operation=="Delete"){
            if($table=="option"){
                $results = delete_option($key);
            }else if($table=="post"){
                $results = wp_delete_post($data['id'],true);
            }else if($table=="postmeta"){
                $results = delete_post_meta($data['id'],$key);
            }else if($table=="usermeta"){
                $results = delete_user_meta($data['id'],$key);
            }else if($table=="users"){
                $results = wp_delete_user($data['id']);
            }else if($table=="links"){
                $results = wp_delete_link($data['id']);
            }else if($table=="comments"){
                $results = wp_delete_comment($data['id'],true);
            }else if($table=="commentmeta"){
                $results = delete_comment_meta($data['id'],$key);
            }else if($table=="termmeta"){
                $results = delete_term_meta($data['id'],$key);
            }else if($table=="terms"){
                $results = wp_delete_term($data['id'],$key); 
            }
        }
        return $results;
    }
}


