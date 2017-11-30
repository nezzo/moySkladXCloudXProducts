<?php
//работа сервера (прием и обработка данных)
if(!empty($_POST)){

	print_r($_POST['text']);

}else{
	echo "error";
}