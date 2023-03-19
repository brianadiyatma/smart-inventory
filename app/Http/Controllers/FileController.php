<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Response;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class FileController extends Controller
{
    public function store(Request $request){     
        Storage::disk('myDisk')->put('example.txt', 'Contents');
    }

    public function getFile(Request $request){
        $path = storage_path('app/uploads/' . 'NeutralA0000.jpg');
        $type = File::mimeType($path);
        $file = File::get($path);
        $contents = Storage::disk('myDisk')->url('NeutralA0000.jpg');
        return '<img src="data:image/'.$type.';base64,'.base64_encode($file).'"/>';


        
        // try {
        //     $file = File::get($path);
        //     $type = File::mimeType($path);
        //     $response = Response::make($file, 200);
        //     $response->header("Content-Type", $type);
        //     return $response;
        // } catch (FileNotFoundException $exception) {
        //     abort(404);
        // }
    }

    public function getQrCode(Request $request){             
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($request->qr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        
        // Create generic logo
        $logo = Logo::create(\public_path('img/image4.jpg'))->setResizeToWidth(50);            
        
        // Create generic label
        $label = Label::create($request->qr)
            ->setTextColor(new Color(0, 0, 0));
        
        $result = $writer->write($qrCode, null, $label);
        // echo $result->getDataUri();

        return response()->json(['qr'=>$result->getDataUri()],200);
        // Validate the result
        // $writer->validateResult($result, 'Life is too short to be generating QR codes');
        
    }

}
