<?

require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

//JavaScript
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs("/feedbackform/base.js");

//HL block!!!
// подключаем пространство имен класса HighloadBlockTable и даём ему псевдоним HLBT для удобной работы
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
// id highload-инфоблока
const MY_HL_BLOCK_ID = 1;
//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');

//Функция получения экземпляра класса:
function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1)
    {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}
?>
<div class="container">

<!-- Форма -->

	<h3>Форма</h3>
	<form id="form" class="needs-validation" novalidate>
		<div class="form-group">
			<label for="InputFio">ФИО*</label>
			<input name="fio" type="text" class="form-control" id="InputFio" placeholder="Введите ФИО" required>
			<div class="valid-feedback">
				Поле заполнено!
			</div>
			<div class="invalid-feedback">
				Заполните ФИО!
			</div>
		  </div>
		  <div class="form-group">
			<label for="InputEmail">Email*</label>
			<input name="email" type="email" class="form-control" id="InputEmail" placeholder="Введите email" required>
			<div class="valid-feedback">
				Поле заполнено!
			</div>
			<div class="invalid-feedback">
				Заполните Email в правильном формате!
			</div>
		  </div>
		  <div class="form-group">
			<label for="InputTel">Телефон</label>
			<input name="tel" pattern="^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$" type="tel" class="form-control" id="InputTel" placeholder="Введите номер телефона">
		  </div>
            <div class="valid-feedback">
				Поле заполнено!
			</div>
            <div class="invalid-feedback">
                Заполните телефон в правильном формате!
            </div>
		  <div class="form-group">
			<label for="InputQuestion">Вопрос*</label>
			<textarea name="question" type="text" class="form-control" id="InputQuestion" placeholder="Введите вопрос" rows="3" required></textarea>
			<div class="valid-feedback">
				Поле заполнено!
			</div>
			<div class="invalid-feedback">
				Заполните вопрос!
			</div>
		</div>
		<p><strong>* - обязательные вопросы</strong></p>
		<button type="submit" class="btn btn-primary">Подтвердить</button>

	</form>
	<div id="alertBlock" class="alert alert-success" role="alert" style="display:none"></div>

	<!-- Отступы -->
	<br><br>

<!-- Вывод записей из HL блока -->
<?
$entity_data_class = GetEntityDataClass(1);
$count_notice = 5; // Количество в одном выводе пагинации
// Создаем объект пагинации
$nav = new \Bitrix\Main\UI\PageNavigation("nav-more-notice");
$nav->allowAllRecords(true)
    ->setPageSize($count_notice)->initFromUri();

$filters = [];

if (empty($_GET['UF_DATE']) && empty($_GET['UF_FIO']))
{
    $filters['UF_DATE'] = 'ASC';
}
else
{
    foreach ($_GET as $key => $value)
    {
        if ($value != 'none' && $value != 'Не выбрано' && $key != 'nav-more-notice')
        {
            $filters[$key] = $value;
        }
    }
}

$rsData = $entity_data_class::getList(array(
    'order' => $filters,
    'select' => array(
        '*'
    ) ,
    'count_total' => true,
    'offset' => $nav->getOffset() , // Из объекта пагинации добавляем смещение для HighloadBlock
    'limit' => $nav->getLimit() , // Здесь лимит из Объекта пагинации
    'filter' => array(
        '!UF_FIO' => false
    )
));
// Складируем общее количество записей в объект пагинации, перед выбором нужных объектов
$nav->setRecordCount($rsData->getCount());
?>

	<h3>Вывод результатов формы</h3>

	<!-- Сортировки -->
	<form method="GET">
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="fioSelect">ФИО</label>
			</div>
				<select id="fioSelect" name="UF_FIO" class="custom-select" aria-label=".form-select-lg example">
					<option value="none" selected >Не выбрано</option>
					<option value="ASC" >В обычном порядке</option>
					<option value="DESC">В обратном порядке</option>
				</select>

			<div class="input-group-prepend">
				<label class="input-group-text" for="dateSelect">Дата</label>
			</div>
				<select id="dateSelect" name="UF_DATE" class="custom-select" aria-label=".form-select-sm example">
					<option value="none" selected >Не выбрано</option>
					<option value="DESC">В обычном порядке</option>
					<option value="ASC">В обратном порядке</option>
				</select>
				<input class="btn btn-primary" type="submit" value="Подтвердить">
		</div>
	</form>

	<table id="resultTable" class="table">
	  <thead>
		<tr>
		  <th scope="col">ФИО</th>
		  <th scope="col">Email</th>
		  <th scope="col">Телефон</th>
		  <th scope="col">Вопрос</th>
		</tr>
	  </thead>
	  <tbody>
	<?
while ($el = $rsData->fetch())
{
?>
		<tr>
		  <th scope="row"><?=$el["UF_FIO"] ?></th>
		  <td><?=$el["UF_EMAIL"] ?></td>
		  <td><?=$el["UF_TEL"] ?></td>
		  <td><?=$el["UF_QUESTION"] ?></td>
		</tr>
	<?
}
?>
	  </tbody>
	</table>

<?

$APPLICATION->IncludeComponent("bitrix:main.pagenavigation", "test", Array(
    "NAV_OBJECT" => $nav,
    "SEF_MODE" => "N"
) , false);

?>

</div>


<? require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
