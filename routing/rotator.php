<?php

function getRandomWeightedElement(array $weightedValues)
{
    $rand = mt_rand(1, (int)array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
        $rand -= $value;
        if ($rand <= 0) {
            return $key;
        }
    }
    return null;
}

$landings = $db->get_rotate_landings($info[0]['to']);
var_dump($landings);
$weights = [];
foreach ($landings as $landing) {
    $weights[] = $landing['procent'];
}
$num = getRandomWeightedElement($weights);
header('Location: /landings/lands/' . $landings[$num]['domain_name'] . '/' . $landings[$num]['name']);
//    echo getRandomWeightedElement()."\n";
