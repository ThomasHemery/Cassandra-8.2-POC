<?php
echo "Cassandra test\n";

sleep(10);

while (true) {
    try {
        $cluster = Cassandra::cluster()
            ->withContactPoints('cassandra')
            ->build();
        $keyspace = 'system';
        $session = $cluster->connect($keyspace);
        $statement = new Cassandra\SimpleStatement(
            'describe tables'
        );
        $future = $session->executeAsync($statement, []);
        $result = $future->get(30);

        foreach ($result as $row) {
            print_r($row);
        }
        break;
    } catch (Exception $e) {
        echo("Failed to use cassandra with error {$e->getMessage()}\n");
        sleep(10);
        echo("Retrying\n");
    }
}