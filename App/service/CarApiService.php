<?php

namespace App\service;

class CarApiService{

public function getAll(){

    $url = 'http://localhost/car-dealership-fullstack/public/api/cars';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    // check error
    if (curl_errno($curl)) {
        die("curl error" . curl_errno($curl));
    } else {
        $data = json_decode($response, true);
        return $data;
        // echo $response;
    }
    // 5.close the session
    curl_close($curl);
}
public function getcar($id){
    $url = 'http://localhost/car-dealership-fullstack/public/api/cars/'.$id;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    // check error
    if (curl_errno($curl)) {
        die("curl error" . curl_errno($curl));
    } else {
        $data = json_decode($response, true);
        return $data;
        // echo $response;
    }
    // 5.close the session
    curl_close($curl);
}
}

// $get= new CarApiService();
//         echo '<pre>';
// print_r($get->getcar(1));
//         echo '</pre>';
?>