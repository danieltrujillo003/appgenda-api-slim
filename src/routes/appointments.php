<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

$app->get('/api/appointments', function (Request $request, Response $response) {
  $query = 'SELECT * FROM appointments';

  try {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->query($query);
    $appointments = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $response->withStatus(200)
    ->write(json_encode($appointments));

  } catch(PDOException $e) {
    echo '{"error": {"text": ' . $e->getMessage() . '}';
  }
});

$app->get('/api/appointment/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];

  $query = "SELECT * FROM appointments WHERE id = ?";

  try {
    $database = new Database();
    $db = $database->connect();

		$stmt = $db->prepare($query);
		$stmt->execute([$id]);
		$appointment = $stmt->fetch(PDO::FETCH_OBJ);

    return $response->withStatus(200)
    ->write(json_encode($appointment));

  } catch(PDOException $e) {
    echo '{"error": {"text": ' . $e->getMessage() . '}';
  }
});

$app->post('/api/appointment/add', function (Request $request, Response $response) {
  $new_appointment = $request->getParams();
  extract($new_appointment);

  $query = "INSERT INTO appointments (date,time,description,name,lastname,clientid,birthdate,city,neighborhood,address,phonenumber) VALUES(:date,:time,:description,:name,:lastname,:clientid,:birthdate,:city,:neighborhood,:address,:phonenumber)";

  try {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare($query);

    $stmt->execute(['date'=>$date,'time'=>$time,'description'=>$description,'name'=>$name,'lastname'=>$lastname,'clientid'=>$clientid,'birthdate'=>$birthdate,'city'=>$city,'neighborhood'=>$neighborhood,'address'=>$address,'phonenumber'=>$phonenumber]);

    return $response->withStatus(200)
    ->withHeader('Content-Type', 'application/json')
    ->write(json_encode(array('message' => 'appointment added')));

  } catch(PDOException $e) {
    echo '{"error": {"text": ' . $e->getMessage() . '}';
  }
});

$app->put('/api/appointment/update/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];
  $updated_appointment = $request->getParams();
  extract($updated_appointment);

  $query = "UPDATE appointments SET date=:date,time=:time,description=:description,name=:name,lastname=:lastname,clientid=:clientid,birthdate=:birthdate,city=:city,neighborhood=:neighborhood,address=:address,phonenumber=:phonenumber WHERE id=:id";

  try {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare($query);

    $stmt->execute(['date'=>$date,'time'=>$time,'description'=>$description,'name'=>$name,'lastname'=>$lastname,'clientid'=>$clientid,'birthdate'=>$birthdate,'city'=>$city,'neighborhood'=>$neighborhood,'address'=>$address,'phonenumber'=>$phonenumber,'id'=>$id]);

    return $response->withStatus(200)
    ->withHeader('Content-Type', 'application/json')
    ->write(json_encode(array('message' => 'appointment updated')));

  } catch(PDOException $e) {
    echo '{"error": {"text": ' . $e->getMessage() . '}';
  }
});

$app->delete('/api/appointment/delete/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];

  $query = "DELETE FROM appointments WHERE id = ?";

  try {
    $database = new Database();
    $db = $database->connect();

    $stmt = $db->prepare($query);

    $stmt->execute([$id]);

    return $response->withStatus(200)
    ->withHeader('Content-Type', 'application/json')
    ->write(json_encode(array('message' => 'appointment deleted')));

  } catch(PDOException $e) {
    echo '{"error": {"text": ' . $e->getMessage() . '}';
  }
});