<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockOut;

class RoulatteController extends Controller
{
    // andi edited
    function index(){
        $configuration = Configuration::where('key', 'show_roulette')->first()->value;

        if ($configuration) {
            return view('home-secondary');
        }else{
            echo "";
        }
    }

    function getData(){

        $products = Product::join('product_stocks', 'product_stocks.product_id', 'products.id')
                    ->leftJoin('stock_outs', 'stock_outs.product_stock_id', 'product_stocks.id')
                    ->orderBy('product_stocks.id', 'DESC')
                    ->selectRaw("
                        product_stocks.id as id, 
                        min(products.id) as product_id, 
                        min(products.name) as name, 
                        min(product_stocks.total_stock) as total_stock, 
                        sum(ifnull(stock_outs.out, 0)) as stock_out,
                        (min(product_stocks.total_stock) - sum(ifnull(stock_outs.out, 0))) as stock_remain,
                        min(background_color) as background_color,
                        min(text_color) as text_color
                    ")
                    ->groupBy('product_stocks.id')
                    ->get();

        $data_products = [];

        $colors = [];
        $fills = [];

        $index = 0;

        $totalStok = $products->sum('stock_remain');

        foreach($products as $product){
            $probability = ($product->stock_remain / $totalStok) * 100;
            // $probability = $product->total_stock;
            $probability = floor($probability);
            $data_products[] = [
                'id' => $product->id,
                'probability' => $probability,
                'type' => 'string',
                'value' => $product->name,
                'win' => true,
                'resultText' => $product->name,
                'userData' => array( 'id' => $product->id, 'score' => $probability ),
            ];

                if($index == 0){
                    if (isset($product->background_color) && isset($product->text_color)) {
                        $colors[] = $product->background_color;
                        $fills[] = $product->text_color;
                        $index = 1;
                    }else{
                        $colors[] = '#d70b00';
                        $fills[] = 'white';
                        $index = 1;
                    }
                }else{
                    if (isset($product->background_color) && isset($product->text_color)) {
                        $colors[] = $product->background_color;
                        $fills[] = $product->text_color;
                        $index = 1;
                    }else{
                        $index = 0;
                        $colors[] = '#b7b7b7';
                        $fills[] = 'black';
                    }
                }            
        }

        $data = array(
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


    public function reduceStock(Request $request)
    {
        $id = $request->id;
        $productName = $request->name;

        $initialStock = ProductStock::where('id', $id)->first();
        $currentStock = StockOut::where('product_stock_id', $id)->sum('out');

        if (isset($currentStock)) {

            if ($initialStock->total_stock > $currentStock) {
                $insert = new StockOut();
                $insert->out = 1;
                $insert->product_stock_id = $id;
                $insert->product_name = $productName;
                $insert->save();
            
                return [
                    'status' => true,
                    'message' => 'Selamat Anda mendapatkan '.$productName,
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Stock Tidak Tersedia',
        ];
    }
}
