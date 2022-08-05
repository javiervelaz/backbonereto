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
        $db = explode("\r\n", $content);
        unset($db[0]);
        unset($db[1]);
        foreach($db as $item){
            if(explode('|',$item)[0] === $id){
                $strarr['zip_code'] = explode('|',$item)[0];
                $strarr['locality'] =utf8_decode(explode('|',$item)[4]);
                $strarr['federal_entity'][explode('|',$item)[7]] =[
                    "key"=>explode('|',$item)[7],
                    "name"=>utf8_decode(explode('|',$item)[4]),
                    "code" => null
                ]; 
                $strarr['settlements'][explode('|',$item)[12]] = [
                    "key" =>utf8_decode(explode('|',$item)[12]),
                    "name" =>utf8_decode(explode('|',$item)[1]),
                    "zone_type" =>utf8_decode(explode('|',$item)[13]),
                    "settlement_type" => [
                        "name" =>      utf8_decode(explode('|',$item)[2])
                    ],
                ];
                $strarr['municipality'][explode('|',$item)[11]] =[
                    "key"=>utf8_decode(explode('|',$item)[11]),
                    "name"=>utf8_decode(explode('|',$item)[3]),
                ]; 
            }
        }
        return json_encode($strarr);
       
    }
}
