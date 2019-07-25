<?php

@include_once 'Orders.php';
@include_once 'OrdersRepository.php';

class OrdersController {

    public function AddOrders() {
        
        $ordersRepository = new OrdersRepository();
        $orders = new Orders();
        $orders->GetAccessToken();
        $orders->GetAllOrdersFromPM();
        $response = $orders->response;
        
        
        
        $responseArray = json_decode($response, true);
        
        // drop and create tables oders and items  
        $ordersRepository->dropCreateTable(); 
    
        
        for ($i = 0; $i < count($responseArray[entries]); $i++) {
            $serializedData = serialize($responseArray[entries][$i]);
            $ordersRepository->addOrders($responseArray[entries][$i][id], $serializedData);
            
            for ($s = 0; $s < count($responseArray[entries][$i][orderItems]); $s++) {
               
                $ordersRepository->addItems($responseArray[entries][$i][id] , $responseArray[entries][$i][orderItems][$s][id], $responseArray[entries][$i][orderItems][$s][orderItemName]);
            }
            
        }
        
     
        
    }

    
}
    

$controller = new OrdersController();
$controller->AddOrders();

    
?>