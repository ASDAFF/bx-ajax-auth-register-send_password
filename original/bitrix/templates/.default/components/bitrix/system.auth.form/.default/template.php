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
<div class="bx-system-auth-form">
	<?
	if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
		ShowMessage($arResult['ERROR_MESSAGE']);
	?>
	<? if ($arResult["FORM_TYPE"] == "login"): ?>
		<form name="system_auth_form<?= $arResult["RND"] ?>" method="post" action="<?= $arResult["AUTH_URL"] ?>">
			<?if ($arResult["BACKURL"] <> ''): ?>
				<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
			<?endif ?>
			<?foreach ($arResult["POST"] as $key => $value): ?>
				<input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
			<?endforeach ?>
			<?if ($arResult["STORE_PASSWORD"] == "Y"): ?>
				<input type="hidden" name="USER_REMEMBER" value="Y">
			<?endif ?>
			<input type="hidden" name="AUTH_FORM" value="Y"/>
			<input type="hidden" name="TYPE" value="AUTH"/>

			<table class="bx-system-auth-table">
				<tbody>
				<tr>
					<td><?= GetMessage("AUTH_LOGIN") ?>:</td>
					<td>
						<input type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>" size="17"/>
					</td>
				</tr>
				<tr>
					<td><?= GetMessage("AUTH_PASSWORD") ?>:</td>
					<td>
						<input type="password" name="USER_PASSWORD" maxlength="50" size="17"/>
					</td>
				</tr>
				<?if ($arResult["CAPTCHA_CODE"]): ?>
					<tr>
						<td><?echo GetMessage("AUTH_CAPTCHA_PROMT") ?>:</td>
						<td>
							<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"] ?>"/>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"] ?>"
							     width="180" height="40" alt="CAPTCHA"/><br/>
							<input type="text" name="captcha_word" maxlength="50" value=""/></td>
					</tr>
				<?endif ?>
				<tr>
					<td></td>
					<td>
						<button type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"><?= GetMessage("AUTH_LOGIN_BUTTON") ?></button>
					</td>
				</tr>
				</tbody>
			</table>

			<br/>
			<noindex><a href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"] ?>"  rel="nofollow"><?= GetMessage("AUTH_FORGOT_PASSWORD_2") ?></a></noindex>
			<br/>
			<?if ($arResult["NEW_USER_REGISTRATION"] == "Y"): ?>
				<noindex><a href="<?= $arResult["AUTH_REGISTER_URL"] ?>"  rel="nofollow"><?= GetMessage("AUTH_REGISTER") ?></a></noindex>
			<?endif ?>
			<br/>

			<?if ($arResult["AUTH_SERVICES"]): ?>
				<div class="bx-auth-service">
					<div class="bx-auth-lbl"><?= GetMessage("socserv_as_user_form") ?></div>
					<?
					$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
						array(
							"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
							"SUFFIX"        => "form",
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);
					?>
				</div>
			<?endif ?>
		</form>
		<?if ($arResult["AUTH_SERVICES"]): ?>
			<?
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
				array(
					"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
					"AUTH_URL"      => $arResult["AUTH_URL"],
					"POST"          => $arResult["POST"],
					"POPUP"         => "Y",
					"SUFFIX"        => "form",
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
		<?endif ?>
	<?
	elseif ($arResult["FORM_TYPE"] == "otp"):
	?>
		<form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
		      action="<?= $arResult["AUTH_URL"] ?>">
			<?if ($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
			<?endif?>
			<input type="hidden" name="AUTH_FORM" value="Y"/>
			<input type="hidden" name="TYPE" value="OTP"/>
			<table width="95%">
				<tr>
					<td colspan="2">
						<?echo GetMessage("auth_form_comp_otp")?><br/>
						<input type="text" name="USER_OTP" maxlength="50" value="" size="17" autocomplete="off"/></td>
				</tr>
				<?if ($arResult["CAPTCHA_CODE"]):?>
					<tr>
						<td colspan="2">
							<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br/>
							<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>"/>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>"
							     width="180" height="40" alt="CAPTCHA"/><br/><br/>
							<input type="text" name="captcha_word" maxlength="50" value=""/></td>
					</tr>
				<?endif?>
				<?if ($arResult["REMEMBER_OTP"] == "Y"):?>
					<tr>
						<td valign="top"><input type="checkbox" id="OTP_REMEMBER_frm" name="OTP_REMEMBER" value="Y"/>
						</td>
						<td width="100%"><label for="OTP_REMEMBER_frm"
						                        title="<?echo GetMessage("auth_form_comp_otp_remember_title")?>"><?echo GetMessage("auth_form_comp_otp_remember")?></label>
						</td>
					</tr>
				<?endif?>
				<tr>
					<td colspan="2"><input type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<noindex><a href="<?= $arResult["AUTH_LOGIN_URL"] ?>"
						            rel="nofollow"><?echo GetMessage("auth_form_comp_auth")?></a></noindex>
						<br/></td>
				</tr>
			</table>
		</form>
	<?
	else:
	?>
		<form action="<?= $arResult["AUTH_URL"] ?>">
			<table width="95%">
				<tr>
					<td align="center">
						<?= $arResult["USER_NAME"] ?><br/>
						[<?= $arResult["USER_LOGIN"] ?>]<br/>
						<a href="<?= $arResult["PROFILE_URL"] ?>"
						   title="<?= GetMessage("AUTH_PROFILE") ?>"><?= GetMessage("AUTH_PROFILE") ?></a><br/>
					</td>
				</tr>
				<tr>
					<td align="center">
						<? foreach ($arResult["GET"] as $key => $value):?>
							<input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
						<? endforeach?>
						<input type="hidden" name="logout" value="yes"/>
						<input type="submit" name="logout_butt" value="<?= GetMessage("AUTH_LOGOUT_BUTTON") ?>"/>
					</td>
				</tr>
			</table>
		</form>
	<? endif ?>
</div>
