<?php 

class User_model extends MY_Model {

    function checkUser($data){
    $username = $data['username'];
	$email = $data['email'];
    $phone = $data['phone'];
    $sql = "SELECT * FROM `users` where  username='$username' or email='$email' or phone='$phone' ";
    $query = $this->db->query($sql);
    if ( $query->num_rows() > 0 )
    {   
     $message = "user_exists";
     return $message ;
    }

    }

   
	
	
    
}
    