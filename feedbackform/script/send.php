<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
// подключаем пространство имен класса HighloadBlockTable и даём ему псевдоним HLBT для удобной работы
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');

//Функция получения экземпляра класса:
function GetEntityDataClass($HlBlockId) {
	if (empty($HlBlockId) || $HlBlockId < 1)
	{
		return false;
	}
	$hlblock = HLBT::getById($HlBlockId)->fetch();	
	$entity = HLBT::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	return $entity_data_class;
}

// Дата и время
$date = date('d.m.Y H:i:s');

if (!empty($_POST)) {

	if (!empty($_POST['fio'])) {
		$fio = strip_tags($_POST['fio']);
	}

	if (!empty($_POST['email'])) {
		$email = strip_tags($_POST['email']);
	}

	if (!empty($_POST['tel'])) {
		$tel = strip_tags($_POST['tel']);
	}

	if (!empty($_POST['question'])) {
		$question = strip_tags($_POST['question']);
	}

	$entity_data_class = GetEntityDataClass('1');

	$result = $entity_data_class::add(array(
		'UF_EMAIL'         => $email,
		'UF_FIO'         => $fio,
		'UF_TEL'         => $tel,
		'UF_QUESTION' => $question,
 		'UF_DATE' => $date
   ));

	echo 'Форма успешно отправлена!';

}

return false;
?>


