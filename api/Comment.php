<?php
    function add_comment($userId, $comment, $parentId){
        $comment_obj = [
            "content"=> $comment,
            "createdAt"=> time(),
            "score"=> 0,
            "userId"=> $userId,
            "parentId"=> $parentId
        ];

        add_on_json('./data/comments.json',$comment_obj);
    }

    function edit_comment($comment){
        edit_json('./data/comments.json', $comment['id'], $comment);
    }

    function delete_comment($commentId){
        // find comment and replies and delete all
        del_on_json('./data/comments.json',$commentId);
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