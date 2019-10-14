<?php
// Read JSON file
$json = file_get_contents('argument.json');

//Decode JSON
$json_data = json_decode($json,true);



//print main argument
print($json_data['title']);
echo '<br/>';

//Start with the main Argument
defArgument($json_data);

// show final json file
print_r($json_data);

//Start the Function
function defArgument(&$array) {
	
	if ($array['calculatedScore'] > -1000) {
		// aguments calculatedScore and path have alreay been defined
		print("run part1");
		echo '<br/>';
		
    	return $array['calculatedScore'];
	}
	elseif (empty($array['childs'])) {
		// argument is at the most outer level, calculatedScore, path and acceptabilityDegree are set to 1. 
		print("run part2");
		echo '<br/>';
		
	    $array['calculatedScore'] = 1;
	    $array['pathCount'] = 1;
	    $array['acceptabilityDegree'] = 1;
	    return 1;
	}
	else {
		// argument needs to be defined, and is not on the most outer level
		print("run part3");
		echo '<br/>';
	    // loop over all children in the next level
		$calculatedScore = 0;
		$pathCount = 0;
	    for ($i = 0; $i < $array['answerCount']; $i++) {
	    	//order is important, first the calculatedScore needs to run, then the count.
	        $calculatedScore += defArgument($array['childs'][$i]) * $array['childs'][$i]['score']/100; // needs to be divided by 100, as scores should be between -1 and 1
	        $pathCount += $array['childs'][$i]['pathCount'];
	        
	    }
	    $array['calculatedScore'] = $calculatedScore;
	    $array['pathCount'] = $pathCount;
	    $array['acceptabilityDegree'] = 1 + $calculatedScore/$pathCount;
	    return $calculatedScore;
	}
}