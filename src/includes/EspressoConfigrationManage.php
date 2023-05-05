<?php
namespace Espresso;

class EspressoConfigrationManage
{
	
	public static function EspressoConfigrationData()
	{
			
				
	 		$Configration = 

			    [
			        "root" => "https://api.myespresso.com/espressoapi/services",
				    "login" =>"https://api.myespresso.com/espressoapi/auth/login.html",
					"token" =>"/access/token",
					"place" =>"/orders",
					"modify" =>"/orders",
					"cancel" =>"/orders",
					"funds" =>"/limitstmt",
					"report" =>"/reports",
					"position" =>"/trades",
					"history" =>"/reports",
					"trades" =>"/reports",
					"cancelById" =>"/cancelOrder",
					"holdings" =>"/holdings",
					"master" =>"/master",
					"symbol" =>"/master/csv",
					"historical" =>"/historical",
				    "debug" => false,
				    "timeout" => 7000,
				   
				    "generate_token" => "/access/token",
				  
				];



			return $Configration;	
	}	
	
	
	
}		
?>