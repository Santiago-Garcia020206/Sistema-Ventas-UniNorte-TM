<?php   
    require_once("../config/connection.php");
    require_once("../model/Product.php");

    $product = new Product();
    switch ($_GET["op"]) {
    case "listar":
        $datos = $product->get_product();
        $data = Array();
        foreach($datos as $row){
            $sub_array = array();
            $sub_array[] = $row["prod_nombre"];
            $sub_array[] = $row["prod_id"];
            $sub_array[] = $row["prod_id"];
            $data[] = $sub_array;
        }
        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
        echo json_encode($results);
    break;
    }
?>