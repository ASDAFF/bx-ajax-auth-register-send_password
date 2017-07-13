<?
if (!defined('PUBLIC_AJAX_MODE')) {
	define('PUBLIC_AJAX_MODE', true);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION, $USER;

switch($_REQUEST['TYPE'])
{
	case "SEND_PWD":
	{
		//Компонент с шаблоном errors выводит только ошибки
		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"errors",
			Array(
				"REGISTER_URL" => "",
				"FORGOT_PASSWORD_URL" => "",
				"PROFILE_URL" => "/personal/profile/",
				"SHOW_ERRORS" => "Y"
			)
		);
		$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd","",Array());
	}
		break;

	case "REGISTRATION":
	{
		//Компонент с шаблоном errors выводит только ошибки
		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"errors",
			Array(
				"REGISTER_URL" => "",
				"FORGOT_PASSWORD_URL" => "",
				"PROFILE_URL" => "/personal/profile/",
				"SHOW_ERRORS" => "Y"
			)
		);

		//Это компонент настраиваемой регистрации, либо используйте его (рекомендуется),
		//либо компонент bitrix:system.auth.registration
		$APPLICATION->IncludeComponent(
			"bitrix:main.register",
			"",
			Array(
				"SHOW_FIELDS" => array("EMAIL","NAME","LAST_NAME"),
				"REQUIRED_FIELDS" => array("EMAIL","NAME","LAST_NAME"),
				"AUTH" => "Y",
				"USE_BACKURL" => "Y",
				"SUCCESS_PAGE" => "",
				"SET_TITLE" => "N",
				"USER_PROPERTY" => array(),
				"USER_PROPERTY_NAME" => "",
			)
		);

		//Это простая регистрация, если импользуете ее, то выше компонент bitrix:main.register закомментируйте!
		//$APPLICATION->IncludeComponent("bitrix:system.auth.registration","",Array());


		//Если в настройках главного модуля отключено "Запрашивать подтверждение регистрации по E-mail"
		//и в настройках включена автоматическая авторизация после регистрации "AUTH" => "Y",
		//то пользователю будет показано это сообщение и страница перезагрузится,
		if($USER->IsAuthorized())
		{
			$APPLICATION->RestartBuffer();
			$backurl = $_REQUEST["backurl"] ? $_REQUEST["backurl"] : '/';

			//тут выводим любую информацию посетителю
			?>
			<p>Дорогой <b><?=$USER->GetFullName();?>!</b><br/>
				<span style="color: #008000;">Вы зарегистрированы и успешно вошли на сайт!</span>
			</p>
			<p>Сейчас страница автоматически перезагрузится и Вы сможете продолжить <br/>работу под своим именем.</p>
			<script>
				function TSRedirectUser(){
					window.location.href = '<?=$backurl;?>';
				}

				// - через 2 секунды перезагружаем страницу, чтобы вся страница знала, что посетитель авторизовался.
				// 1000 - это 1 секунда
				window.setTimeout('TSRedirectUser()',2000);
			</script>
		<?
		}
	}
		break;

	default:
	{
		//Вместо компонента system.auth.form можете использовать компонент system.auth.authorize,
		//но не забудьте поменять вызов компонента в HTML на аналогичный

		//$APPLICATION->IncludeComponent("bitrix:system.auth.authorize","",Array());
		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"",
			Array(
				"REGISTER_URL" => "",
				"FORGOT_PASSWORD_URL" => "",
				"PROFILE_URL" => "/personal/profile/",
				"SHOW_ERRORS" => "Y"
			)
		);


		//1. Если нужно показать какую-нибудь информацию об успешном входе на сайт и перезагрузить страницу
		if($USER->IsAuthorized())
		{
			//Если посетитель авторизовался/вошел на сайт под своим логином и паролем, необходимо сбросить буфер,
			//иначе у нас будет выводиться выше по коду HTML-код формы авторизованного посетителя
			$APPLICATION->RestartBuffer();
			$backurl = $_REQUEST["backurl"] ? $_REQUEST["backurl"] : '/';

			//тут выводим любую информацию посетителю
			?>
			<p>Дорогой <b><?=$USER->GetFullName();?>!</b><br/>
				<span style="color: #008000;">Вы зарегистрированы и успешно вошли на сайт!</span>
			</p>
			<p>Сейчас страница автоматически перезагрузится и Вы сможете продолжить <br/>работу под своим именем.</p>
			<script>
				function TSRedirectUser(){
					window.location.href = '<?=$backurl;?>';
				}

				//Через 2 секунды перезагружаем страницу, чтобы вся страница знала, что посетитель авторизовался.
				//1000 - это 1 секунда
				window.setTimeout('TSRedirectUser()',2000);
			</script>
		<?
		}

		//2. Если нужно показать форму авторизованного посетителя и никуда не перенаправлять,
		//то условие выше  if($USER->IsAuthorized()){...}  полностью закомментируйте

		//3. Если не нужно выводить никакую информацию после авторизации, а немедленно перезагрузить страницу,
		//тогда аналогичный код выше закомментируйте, а этот раскомментируйте.
		/*if($USER->IsAuthorized())
		{
			$APPLICATION->RestartBuffer();
			$backurl = $_REQUEST["backurl"] ? $_REQUEST["backurl"] : '/';
			?>
			<script>
				window.location.href = '<?=$backurl;?>';
			</script>
		<?
		}*/
	}
}