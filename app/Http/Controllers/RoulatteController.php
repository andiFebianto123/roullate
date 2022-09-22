<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class RoulatteController extends Controller
{
    function index(){
        return view('home');
    }

    function getData(){

        $products = Product::join('product_stocks', 'product_stocks.product_id', 'products.id')->orderBy('product_stocks.id', 'DESC')
        ->get(['products.id', 'products.name', 'product_stocks.total_stock']);

        $data_products = [];

        $colors = [];
        $fills = [];

        $index = 0;

        $totalStok = $products->sum('product_stocks.total_stock');

        foreach($products as $product){
            $probability = ($product->total_stock / $totalStok) * 100;
            $data_products[] = [
                'id' => $product->id,
                'probability' => $probability,
                'type' => 'string',
                'value' => $product->name,
                'win' => true,
                'resultText' => 'You Get a '.$product->name,
                'userData' => array( 'score' => $probability ),
            ];
            if($index == 0){
                $colors[] = '#d70b00';
                $fills[] = 'white';
                $index = 1;
            }else{
                $index = 0;
                $colors[] = '#b7b7b7';
                $fills[] = 'black';
            }
        }

        $data = array(
            // "colorArray" => array("#364C62", "#F1C40F", "#E67E22", "#E74C3C", "#95A5A6", "#27AE60", "#2980B9", "#8E44AD", "#2C3E50", "#F39C12", "#D35400", "#C0392B", "#BDC3C7","#1ABC9C", "#2ECC71", "#E87AC2", "#3498DB", "#9B59B6", "#7F8C8D"),
            
            // "segmentValuesArray" => array( 
            
            //     array(
            //     // "probability" => 20,
            //     "type" => "string",
            //     "value" => "HOLIDAY^FOR TWO",
            //     "win" => false,
            //     "resultText" => "YOU WON A HOLIDAY!",
            //     "userData" => array("score" => 10)
            // ),
            //     array(
            //     // "probability" => 25,
            //     "type" => "string",
            //     "value" => "Kopi",
            //     "win" => true,
            //     "resultText" => "A STAR!",
            //     "userData" => array("score" => 20)
            // )
            // ,
            //     array(
            //     // "probability" => 120,
            //     "type" => "string",
            //     "value" => "Susu",
            //     "win" => true,
            //     "resultText" => "A SQUARE!",
            //     "userData" => array("score" => 3000)
            // )
            // ,
            //     array(
            //     // "probability" => 20,
            //     "type" => "image",
            //     "value" => "media/tip_oct.svg",
            //     "win" => false,
            //     "resultText" => "An OCTOGON!",
            //     "userData" => array("score" => 40)
            // )
            // ,
            //     array(
            //     // "probability" => 20,
            //     "type" => "image",
            //     "value" => "media/tip_hex.svg",
            //     "win" => true,
            //     "resultText" => "A HEXAGON!",
            //     "userData" => array("score" => 50)
            // )
            // ,
            //     array(
            //     // "probability" => 14,
            //     "type" => "image",
            //     "value" => "media/tip_triangle.svg",
            //     "win" => true,
            //     "resultText" => "A TRIANGLE!",
            //     "userData" => array("score" => 60)
            // )
            // ),
            "svgWidth" => 1024,
            "svgHeight" => 768,
            "wheelStrokeColor" => "#454344",
            "wheelStrokeWidth" => 18,
            "wheelSize" => 700,
            "wheelTextOffsetY" => 80,
            "wheelTextColor" => "#EDEDED",
            "wheelTextSize" => "2.3em",
            "wheelImageOffsetY" => 40,
            "wheelImageSize" => 50,
            "centerCircleSize" => 10,
            // "centerCircleStrokeColor" => "#F1DC15",
            "centerCircleStrokeColor" => "#EDEDED",
            "centerCircleStrokeWidth" => 12,
            "centerCircleFillColor" => "#EDEDED",
            "centerCircleImageUrl" => "media/logo.png",
            "centerCircleImageWidth" => 0,
            "centerCircleImageHeight" => 0,  
            "segmentStrokeColor" => "#E2E2E2",
            "segmentStrokeWidth" => 4,
            "centerX" => 512,
            "centerY" => 384,  
            "hasShadows" => false,
            "numSpins" => -1,
            "spinDestinationArray" => array(),
            "minSpinDuration" => 6,
            "gameOverText" => "THANK YOU FOR PLAYING SPIN2WIN WHEEL. COME AND PLAY AGAIN SOON!",
            "invalidSpinText" =>"INVALID SPIN. PLEASE SPIN AGAIN.",
            "introText" => "YOU HAVE TO<br>SPIN IT <span style='color=>#F282A9;'>2</span> WIN IT!",
            "hasSound" => true,
            "gameId" => "9a0232ec06bc431114e2a7f3aea03bbe2164f1aa",
            "clickToSpin" => true,
            "spinDirection" => "cw",
            "disabledText" => "You have no more spins today"
            
        );

        // if((count($products) % 2) == 1){
        //     // jika ganjil
        //     $colors[count($products) - 1] = $colors[1];
        // }

        $data['segmentValuesArray'] = $data_products;
        $data['colorArray'] = $colors;
        $data['fillColors'] = $fills;

        return response()->json($data);
    }
}
