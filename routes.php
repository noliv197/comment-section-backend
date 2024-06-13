<?php
    include 'File.php';
    include 'Comment.php';
    include 'User.php';
    
    // add Cors-configuration
    // header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Origin: http://127.0.0.1:63040");
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
                        
                    break;
                    default:
                        throw new Exception("No path found", 404);
                } 
            break;
            case "POST":
                switch ($_SERVER['PATH_INFO']) {
                    case '/login':
                        
                    break;
                    case '/register':
                        
                    break;
                    case '/logout':
                       
                    break;
                    case '/addComment':
                        // check if user is logged in, if yes it adds a new entry to the cart_tb
                        if(key_exists('userId', $_POST) && key_exists('comment', $_POST)){
                            addComment($_POST['userId'],$_POST['comment']);
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