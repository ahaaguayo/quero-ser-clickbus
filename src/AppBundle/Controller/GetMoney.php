<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class GetMoney extends Controller{
	
	/**
	 * @Route("/GetMoney/{cantidad}")
	 */
	public function GetMoney($cantidad)
	{
		
		$denominacion = array(100,50,20,10);
		$response = array();
				
		$cantidad = intval($cantidad);
		
		if($cantidad%10 == 0 && is_int($cantidad) && $cantidad>0){
			foreach($denominacion as $key=>$den){
				$mod = $cantidad%$den;
				$NumBilletes = intval($cantidad/$den);
				if($mod==0){
					$response[] = "Cantidad de billetes de {$den}: {$NumBilletes}";
					break;
				}elseif(($cantidad-$mod)>0){
					$response[] = "Cantidad de billetes de {$den}: {$NumBilletes}";
					$cantidad = $mod;
				}
			}
		}else{
			$response["error"] = "Solo puede retirar cantidades Positivas, enteras y multiplos de 10";
		}
				
		return new Response(
				json_encode($response)
		);
	} 
		
}