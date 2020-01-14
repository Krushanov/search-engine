<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function create_index_file() {
        // Creating of dictionary
        $handle = fopen(storage_path('app/public/dictionary.txt'), 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $key = str_replace(' ', '', substr($line, 0, 30));
                $val = str_replace(PHP_EOL, '', substr($line, 30));
                $dictionary[$key] = $val;
            }

            fclose($handle);
        } else {
            return;
        }

        $counter = 1;
        $filesInFolder = \File::files(storage_path('app/public/files'));     
        foreach($filesInFolder as $path) {
            $file = pathinfo($path);
            $files[$counter] = $file['filename'];

            $content = str_replace(PHP_EOL, '', file_get_contents($path));
            $words = IndexController::getWordsArray($content);
            foreach ($words as $str) {
                $s = IndexController::tokenStemming($str, $dictionary);
                if (isset($tokens[$s])) {
                    $val = $tokens[$s];
                    $val[] = $counter;
                    $tokens[$s] = $val;
                } else {
                    $tokens[$s] = [$counter];
                }
            }

            $counter++;
        }

        $fileContent = "";
        foreach ($files as $key => $value) {
            $fileContent .= $key . "    " . $value . "\n";
        }
        Storage::put('files_index.txt', $fileContent);

        $fileContent = "";
        foreach ($tokens as $key => $value) {
            $fileContent .= $key . "    [" . IndexController::arrayToStr($value) . "]\n";
        }

        Storage::put('tokens_index.txt', $fileContent);
    }

    public function getWordsArray($content) {
        return array_unique(preg_split('/[\s,]+/', preg_replace('/[\W]/', ' ', strtolower($content)), -1, PREG_SPLIT_NO_EMPTY));
    }

    public function tokenStemming($input, $dictionary) {
        if (isset($dictionary[$input]))
            return $dictionary[$input];

        return $input;
    }

    public function arrayToStr($array) {
        $str = "";
        foreach ($array as $value) {
            $str .= $value . ",";
        }

        return $str;
    }
}
