<?php

namespace App\Http\Controllers;

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadFileController extends Controller
{
    public function index() {
        $sharedConfig = [
                'key' => 'AKIA2JNBJDYRRQEQ6VKX',
                'secret' => '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',
                'region'  => 'us-east-2',
                'version' => 'latest'
        ];

        $s3Client = new S3Client($sharedConfig);

        $random = Str::random(4);

        $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => 'oscarparamodev',
                'Key'    => "logo.png",
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri();

        return view('upload', ['url' => $presignedUrl]);
    }
}
