<?php
    function addComment($userId, $comment){
        $comment_obj = [
            "content"=> $comment,
            "createdAt"=> time(),
            "score"=> 0,
            "userId"=> $userId,
            "replies"=>[]
        ];

        addOnJson('./data/comments.json',$comment_obj);
    }
?>