<?php
$loremIpsum="Lorem ipsum dolor sit amet consectetur adipisicing elit. Error dolorum, 
animi eaque, assumenda quidem quas sequi perferendis porro itaque doloribus
eveniet earum! Dignissimos ab harum ex iure quis sit obcaecati, vel consectetur
fuga incidunt. Maxime fuga voluptate numquam! Autem itaque, ut doloribus tempora at
similique qui velit laborum minus ipsam.
";

echo "<p>{$loremIpsum}</p>";
echo "Panjang Karakter : " . strlen($loremIpsum) . "<br>";
echo "Panjang Kata : " . str_word_count($loremIpsum) . "<br>";
echo "<p>" . strtoupper($loremIpsum) . "</p>";
echo "<p>" . strtolower($loremIpsum) . "</p>";
?>