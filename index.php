<html>
<head>
	<title>Zadanie1</title>
</head>
<body>
<?php

$url = "http://xml.enovatis.pl/mrdsl/json.php?url=http://www.wakacje.pl/wczasy/maroko";

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);


$tablica = json_decode($result, true);

foreach ($tablica as $klucz => $wartosc)
{
	foreach ($wartosc as $klucz1=> $wartosc1)
	{
		if (isset($wartosc1['discount']))
		{
			$data[$klucz1]['discount'] = $wartosc1['discount'];
			$data[$klucz1]['url'] = $wartosc1['url'];
			$data[$klucz1]['urlPhoto'] = $wartosc1['urlPhoto'];
			$data[$klucz1]['ratingAvg'] = $wartosc1['ratingAvg'];
		}
			
		uasort($data, function($a, $b) {
			return $b['discount'] <=> $a['discount'];
		});
	}

	$data = array_slice($data, 0, 3, TRUE);
	
	uasort($data, function($a, $b) {
			return $b['ratingAvg'] <=> $a['ratingAvg'];
		});
		//var_dump($data);
		
		foreach ($data as $key => $value)
		{
			$link = $value['url'];
			$photo = $value['urlPhoto'];
			echo "<a href=\"$link\"><img src=\"$photo\" /></a><br />";
		}
}

?>
</body>
</html>