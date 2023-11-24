(function($) {
    "use strict"
    $( document ).ready(function () {
        var address = $('#address').text();
        var icon = $('#icon').val();
        var options = {
            text: address,
            width: 200,
            height: 200,
            logo: icon,
            logoWidth: 80,
            logoHeight: 80
        }
        new QRCode(document.getElementById('qr-code'), options);
    });
    $('#confirm').on('click', function (e) {
        e.preventDefault();
        $('#confirm').addClass('d-none');
        $('#loading').removeClass('d-none');
        var count = 0
        var txId = $('#payment-id').val();
        var success_url = $('#success-url').val();
        var check_url = $('#check-url').val();
        var intavo = setInterval(checkConf, 10000);
        function checkConf() {
            $.get(check_url, function (data) {
                if (data.error) {
                    console.log(data.message, 'unconfirmed')
                } else {
                    window.location.replace(success_url);
                }
            }).fail(function (data) {
                console.log(data.responseText);
            });

            if (++count === 3){
                clearInterval(intavo);
                $('#danger-man').removeClass('d-none');
                $('#confirm').removeClass('d-none');
                $('#loading').addClass('d-none');
            }
        }
    })
})(jQuery);
