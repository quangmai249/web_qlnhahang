<?php
session_start();
$ROLE = ['Admin', 'Nhân viên Bếp', 'Nhân viên chạy bàn'];

function getCurrentDate(){
	return date("d/m/Y");
}

function getStatus($status){
	switch ($status) {
		case -1:
		return "Đã huỷ";
		case 0:
		return "Đăng đặt";
		case 1:
		return "Đã xác nhận";
		case 2:
		return "Đã nhận hàng";
		default:
		return "Đã thanh toán";
	}
}

function getStatusActionOrder($status){
	switch ($status) {
		case -1:
		return "Đã từ chối";
		case 0:
		return "Đã đặt";
		case 1:
		return "Đang chế biến";
		case 2:
		return "Đã chế biến";
		case 2:
		return "Đã lên bàn";
	}
}

function formatPrice($priceFloat) {
	$symbol = 'đ';
	$symbol_thousand = '.';
	$decimal_place = 0;
	$price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
	return $price.$symbol;
}

function callAPI($method, $url, $data = false)
{
	$url = "https://ql-nha-hang-3475b-default-rtdb.firebaseio.com/" . $url;
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
		case "DELETE":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
        case "PATCH":
            // curl_setopt($curl, CURLOPT_PUT, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
	$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$data = json_decode($result);
	curl_close($curl);
	if($method == 'GET') {
		return $data;
	}
    return $http_status;
}

function sentNotify($token, $message)
{
	$url = "https://fcm.googleapis.com/fcm/send";
    $curl = curl_init();
	$data = array(
		"to" => $token,
		"notification" => array(
			"body" => $message,
			"title" => "Cập nhập hóa đơn"
		)
	);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	$headers = array(
		'Content-type: application/json',
		'Authorization: key=AAAABZhmkPY:APA91bFbJw-UOtg5eVvlpapdKyY1vkh5qDqlcAhe9vnyLkYa8H3X6Zvedk0TOBPkJgSKYAoxQGvmK8J_X_6jd8xCL-Qm8k-uvMtG4ZN69BHqRVoDJt409CHB3nFEEwRWFQm_i8P3rfSd',
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
	$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	// $data = json_decode($result);
	curl_close($curl);
    return json_encode($result);
}
?>