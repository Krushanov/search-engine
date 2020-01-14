<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\IndexController;

class SearchController extends Controller
{
    public function index($search_text) {
    	$indexController = new IndexController();

    	$handle = fopen(storage_path('app/public/dictionary.txt'), 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $key = str_replace(' ', '', substr($line, 0, 30));
                $val = substr($line, 30);
                $dictionary[$key] = $val;
            }

            fclose($handle);
        } else {
            return;
        }

        $words = $indexController->getWordsArray($search_text);
	    foreach ($words as $str) {
	        $stemmedWords[] = str_replace(PHP_EOL, '', $indexController->tokenStemming($str, $dictionary));
	    }

    	$handle = fopen(storage_path('app/tokens_index.txt'), 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
            	$index = strpos($line, '[');
                $key = str_replace(' ', '', substr($line, 0, $index));
                $val = explode(',', str_replace('[', '', str_replace(',]', '', str_replace(PHP_EOL, '', substr($line, $index)))));
                $tokens[$key] = $val;
            }

            fclose($handle);
        } else {
            return;
        }

    	$handle = fopen(storage_path('app/files_index.txt'), 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $key = str_replace(' ', '', substr($line, 0, 3));
                $val = str_replace(' ', '', str_replace(PHP_EOL, '', substr($line, 3)));
                $docs[$key] = $val;
            }

            fclose($handle);
        } else {
            return;
        }

        $searchedDocs = [];
        foreach ($stemmedWords as $value) {
        	if (isset($tokens[$value]))
        		$searchedDocs[] = $tokens[$value];
        }

        $results = [];
        foreach ($searchedDocs as $value) {
        	foreach ($value as $v) {
        		if (isset($docs[$v]))
        			$results[] = $docs[$v] . '.txt';
        	}
        }

    	return view('welcome', ['results' => array_unique($results)]);
    }
}
