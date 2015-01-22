<?php

use Neoxygen\NeoClient\ClientBuilder;
use Neoxygen\NeoClient\Formatter\Node;

class BasicTest extends TestCase
{
    public function test_It_Works()
    {
        $client = ClientBuilder::create()
            ->addConnection('default','http','localhost',7474)
            ->setAutoFormatResponse(true)
            ->build();

        $root = $client->getRoot();
        //print_r($root);

        $n = new Node(rand(1,1000), [], []);
        $response = $client->sendWriteQuery();
        print_r($n);


        $q = 'MATCH (n) RETURN count(n)';
        $response = $client->sendCypherQuery($q)->getRows();
        print_r($response);

        $labels = $client->getLabels();
        print_r($labels);
    }
}
