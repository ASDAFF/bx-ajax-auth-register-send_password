� 2015 ����� ����������, ������-���� 
http://tuning-soft.ru/


��� ��������� ajax-����������� ������� � ������
http://tuning-soft.ru/articles/bitrix/ajax-form-authorization-and-registration-bitrix-jquery-ajax.html

� ���������� ����������� ������� �������, �� ��� �������, ����� �� ��������� � ������� ������� � ������
http://tuning-soft.ru/articles/bitrix/antibot-registration-on-the-website.html


================================================
��� ����������� ����� ������������ ��� ����������, ����� ������� �� ��� ���������������, �������� ��������� "������������� ������������"
<?//$APPLICATION->IncludeComponent("bitrix:system.auth.registration","",Array());?>

���� ������������ ��������� bitrix:main.register � ����� footer.php, �� � ����� auth.php ����� ���������� ������� ��� ���������,
����� ����� ������� �� ������ ����������� ����� ���������� ������ ���� � ����� ����� ajax-������.


================================================
�������, ��� ���������� ������� �� ����� ����� - ��� ���-�� ������� ����� �����������, ������ ��� uikit
<a href="#modal-login" class="uk-button uk-button-mini" data-uk-modal="">�����</a>

��� ��� ������ ���� ��������� ���� �� ������� � ����� fn.js, ��� ����� ���������� � ������� ������ �����, 
��� � ������� ��� ������, ����� ������ ���-�� �������� ����� ����������� �� ������, ������ ����.

=========================================================
	HTML-���� ��� ����� footer.php ������� �����
=========================================================
<!--modal-login-->
<div id="modal-login" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">�����������</div>
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
		<div class="uk-modal-footer">&copy; ����� ����������, ������-����</div>
	</div>
</div>
<!--//modal-login-->

<!--modal-register-->
<div id="modal-register" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">�����������</div>
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
		<div class="uk-modal-footer">&copy; ����� ����������, ������-����</div>
	</div>
</div>
<!--//modal-register-->

<!--modal-forgot-password-->
<div id="modal-forgot-password" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">�������������� ������</div>
		<div class="modal-content uk-text-center">
			<?$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd","",Array());?>
		</div>
		<div class="uk-modal-footer">&copy; ����� ����������, ������-����</div>
	</div>
</div>
<!--//modal-forgot-password-->