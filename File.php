<?php
    function read_json($fileAddr, $returnArray=false){
        if(file_exists($fileAddr)){
            $file = file_get_contents($fileAddr);
            return json_decode($file, $returnArray);
        }

        return False;
    }

    function add_on_json($fileAddr, $data){
        $jsonData = read_json($fileAddr, true);
        if(!$jsonData){
            $data['id'] = 1;
            $jsonData = [$data];

        } else {
            $last_index = end($jsonData)['id'];
            $data['id'] = $last_index + 1;
            array_push($jsonData,$data);
        }
        file_put_contents($fileAddr, json_encode($jsonData));
    }
?>