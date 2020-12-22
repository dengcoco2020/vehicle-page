<?php

$app->get('/', function($request, $response) {
    echo 'Vehicle Page - Coding Exam for NinePine Technologies';
});

$app->get('/vehicles', function($request, $response) {
    $db = getConnection();

    $sql = 'select * from tbl_vehicles where vehicle_flag = 1';
	$result = $db->query($sql);

	if($result->num_rows > 0) {
		$data['response'] = array ('status_code' => 200, 'msg' => 'Get all vehicles', 'data_cnt' => $result->num_rows);
		while($row = $result->fetch_assoc()) {
			$data['vehicles'][] = $row;
		}
	}
	else {
		$data['response'] = array ('code' => 0, 'msg' => $db->error);
	}
	mysqli_close($db);
	$response->write(json_encode($data));
});

$app->post('/vehicles', function($request, $response) {

    $db = getConnection();

    $name = $request->getParsedBody()['name'];
    $engine_displacement = $request->getParsedBody()['engine_displacement'];
    $engine_power = $request->getParsedBody()['engine_power'];
    $price = $request->getParsedBody()['price'];
    $location = $request->getParsedBody()['location'];

    $sql = 'insert into tbl_vehicles (name, engine_displacement, engine_power, price, location) values (?, ?, ?, ?, ?)';
	$stmt = $db->prepare($sql);
    $stmt->bind_param('sssds', $name, $engine_displacement, $engine_power, $price, $location);
    
    $status_code = 200;

    if($stmt->execute()) {
        $status_code = 201;
        $last_id = $stmt->insert_id;
        $data['response'] = array ('status_code' => $status_code, 'msg' => 'Resource created', '_link' => '/vehicles/' . $last_id);
    }
    else {
        $status_code = 400;
        $data['response'] = array ('status_code' => $status_code, 'msg' => 'Bad request');
    }

    return $response->write(json_encode($data));
});

$app->get('/vehicles/{vehicle_id}', function($request, $response) {

    $id = $request->getAttribute('vehicle_id');
    $db = getConnection();

    $sql = 'select * from tbl_vehicles where vehicle_id = ' . $id;
	$result = $db->query($sql);

	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $v = $row;
        }
        $data['response'] = array ('status_code' => 200, 'msg' => 'Get vehicle by ID', 'vehicle' => $v);
	}
	else {
		$data['response'] = array ('code' => 0, 'msg' => $db->error);
	}
	mysqli_close($db);
	$response->write(json_encode($data));

});