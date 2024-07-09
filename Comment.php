<?php
    function add_comment($userId, $comment){
        $comment_obj = [
            "content"=> $comment,
            "createdAt"=> time(),
            "score"=> 0,
            "userId"=> $userId,
            "replies"=>[]
        ];

        add_on_json('./data/comments.json',$comment_obj);
    }

    function get_comments(){
        $comments = read_json('./data/comments.json', true);
        
        return array_map(function($comment) {
            $user = findUser('id',$comment['userId']);
            unset($comment['userId']);
            $comment['user'] = $user;
            return $comment;
        },$comments);
        
    }
?>