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

    function edit_json($fileAddr, $dataid, $newData){
        $jsonData = read_json($fileAddr, true);

        foreach ($jsonData as $index => $data) {
            if($data['id'] == $dataid){
                if(isset($newData['content'])){
                    $jsonData[$index]['content'] = $newData['content'];
                } elseif(isset($newData['score'])){
                    $jsonData[$index]['score'] = $newData['score'];
                }
            }
        }

        file_put_contents($fileAddr, json_encode($jsonData));
    }

    function del_on_json($fileAddr, $commentId){
        $jsonData = read_json($fileAddr, true);
 
        foreach ($jsonData as $index => $comment) {
            if(
                $comment['id'] == $commentId || 
                (isset($comment['parentId']) && $comment['parentId'] === $commentId)
            ){
                unset($jsonData[$index]);
            }
        }

        file_put_contents($fileAddr, json_encode(array_values($jsonData)));
    }
?>