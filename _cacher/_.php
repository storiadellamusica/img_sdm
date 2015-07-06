<? // Author: Stefano Peloso (http://stefano.io) - Released under CC BY-NC-SA 4.0 (http://creativecommons.org/licenses/by-nc-sa/4.0/)
define("_IMG","/home/storia/dati/sdm/");
define("_STATIC","/home/storia/webapps/img_sdm/");
define("_ROOT","/home/storia/webapps/sdm_2/");
require("DB._");
list($tipo,$altezza,$nome)=explode("/",preg_replace(["#\.jpg$#","#[^a-z0-9()_/-]#"],"",strtolower(urldecode($_SERVER["QUERY_STRING"]))));
$altezza+=0;
switch($tipo){
	case "a":
		$id=DB::valore("SELECT ID FROM sdmt_articoli WHERE url=",$nome);
		break;
	case "c":
		$id=DB::valore("SELECT ID FROM sdmt_capitoli WHERE url=",$nome);
		break;
	case "n":
		$id=$nome;
		break;
	case "r":
		$id=DB::valore("SELECT ID FROM sdmt_recensioni WHERE url LIKE '%/$nome'");
		break;
	case "u":
		$id=$nome;
		break;
	case "x":
		$id=DB::valore("SELECT ID FROM sdml_artista WHERE url=",$nome);
		break;
	default:
		$id=-1;	
}
if(!file_exists(_IMG."$tipo/$id.jpg")&&file_exists("gestori/$tipo._")){
	require("gestori/$tipo._");
	require("copiatore._");	
}
require("creatore._");
header("Content-type: image/gif");
header("HTTP/1.1 404 Not Found");
readfile("404.gif");