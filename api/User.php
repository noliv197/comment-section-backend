<?php
    function findUser($type,$param){
        $users = read_json('./data/user.json', true);

        foreach($users as $user){
           
            if($user[$type] == $param){
                unset($user['password']);
                return $user;
            }
        }
    }

    function login($username, $pass){
        $users = read_json('./data/user.json', true);

        foreach($users as $user){
            if($user['username'] == $username){
                if($user['password'] === $pass){
                    unset($user['password']);
                    return $user;
                }
                else {
                    throw new Exception("Username or password wrong", 401);
                }
            }
        }

        return registerUser($username, $pass, count($users) + 1);

    }

    function registerUser($username,$pass, $id){
        $user_obj = [
            "username"=>$username,
            "password"=> $pass,
            "image"=> [
                    "png"=> "./assets/images/avatars/image-amyrobson.png",
                    "webp"=> "./assets/images/avatars/image-amyrobson.webp"
                ]
        ];

        add_on_json('./data/user.json',$user_obj);
        
        unset($user_obj['password']);
        $user_obj['id'] = $id;
        return $user_obj;
    }
?>