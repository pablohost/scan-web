<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function form_submit(Request $request)
    {
        $url=$request->all()['Url'];
        
        $data = $this->get_content($url);
        $css_count = 0;

        if (empty($data)) {
            return response()->json([$request->all(), 0, 0, false, false]);
        }
        $doc    =   new \DOMDocument();
        @$doc->loadHTML($data);
        $img_count  =   $doc->getElementsByTagName('img');
        $links  =   $doc->getElementsByTagName('link');
        $css_in = str_contains($data, '</style>');

        //reviso que el <link css> sea un archivo y no codigo escrito dentro del mismo html
        for ($i=0; $i < $links->length; $i++) { 
            $link = $links->item($i);
            if ($link->getAttribute('rel') == 'stylesheet' || $link->getAttribute('type') == 'text/css') {
                $css_count+=1;
            }
        }


        return response()->json([$request->all(), $css_count, $img_count->length, $css_in, true]);
    }


    public function get_content($url='')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        //error_log('hey2-'.$data);
        return $data;
    }
}
