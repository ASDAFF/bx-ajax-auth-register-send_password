<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 * @var array $arLangMessages
 * @var array $templateData
 *
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $parentTemplateFolder
 * @var string $templateName
 * @var string $componentPath
 *
 * @var CDatabase $DB
 * @var CUser $USER
 * @var CMain $APPLICATION
 */
//if(method_exists($this, 'setFrameMode')) $this->setFrameMode(TRUE);
?>
<div class="bx-system-auth-forgotpasswd">
<?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<form name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
	<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
	<?endif;?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">

	<div class="p"><?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?></div>

	<table class="bx-system-auth-table">
		<tbody>
		<tr>
			<td><?= GetMessage("AUTH_LOGIN") ?></td>
			<td>
				<input type="text" name="USER_LOGIN" maxlength="50"  value="<?= $arResult["LAST_LOGIN"] ?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?= GetMessage("AUTH_OR") ?></td>
		</tr>
		<tr>
			<td><?= GetMessage("AUTH_EMAIL") ?></td>
			<td>
				<input type="text" name="USER_EMAIL" maxlength="255"/>
			</td>
		</tr>
		</tbody>
		<tfoot>
		<tr>
			<td></td>
			<td>
				<button type="submit" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>"><?= GetMessage("AUTH_SEND") ?></button>
			</td>
		</tr>
		</tfoot>
	</table>
	<br/>
	<div class="p">
		<noindex><a href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a></noindex>
	</div>
</form>

</div>