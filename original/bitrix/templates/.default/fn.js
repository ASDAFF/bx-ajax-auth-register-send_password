$(function(){

    //========================================
    //  auth modal
    //========================================
    //При загрузке страницы ссылкам форм подменяем атрибут href и добавляем data-атрибут для вызова модальных окон
    $('#modal-login a[href*="register"]').attr('href','#modal-register').attr('data-uk-modal','');
    $('#modal-login a[href*="forgot_password"]').attr('href','#modal-forgot-password').attr('data-uk-modal','');
    $('#modal-forgot-password a[href*="login"]').attr('href','#modal-login').attr('data-uk-modal','');
    $('#modal-register a[href*="login"]').attr('href','#modal-login').attr('data-uk-modal','');

    //Обработчик формы авторизации
    $('#modal-login').on('submit','form',function(){

        var form_action = $(this).attr('action');
        var form_backurl = $(this).find('input[name="backurl"]').val();

        $.ajax({
            type: "POST",
            url: '/bitrix/templates/2014/ajax/auth.php',
            data: $(this).serialize(),
            timeout: 3000,
            error: function(request,error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function(data) {
                $('#modal-login .modal-content').html(data);

                $('#modal-login form').attr('action',form_action);
                $('#modal-login input[name=backurl]').val(form_backurl);

                $('#modal-login a[href*="register"]').attr('href','#modal-register').attr('data-uk-modal','');
                $('#modal-login a[href*="forgot_password"]').attr('href','#modal-forgot-password').attr('data-uk-modal','');
            }
        });

        return false;
    });

    //Обработчик формы регистрации
    $('#modal-register').on('submit','form',function(){

        var form_action = $(this).attr('action');
        var form_backurl = $(this).find('input[name="backurl"]').val();

        $.ajax({
            type: "POST",
            url: '/bitrix/templates/2014/ajax/auth.php',
            data: $(this).serialize(),
            timeout: 3000,
            error: function(request,error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function(data) {
                $('#modal-register .modal-content').html(data);
                $('#modal-register form').attr('action',form_action);
                $('#modal-register input[name=backurl]').val(form_backurl);
                $('#modal-register a[href*="login"]').attr('href','#modal-login').attr('data-uk-modal','');
            }
        });

        return false;
    });

    //Обработчик формы восстановления пароля
    $('#modal-forgot-password').on('submit','form',function(){

        var form_action = $(this).attr('action');
        var form_backurl = $(this).find('input[name="backurl"]').val();

        $.ajax({
            type: "POST",
            url: '/bitrix/templates/2014/ajax/auth.php',
            data: $(this).serialize(),
            timeout: 3000,
            error: function(request,error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function(data) {
                $('#modal-forgot-password .modal-content').html(data);
                $('#modal-forgot-password form').attr('action',form_action);
                $('#modal-forgot-password input[name=backurl]').val(form_backurl);
                $('#modal-forgot-password a[href*="login"]').attr('href','#modal-login').attr('data-uk-modal','');
            }
        });

        return false;
    });

});