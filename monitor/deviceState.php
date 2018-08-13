 <?php
 $fileName = array('r124','r330a','r401','r415','r101c','sw4503' );
 $interfaces = array();
foreach ($fileName as $key => $value) {
	$swName = $fileName[$key];
 	$loadInterfaces = simplexml_load_file("mib/interface/".$fileName[$key].".xml");
 	$room = array();
	foreach($loadInterfaces->children() as $childs){
		foreach($childs->children() as $child){
			$name = $child->attributes()->name ;
			preg_match('@^(\w+)?(.\w+)@',$name, $matche);
			preg_match('/[^0-9]*([0-9]+)[^0-9]*/',$name, $matches);
			$key = $matche[1];
			$vlan = $matches[1];
			if($key == "ifDescr"){
				foreach($child->children() as $val){
					$value = $val->getName() . $val ;
					$room[ $val->children().$val] = "";
				}
			}
			elseif ($key == "ifAdminStatus") {
				foreach($child->children() as $val){
					foreach ($room as $key => $value) {
						$room[$key] = $val->children() . $val;
					}
				}
			}//else
		}//for name
	}//for end
	$interfaces[$swName] = $room;
}
/*print_r($interfaces);
*/
$json = json_encode($interfaces);

echo $json;
 ?>