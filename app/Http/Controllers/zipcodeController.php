<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class zipcodeController extends Controller
{
    //
    public function getZipCode($id){
        return $id;
    }

    public function readFile($id){
        $content = File::get('CPdescarga.txt');
       
        $db = explode("\n", $content);
        unset($db[0]);
        unset($db[1]);
        $strarr = [];
        
        foreach($db as $item){
            if(explode('|',$item)[0] === $id){
                $strarr['zip_code'] = explode('|',$item)[0];
                $strarr['locality'] =strtoupper(utf8_decode(explode('|',$item)[5]));
                $strarr['federal_entity'][explode('|',$item)[7]] =[
                    "key"=>utf8_decode(explode('|',$item)[7]),
                    "name"=>strtoupper(utf8_decode(explode('|',$item)[5])),
                    "code" => null
                ]; 
                /*$strarr['settlements'][explode('|',$item)[12]] = [
                    "key" =>utf8_decode(explode('|',$item)[12]),
                    "name" =>strtoupper(utf8_decode(explode('|',$item)[1])),
                    "zone_type" =>strtoupper(utf8_decode(explode('|',$item)[13])),
                    "settlement_type" => [
                        "name" =>    strtoupper(utf8_decode(explode('|',$item)[2]))
                    ],
                ];*/
                $settlements[explode('|',$item)[12]] = [
                    "key" =>utf8_decode(explode('|',$item)[12]),
                    "name" =>strtoupper(utf8_decode(explode('|',$item)[1])),
                    "zone_type" =>strtoupper(utf8_decode(explode('|',$item)[13])),
                    "settlement_type" => [
                        "name" =>    strtoupper(utf8_decode(explode('|',$item)[2]))
                    ],
                ];
                $strarr['settlements'] = array_values($settlements);
               
                $strarr['municipality'][explode('|',$item)[11]] =[
                    "key"=>utf8_decode(explode('|',$item)[11]),
                    "name"=>strtoupper(utf8_decode(explode('|',$item)[3])),
                ]; 
            }
        }
        return json_encode($strarr);
    
    }
}
