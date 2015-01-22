<?php

use Everyman\Neo4j\Client;
use Everyman\Neo4j\Exception;
use Everyman\Neo4j\Cypher\Query;

class Neo4jPhpTest extends TestCase
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client('demo.sb02.stations.graphenedb.com', 24789);
        $this->client->getTransport()->setAuth('demo', 'MNmlVrLZPo79qtJFGAem');
        $q = 'MATCH (n) OPTIONAL MATCH (n)-[r]-() DELETE n,r';
        $query = new Query($this->client, $q);
        $result = $query->getResultSet();
    }

    public function test_It_Works()
    {
        $user_label = $this->client->makeLabel('User');
        $planet_label = $this->client->makeLabel('Planet');
        $user_labels = [$user_label];
        $planet_labels = [$planet_label];

        $arthur = $this->client->makeNode()
            ->setProperty('name', 'Arthur Dent')
            ->setProperty('mood', 'nervous')
            ->setProperty('home', 'small cottage')
            ->save();
        $arthur->addLabels($user_labels);

        $ford = $this->client->makeNode()
            ->setProperty('name', 'Ford Prefect')
            ->setProperty('occupation', 'travel writer')
            ->save();
        $ford->addLabels($user_labels);

        $earth = $this->client->makeNode()
            ->setProperty('name', 'Earth')
            ->save();
        $earth->addLabels($planet_labels);

        $vogons = $this->client->makeNode()
            ->setProperty('name', 'Vogons')
            ->save();
        $vogons->addLabels($user_labels);

        $arthur->relateTo($earth, 'LIVES_ON')
            ->setProperty('duration', 'all his life')
            ->save();

        $ford->relateTo($earth, 'APPRECIATES')
            ->setProperty('quantity', 'a lot')
            ->save();

        $vogons->relateTo($earth, 'DEMOLISHED')
            ->setProperty('method', 'Vogon Constructor Fleet')
            ->setProperty('date', 'a few minutes ago')
            ->save();
        /*


        $ford = $client->makeNode()
            ->setProperty('id', $user2)
            ->setProperty('name', 'Ford Prefect')
            ->setProperty('occupation', 'travel writer')
            ->save();
        $ford->addLabels($labels);
        $fordId = $ford->getId();
        //print_r($fordId."\n");


        $character = $client->getNode($arthurId);

        foreach ($character->getProperties() as $key => $value) {
            echo "$key: $value\n";
        }

        $character->removeProperty('mood')
            ->setProperty('home', 'demolished')
            ->save();

        foreach ($character->getProperties() as $key => $value) {
            echo "$key: $value\n";
        }
        */

    }
}
