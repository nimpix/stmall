<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>


<br />
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>
<div class="form-table data-table">
    <button id="form-close">x</button>
    <div class="form-group">
	<?
    $formcount=2;
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
	?>


				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
				<?endif;?>
                 <label for="input<?=$formcount?>"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?></label>
				<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>

			<td><?=$arQuestion["HTML_CODE"]?></td>

	<?
        $formcount--;
	} //endwhile
	?>
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
		<tr>
			<th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
		</tr>
		<tr>
			<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
			<td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
		</tr>
<?
} // isUseCaptcha
?>

	<div class="button-group">

				<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Отправить" />
<!--        --><?//=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>

	</div>
    </div>
</div>

<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>