<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GetMoney extends Controller{
	
	private $request = null;
	
	public function __construct(){
		$this->request = Request::createFromGlobals();
	}
	
	/**
	 * @Route("/CheckUser")
	 */
	public function CheckUser()
	{
		
		//Usuario y contraseña validos
		$user = "clickbus";
		$pin  = "clickbus";
	
		//Inicializamos response
		$response = new Response();
		$response->headers->set('Content-Type','application/json');
	
		//Verificamos que sea usuario y contraseña correctos
		if($user == $this->request->get("user") && $pin == $this->request->get("pin")){
			$response->setContent(json_encode(array(
					"status"=>true,
			)));
		}else{
			$response->setContent(json_encode(array(
					"status"=>false,
			)));
		}
	
		//Devolvemos la respuesta
		return $response;
			
	}
	
	/**
	 * @Route("/GetMoney")
	 */
	public function GetMoney()
	{
		
		//Iniciamos variables
		$denominacion = array(100,50,20,10);
		$cantidad = floatval($this->request->get("amount"));
		$response = array("amounts"=>array(),"error"=>null);
												
		//Es entero
		$is_int = preg_match('/^\d+$/', $cantidad);
		
		//Si residuo de cantidad entre 10 es 0, es entero y es mayor a cero
		if( $cantidad%10 == 0 && $is_int && $cantidad>0 ){
						
			//Por cada denominacion
			foreach($denominacion as $key=>$den){
				
				//Obtenemos el residuo de cantidad entre denominacion y obtenemos el numero de billetes a entregar de dicha denominacion
				$mod = $cantidad%$den;
				$NumBilletes = intval($cantidad/$den);
				
				//Array con numero de denominaciones a entregar
				$response["amounts"][] = "Cantidad de billetes de {$den}: {$NumBilletes}";
				
				if($mod==0){	//Si el residuo fue cero se para el ciclo 
					break;
				}else{ 			//De lo contrario se actualiza cantidad con lo restante y se repite el ciclo
					$cantidad = $mod;
				}
				
			}//fin foreach
		
		//Si algna de las condiciones falla mandamos error
		}else{
			$response["error"] = "Solo puede retirar cantidades Positivas, enteras y m&#250;ltiplos de 10";
		}
				
		//Devolvemos la respuesta
		return new Response(
				json_encode($response)
		);
	}
			
}