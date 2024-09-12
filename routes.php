<?php
    include 'File.php';
    include 'Comment.php';
    include 'User.php';
    
    // add Cors-configuration
    // header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

    try{
        //check if the request has a path, if not throw error
        if(!isset($_SERVER['PATH_INFO'])){
            throw new Exception("No path found", 404);
        } 

        switch($_SERVER["REQUEST_METHOD"]){
            //for browser request check
            case "OPTIONS":
                http_response_code(204);
            break;
            case "GET":
                switch ($_SERVER['PATH_INFO']) {
                    case '/comments':
                        $comments = get_comments();
                        if($comments && count($comments) > 0){
                            print_r(json_encode($comments));
                        } else {
                            print_r([]);
                        }
                    break;
                    default:
                        throw new Exception("No path found", 404);
                } 
            break;
            case "POST":
                switch ($_SERVER['PATH_INFO']) {
                    case '/login':
                        if(key_exists('username', $_POST) && key_exists('pass', $_POST)){
                            $user = login($_POST['username'],$_POST['pass']);
                            print_r(json_encode($user));
                        }else{
                            throw new Exception("Information missing from the request", 400);
                        }
                    break;
                    case '/addComment':
                        // check if user is logged in, if yes it adds a new entry to the cart_tb
                        if(key_exists('userId', $_POST) && key_exists('comment', $_POST) && key_exists('parentId', $_POST) ){
                            add_comment($_POST['userId'],$_POST['comment'], $_POST['parentId']);
                            print_r('Comment added successfully');
                        } 
                        else {
                            throw new Exception("Information missing from the request", 400);
                        }
                    break;
                    default:
                        throw new Exception("No path found", 404);
                } 
            break;
            case "PUT":
                if($_SERVER['PATH_INFO'] === '/editComment'){
                   
                }
                else {
                    throw new Exception("No path found", 404);
                }
            break;
            case "DELETE":
                if($_SERVER['PATH_INFO'] === '/deleteComment'){
                    if(
                        key_exists('commentId', $_REQUEST) && 
                        key_exists('commentUserId', $_REQUEST) &&
                        key_exists('loginId', $_REQUEST) 
                    ){
                        if($_REQUEST['loginId'] === $_REQUEST['commentUserId']){
                            delete_comment($_REQUEST['commentId']);
                            print_r('Comment deleted succesfully');
                        } else {
                            throw new Exception("Only the user who wrote the comment can delete it", 401);
                        }
                    }
                    else{
                        throw new Exception("Information missing from the request", 400);
                    }
                }
                else {
                    throw new Exception("No path found", 404);
                }
            break;
            default:
                throw new Exception("Method not allowed", 405);
        }

    }
    catch(Exception $err){
        http_response_code($err->getCode());
        echo $err->getMessage();
    }
?>