<?php
    function readJson($fileAddr){
        if(file_exists($fileAddr)){
            $file = file_get_contents($fileAddr);
            return json_decode($file);
        }

        return False;
    }

    function addOnJson($fileAddr, $data){
        $jsonData = readJson($fileAddr);
        print_r('test');
        // print_r(!$jsonData);
        if(!$jsonData){
            $data['id'] = 1;
            $jsonData = [$data];

        } else {
            $jsonData = json_decode($jsonData);
            $last_index = end($jsonData)['id'];
            $data['id'] = $last_index++;
            array_push($jsonData,$data);
        }
        file_put_contents($fileAddr, json_encode($jsonData));
    }
?>