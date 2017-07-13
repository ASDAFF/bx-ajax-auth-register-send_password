© 2015 Антон Кучковский, Тюнинг-Софт 
http://tuning-soft.ru/


Как настроить ajax-регистрацию читайте в статье
http://tuning-soft.ru/articles/bitrix/ajax-form-authorization-and-registration-bitrix-jquery-ajax.html

В компоненты регистрации встроен Антибот, но как сделать, чтобы он заработал в Битрикс читайте в статье
http://tuning-soft.ru/articles/bitrix/antibot-registration-on-the-website.html


================================================
Для регистрации можно использовать два компонента, самый простой из них закомментирован, работает компонент "Настраиваемая регистрациия"
<?//$APPLICATION->IncludeComponent("bitrix:system.auth.registration","",Array());?>

Если настраиваете компонент bitrix:main.register в файле footer.php, то в файле auth.php также необходимо сделать его настройку,
иначе после нажатия на кнопку Регистрация будут выводиться другие поля в форме после ajax-ответа.


================================================
Минимум, что необходимо сделать на вашем сайте - это как-то вызвать форму авторизации, пример для uikit
<a href="#modal-login" class="uk-button uk-button-mini" data-uk-modal="">Войти</a>

Код для показа всех остальных форм по ссылкам в файле fn.js, его нужно подключить к шаблону вашего сайта, 
там в принице все готово, нужно только как-то вызывать форму авторизации по кнопке, пример выше.

=========================================================
	HTML-форм для файла footer.php шаблона сайта
=========================================================
<!--modal-login-->
<div id="modal-login" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">Авторизация</div>
		<div class="modal-content uk-text-center">
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form",
				"",
				Array(
					"REGISTER_URL" => "",
					"FORGOT_PASSWORD_URL" => "",
					"PROFILE_URL" => "/personal/profile/",
					"SHOW_ERRORS" => "Y"
				)
			);?>
		</div>
		<div class="uk-modal-footer">&copy; Антон Кучковский, Тюнинг-Софт</div>
	</div>
</div>
<!--//modal-login-->

<!--modal-register-->
<div id="modal-register" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">Регистрация</div>
		<div class="modal-content uk-text-center">
			<?//$APPLICATION->IncludeComponent("bitrix:system.auth.registration","",Array());?>
			<?$APPLICATION->IncludeComponent(
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
					"USER_PROPERTY_NAME" => ""
				)
			);?>
		</div>
		<div class="uk-modal-footer">&copy; Антон Кучковский, Тюнинг-Софт</div>
	</div>
</div>
<!--//modal-register-->

<!--modal-forgot-password-->
<div id="modal-forgot-password" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">Восстановление пароля</div>
		<div class="modal-content uk-text-center">
			<?$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd","",Array());?>
		</div>
		<div class="uk-modal-footer">&copy; Антон Кучковский, Тюнинг-Софт</div>
	</div>
</div>
<!--//modal-forgot-password-->