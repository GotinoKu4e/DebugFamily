<?php

Class Father
{
    public static $debugging;

    protected function response($joke)
    {
        return $joke == "old" && $this->debugging ? true : false;
    }

    public function setFather($mode, $value)
    {
	$this->{$mode} = $value;
    }
}

Class Kid extends Father
{
    public function postJoke($joke)
    {
        return $this->response($joke);
    }

    public function chooseJoke($jokes)
    {
	return $jokes[array_rand($jokes)];
    }
}

$kid = new Kid();
$jokesDir = "jokes";
$jokes = array_diff(scandir($jokesDir), [".", ".."]);
$chosenJoke = $kid->chooseJoke($jokes);

$i = 1;
while(!$kid->postJoke($chosenJoke))
{
    $debugging = (bool)rand(0, 1);
    $kid->setFather("debugging", $debugging);
    $chosenJoke = $kid->chooseJoke($jokes);
    
    $html  =  "Try Nr. {$i} to post a joke! ";
    $html .= "Father is " . ($debugging ? '' : ' not ') . "debugging, kid chose {$chosenJoke} joke.";
    $html .= "<br />";

    echo $html; 

    $i++; 
}

echo "<br />";
echo "<b>";
echo "Joke approved after {$i} tries! Chosen joke: {$chosenJoke}";
echo "</b>";

$theJoke = file_get_contents($jokesDir . DIRECTORY_SEPARATOR . $chosenJoke);


echo "<h1>";
echo nl2br($theJoke);
echo "</h1>";

?>
<style>
h1 {
    font-size: 52px;
    color: red;
}
</style>
