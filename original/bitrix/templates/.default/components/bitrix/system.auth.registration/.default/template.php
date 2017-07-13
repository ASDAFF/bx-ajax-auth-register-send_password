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
<div class="bx-system-auth-registration">
	<?
	ShowMessage($arParams["~AUTH_RESULT"]);
	?>
	<? if ($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) && $arParams["AUTH_RESULT"]["TYPE"] === "OK"): ?>
		<? echo GetMessage("AUTH_EMAIL_SENT") ?>
	<? else: ?>
		<form method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform">
			<?if (strlen($arResult["BACKURL"]) > 0):?>
				<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
			<?endif;?>
			<input type="hidden" name="AUTH_FORM" value="Y"/>
			<input type="hidden" name="TYPE" value="REGISTRATION"/>
			<input type="text" class="api-mf-antibot" value="" name="ANTIBOT[NAME]">

			<table class="bx-system-auth-table">
				<tbody>
				<tr>
					<td><?= GetMessage("AUTH_LOGIN_MIN") ?>:<span class="asterisk">*</span></td>
					<td>
						<input type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>"/>
					</td>
				</tr>
				<tr>
					<td><?= GetMessage("AUTH_PASSWORD_REQ") ?>:<span class="asterisk">*</span></td>
					<td><input type="password" name="USER_PASSWORD" maxlength="50"
					           value="<?= $arResult["USER_PASSWORD"] ?>" />
					</td>
				</tr>
				<tr>
					<td><?= GetMessage("AUTH_CONFIRM") ?>:<span class="asterisk">*</span></td>
					<td>
						<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50"
					           value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<?= GetMessage("AUTH_EMAIL") ?><? if ($arResult["EMAIL_REQUIRED"]): ?>:<span class="asterisk">*</span><? endif ?>
					</td>
					<td>
						<input type="text" name="USER_EMAIL" maxlength="255" value="<?= $arResult["USER_EMAIL"] ?>"/>
					</td>
				</tr>
				<tr>
					<td><?= GetMessage("AUTH_NAME") ?>:</td>
					<td>
						<input type="text" name="USER_NAME" maxlength="50" value="<?= $arResult["USER_NAME"] ?>"/>
					</td>
				</tr>
				<tr>
					<td><?= GetMessage("AUTH_LAST_NAME") ?>:</td>
					<td>
						<input type="text" name="USER_LAST_NAME" maxlength="50"
						       value="<?= $arResult["USER_LAST_NAME"] ?>"/>
					</td>
				</tr>
				<? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
					<tr>
						<td colspan="2"><?= strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?></td>
					</tr>
					<? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
						<tr>
							<td><? if ($arUserField["MANDATORY"] == "Y"): ?><span
									class="asterisk">*</span><?endif;
								?><?= $arUserField["EDIT_FORM_LABEL"] ?>:
							</td>
							<td>
								<? $APPLICATION->IncludeComponent(
									"bitrix:system.field.edit",
									$arUserField["USER_TYPE"]["USER_TYPE_ID"],
									array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS" => "Y")); ?></td>
						</tr>
					<? endforeach; ?>
				<? endif; ?>
				<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
					<tr>
						<td></td>
						<td>
							<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
							     width="180" height="40" alt="CAPTCHA"/>
						</td>
					</tr>
					<tr>
						<td><span class="asterisk">*</span><?= GetMessage("CAPTCHA_REGF_PROMT") ?>:</td>
						<td><input type="text" name="captcha_word" maxlength="50" value=""/></td>
					</tr>
				<?endif;?>
				</tbody>
				<tfoot>
				<tr>
					<td></td>
					<td><input type="submit" name="Register" value="<?= GetMessage("AUTH_REGISTER") ?>"/></td>
				</tr>
				</tfoot>
			</table>
			<br/>
			<div class="p">
				<noindex><a href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a></noindex>
			</div>
		</form>
	<? endif ?>
</div>