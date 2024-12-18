<?php //if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
class My_functions {
    
    public function fecha($fecha) {  
	$array = preg_split('/(-)/', $fecha);
	echo $array[2].'/'.$array[1].'/'.$array[0];
    }

    public function n($numero){
	$array=preg_split('/(\.)/', $numero);
	if(count($array)>1){
		if(strlen($array[1])==1)
			return $numero.'0';
		else if (strlen($array[1])==2) 
			return $numero;
		else {
			$temp=$array[1];
			if($temp[2]>=5 && $temp[1]!=9)
				return $array[0].'.'.$temp[0].($temp[1]+1);
                        else if ($temp[2]<5)
                                return $array[0].'.'.$temp[0].$temp[1];
			else if ($temp[1]==9 && $temp[0]!=9) 
				return $array[0].'.'.($temp[0]+1).'0';
			else if ($temp[1]==9 && $temp[0]==9) 
				return ($array[0]+1).'.00';
		}
	}
	else
            return $numero.'.00';
    }

    public function m($numero){
	$array=preg_split('/(\.)/', $numero);$text=(string)$array[0];$cont=0;$aux=$res='';
	if(strlen($text)>3){
		for ($i=strlen($text)-1; $i >=0; $i--) {		
			if($cont==3){
				$aux=$aux.',';
				$cont=0;
			} 	
			$aux=$aux.$text[$i];
			$cont++;
		}
		for ($i=strlen($aux)-1; $i >=0; $i--)
                    $res=$res.$aux[$i];    
		echo $res.'.'.$array[1];
	}
	 else 
            echo $numero;
    }
}
?>
