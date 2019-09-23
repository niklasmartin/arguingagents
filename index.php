<?php
error_reporting(0);
$question_url = "https://www.kialo.com/2629";
$level = 0;

$parts = explode("-",$question_url);
//break the string up around the "/" character in $mystring

$dependency = 0;

$argNr = 0;

$mystring = end($parts);
//grab the first part

echo $mystring;

echo "<br><br>";
runArgument($question_url, $dependecy, $level, $argNr);

function runArgument($question_url, $dependecy, $level, $argNr) {
    $data = file_get_contents($question_url);

    // short version of same regex
    $pattern = '{<script id="metadata-qapage" type="application/ld.json" data-react-helmet="true">(.*)</script>}';

    // $matchcount = preg_match_all($pattern_long, $data, $matches);
    $matchcount = preg_match_all($pattern, $data, $matches);
    echo("<pre>\n");
    $json = $matches[1][0];

    // echo "$json";
    // echo "<br><br>";

    $decode = json_decode($json, true);
    // echo $json;

    // $title = $decode['mainEntity']['text'];
    // echo "<br>";
    // echo $title;
    // echo "<br>";
    // echo $url = substr(explode('active=', $argument['url'], 2)[1],1);

    $arguments = $decode['mainEntity']['suggestedAnswer'];
    foreach ($arguments as $argument) {
        $argNr++;
        // echo "NUMBERRRRRRR: $argNr <br>";
        $text = $argument['text'];
        $myObj->title = substr($text,5);
        $myObj->procon = substr($text, 0,3);
        $myObj->score = $argument['upvoteCount'];
        $myObj->reference = substr(explode('active=', $argument['url'], 2)[1],1);
        
        $question_url2 = "https://www.kialo.com/$myObj->reference";
        $data = file_get_contents($question_url2);
        $pattern = '{<script id="metadata-qapage" type="application/ld.json" data-react-helmet="true">(.*)</script>}';
        $matchcount = preg_match_all($pattern, $data, $matches);
        echo("<pre>\n");
        $json = $matches[1][0];
        $decode = json_decode($json, true);
        $arguments = $decode['mainEntity']['suggestedAnswer'];
        foreach ($arguments as $argument) {
            $int = 0;
            $text = $argument['text'];
            $myObj2->title = substr($text,5);
            $myObj2->procon = substr($text, 0,3);
            $myObj2->score = $argument['upvoteCount'];
            $myObj2->reference = substr(explode('active=', $argument['url'], 2)[1],1);
            $myObj->argument[$int] = $myObj2;
            $int++;
        }

        $myJSON = json_encode($myObj);
        echo $myJSON;
        echo "<br>";

        // runArgument("https://www.kialo.com/$reference", $dependecy, $level++ , $argNr);
    }
}



?>