<?php

require_once("../config/conexion.php");
require_once("../model/Producto.php");

$producto = new Producto();

switch ($_GET["op"]) {

    case "listar":
        $datos = $producto->get_producto();

        $data = Array();

        foreach($datos as $row){
            $sub_array = array();

            $sub_array[] = $row["prod_nombre"];
            $sub_array[] = '<button type="button" onClick="editar('.$row["prod_id"].');" id="'.$row["prod_id"].'" class="btn btn-outline-primary btn-icon"><div class="fa fa-edit"></div></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["prod_id"].');" id="'.$row["prod_id"].'" class="btn btn-outline-danger btn-icon"><div class="fa fa-trash"></div></button>';

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);

    break;

    case "guardaryeditar":
        header("Content-Type: application/json; charset=utf-8");
        $prod_nom = trim($_POST["prod_nom"] ?? "");
        if ($prod_nom === "") {
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "El nombre del producto es obligatorio."));
            break;
        }

        if (empty($_POST["prod_id"])) {
            $producto->insert_producto($prod_nom);
        } else {
            $producto->update_producto($_POST["prod_id"], $prod_nom);
        }
        echo json_encode(array("success" => true));
        break;

    case "mostrar":
        $datos=$producto->get_producto_x_id($_POST["prod_id"]);
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row){
                $output["prod_id"] = $row["prod_id"];
                $output["prod_nom"] = $row["prod_nombre"];
            }
        }
        break;

    case "eliminar":
        $producto->delete_producto($_POST["prod_id"]);
        break;
    }
?>