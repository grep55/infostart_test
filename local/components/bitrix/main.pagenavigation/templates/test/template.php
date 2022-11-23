<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

/** @var PageNavigationComponent $component */
$component = $this->getComponent();

$this->setFrameMode(true);

$colorSchemes = array(
	"green" => "bx-green",
	"yellow" => "bx-yellow",
	"red" => "bx-red",
	"blue" => "bx-blue",
);
if(isset($colorSchemes[$arParams["TEMPLATE_THEME"]]))
{
	$colorScheme = $colorSchemes[$arParams["TEMPLATE_THEME"]];
}
else
{
	$colorScheme = "";
}
?>

<div class=" <?=$colorScheme?>">
	<div class="">
		<ul class="pagination">
<?if($arResult["REVERSED_PAGES"] === true):?>

	<?if ($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
		<?if (($arResult["CURRENT_PAGE"]+1) == $arResult["PAGE_COUNT"]):?>
			<li class="page-item"><a class="page-link"  href="<?=htmlspecialcharsbx($arResult["URL"])?>"><?echo GetMessage("round_nav_back")?></a></li>
		<?else:?>
			<li class="page-item"><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>"><?echo GetMessage("round_nav_back")?></a></li>
		<?endif?>
			<li class=""><a class="page-link"  href="<?=htmlspecialcharsbx($arResult["URL"])?>">1</a></li>
	<?else:?>
			<li class="page-item"><a class="page-link"><?echo GetMessage("round_nav_back")?></a></li>
			<li class="page-item active"><a class="page-link">1</a></li>
	<?endif?>

	<?
	$page = $arResult["START_PAGE"] - 1;
	while($page >= $arResult["END_PAGE"] + 1):
	?>
		<?if ($page == $arResult["CURRENT_PAGE"]):?>
			<li class="page-item active"><?=($arResult["PAGE_COUNT"] - $page + 1)?></li>
		<?else:?>
			<li class=""><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><?=($arResult["PAGE_COUNT"] - $page + 1)?></a></li>
		<?endif?>

		<?$page--?>
	<?endwhile?>

	<?if ($arResult["CURRENT_PAGE"] > 1):?>
		<?if($arResult["PAGE_COUNT"] > 1):?>
			<li class=""><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate(1))?>"><?=$arResult["PAGE_COUNT"]?></a></li>
		<?endif?>
			<li class="page-item"><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>"><?echo GetMessage("round_nav_forward")?></a></li>
	<?else:?>
		<?if($arResult["PAGE_COUNT"] > 1):?>
			<li class="page-item active"><a class="page-link"><?=$arResult["PAGE_COUNT"]?></a></li>
		<?endif?>
			<li class="page-item"><a class="page-link"><?echo GetMessage("round_nav_forward")?></a></li>
	<?endif?>

<?else:?>

	<?if ($arResult["CURRENT_PAGE"] > 1):?>
		<?if ($arResult["CURRENT_PAGE"] > 2):?>
			<li class="page-item"><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>"><?echo GetMessage("round_nav_back")?></a></li>
		<?else:?>
			<li class="page-item"><a class="page-link"  href="<?=htmlspecialcharsbx($arResult["URL"])?>"><?echo GetMessage("round_nav_back")?></a></li>
		<?endif?>
			<li class=""><a class="page-link"  href="<?=htmlspecialcharsbx($arResult["URL"])?>">1</a></li>
	<?else:?>
			<li class="page-item"><a class="page-link"><?echo GetMessage("round_nav_back")?></a></li>
			<li class="page-item active"><a class="page-link">1</a></li>
	<?endif?>

	<?
	$page = $arResult["START_PAGE"] + 1;
	while($page <= $arResult["END_PAGE"]-1):
	?>
		<?if ($page == $arResult["CURRENT_PAGE"]):?>
			<li class="page-item active"><a class="page-link"><?=$page?></a></li>
		<?else:?>
			<li class=""><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><?=$page?></a></li>
		<?endif?>
		<?$page++?>
	<?endwhile?>

	<?if($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
		<?if($arResult["PAGE_COUNT"] > 1):?>
			<li class=""><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["PAGE_COUNT"]))?>"><?=$arResult["PAGE_COUNT"]?></a></li>
		<?endif?>
			<li class="page-item"><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>"><?echo GetMessage("round_nav_forward")?></a></li>
	<?else:?>
		<?if($arResult["PAGE_COUNT"] > 1):?>
			<li class="page-item active"><a class="page-link"><?=$arResult["PAGE_COUNT"]?></a></li>
		<?endif?>
			<li class="page-item"><a class="page-link"><?echo GetMessage("round_nav_forward")?></a></li>
	<?endif?>
<?endif?>

<?if ($arResult["SHOW_ALL"]):?>
	<?if ($arResult["ALL_RECORDS"]):?>
			<li class="bx-pag-all"><a class="page-link"  href="<?=htmlspecialcharsbx($arResult["URL"])?>" rel="nofollow"><span><?echo GetMessage("round_nav_pages")?></span></a></li>
	<?else:?>
			<li class="bx-pag-all"><a class="page-link"  href="<?=htmlspecialcharsbx($component->replaceUrlTemplate("all"))?>" rel="nofollow"><span><?echo GetMessage("round_nav_all")?></span></a></li>
	<?endif?>
<?endif?>
		</ul>
		<div style="clear:both"></div>
	</div>
</div>
