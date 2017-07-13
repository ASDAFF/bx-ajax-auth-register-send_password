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
<div class="bx-main-register">
	<? if ($USER->IsAuthorized()): ?>
		<div class="p"><? ShowNote(GetMessage("MAIN_REGISTER_AUTH")) ?></div>
	<? else: ?>
		<?
		if (count($arResult["ERRORS"]) > 0):
			foreach ($arResult["ERRORS"] as $key => $error)
				if (intval($key) == 0 && $key !== 0)
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".strip_tags(GetMessage("REGISTER_FIELD_".$key))."&quot;", $error);

			ShowError(implode("<br />", $arResult["ERRORS"]));

		elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && strlen($_REQUEST['register_submit_button'])):
		?>
			<div class="p"><? ShowNote(GetMessage("REGISTER_EMAIL_WILL_BE_SENT"))?></div>
			<?$arResult["VALUES"] = array();?>
		<? endif ?>
		<form method="POST" action="<?= POST_FORM_ACTION_URI ?>" name="regform">
			<?if ($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
			<?endif;?>
			<input type="hidden" name="TYPE" value="REGISTRATION"/>
			<input type="hidden" name="register_submit_button" value="Y"/>
			<input type="text" class="api-mf-antibot" value="" name="ANTIBOT[NAME]">
			<table class="bx-system-auth-table">
				<tbody>
				<? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
					<? if ($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true): ?>
						<tr>
							<td><? echo GetMessage("main_profile_time_zones_auto") ?>:<? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?><span class="asterisk">*</span><? endif ?></td>
							<td>
								<select name="REGISTER[AUTO_TIME_ZONE]"
								        onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
									<option value=""><? echo GetMessage("main_profile_time_zones_auto_def") ?></option>
									<option
										value="Y"<?= $arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : "" ?>><? echo GetMessage("main_profile_time_zones_auto_yes") ?></option>
									<option
										value="N"<?= $arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : "" ?>><? echo GetMessage("main_profile_time_zones_auto_no") ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td><? echo GetMessage("main_profile_time_zones_zones") ?>:</td>
							<td>
								<select name="REGISTER[TIME_ZONE]"<? if (!isset($_REQUEST["REGISTER"]["TIME_ZONE"]))	echo 'disabled="disabled"' ?>>
									<? foreach ($arResult["TIME_ZONE_LIST"] as $tz => $tz_name): ?>
										<option		value="<?= htmlspecialcharsbx($tz) ?>"<?= $arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : "" ?>><?= htmlspecialcharsbx($tz_name) ?></option>
									<? endforeach ?>
								</select>
							</td>
						</tr>
					<? else: ?>
						<tr>
							<td><?= GetMessage("REGISTER_FIELD_".$FIELD) ?>:<? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?><span	class="asterisk">*</span><? endif ?></td>
							<td><?
								switch ($FIELD)
								{
									case "PASSWORD":
										?><input size="30" type="password" name="REGISTER[<?= $FIELD ?>]"
										         value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off"
										         class="bx-auth-input"/>
										<?
										break;
									case "CONFIRM_PASSWORD":
										?><input size="30" type="password" name="REGISTER[<?= $FIELD ?>]"
										         value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off" /><?
										break;

									case "PERSONAL_GENDER":
										?><select name="REGISTER[<?= $FIELD ?>]">
										<option value=""><?= GetMessage("USER_DONT_KNOW") ?></option>
										<option
											value="M"<?= $arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_MALE") ?></option>
										<option
											value="F"<?= $arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_FEMALE") ?></option>
										</select><?
										break;

									case "PERSONAL_COUNTRY":
									case "WORK_COUNTRY":
										?><select name="REGISTER[<?= $FIELD ?>]"><?
										foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
										{
											?>
											<option value="<?= $value ?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?= $arResult["COUNTRIES"]["reference"][$key] ?></option>
										<?
										}
										?></select><?
										break;

									case "PERSONAL_PHOTO":
									case "WORK_LOGO":
										?><input size="30" type="file" name="REGISTER_FILES_<?= $FIELD ?>" /><?
										break;

									case "PERSONAL_NOTES":
									case "WORK_NOTES":
										?><textarea cols="30" rows="5"
										            name="REGISTER[<?= $FIELD ?>]"><?= $arResult["VALUES"][$FIELD] ?></textarea><?
										break;
									default:
										if ($FIELD == "PERSONAL_BIRTHDAY"):?>
											<small><?= $arResult["DATE_FORMAT"] ?></small><br/><?endif;
										?><input size="30" type="text" name="REGISTER[<?= $FIELD ?>]"
										         value="<?= $arResult["VALUES"][$FIELD] ?>" /><?
										if ($FIELD == "PERSONAL_BIRTHDAY")
											$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'SHOW_INPUT' => 'N',
													'FORM_NAME'  => 'regform',
													'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
													'SHOW_TIME'  => 'N'
												),
												null,
												array("HIDE_ICONS" => "Y")
											);
										?><?
								} ?></td>
						</tr>
					<? endif ?>
				<? endforeach ?>

				<? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
					<tr>
						<td colspan="2"><?= strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?></td>
					</tr>
					<? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
						<tr>
							<td><?= $arUserField["EDIT_FORM_LABEL"] ?>:<? if ($arUserField["MANDATORY"] == "Y"): ?><span	class="asterisk">*</span><? endif; ?></td>
							<td>
								<? $APPLICATION->IncludeComponent(
									"bitrix:system.field.edit",
									$arUserField["USER_TYPE"]["USER_TYPE_ID"],
									array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y")); ?></td>
						</tr>
					<? endforeach; ?>
				<? endif; ?>

				<?
				if ($arResult["USE_CAPTCHA"] == "Y"):?>
					<tr>
						<td></td>
						<td>
							<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
							     width="180" height="40" alt="CAPTCHA"/>
						</td>
					</tr>
					<tr>
						<td><?= GetMessage("REGISTER_CAPTCHA_PROMT") ?>:<span class="asterisk">*</span></td>
						<td><input type="text" name="captcha_word" maxlength="50" value=""/></td>
					</tr>
				<?endif;?>
				</tbody>
				<tfoot>
				<tr>
					<td></td>
					<td>
						<button type="submit" name="register_submit_button" value="<?= GetMessage("AUTH_REGISTER") ?>"><?= GetMessage("AUTH_REGISTER") ?></button>
					</td>
				</tr>
				</tfoot>
			</table>
			<br/>
			<div class="p">
				<noindex><a href="?login=yes" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a></noindex>
			</div>
		</form>
	<? endif ?>
</div>