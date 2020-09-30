$("#loginForm").submit(function(event) {

    event.preventDefault();

    

     $.ajax({

            type: "POST",

            url: "handler.php",

            datatype : "script",            

            data: {action: "login", address: document.getElementById("btc-address").value},

            success: function(msg) {

                if(msg=="success"){

                    $('.modal-content').css('background', '#104e46e8');

                    $('#modal-text').text("Your BTC address saved.");

                    $('#modal').modal('show');

                    if (document.getElementById("redirect").value==1) {

                        window.location = "/account";

                    }

                }else{

                    $('.modal-content').css('background', '#501b1bed');

                    $('#modal-text').text(msg);

                    $('#modal').modal('show');

                }

            }

    });

});

$("#withdrawForm").submit(function(event) {

    event.preventDefault();

    var address = $("#btc_address").val();

     $.ajax({

            type: "POST",

            url: "handler.php",

            datatype : "script",            

            data: {action: "withdraw", address: address},

            success: function(msg) {

                if(msg=="success"){

                    $('.modal-content').css('background', '#104e46e8');

                    $('#modal-text').text("Your balance sent to your FaucetHub address ;)");

                    $('#modal').modal('show');

                    setTimeout(function(){window.location = "/account";}, 900);



                    

                }else{

                    $('.modal-content').css('background', '#501b1bed');

                    $('#modal-text').text(msg);

                    $('#modal').modal('show');

                }

                

            }

    });

});



$(document).on('click', 'a[href^="#"]', function (event) {

    event.preventDefault();



    $('html, body').animate({

        scrollTop: $($.attr(this, 'href')).offset().top

    }, 500);

});



$( document ).ready(function() {

    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {

        function decode(s) {

            return decodeURIComponent(s.split("+").join(" "));

        }

    

        $_GET[decode(arguments[1])] = decode(arguments[2]);

    });

    console.log($_GET);

    if (typeof $_GET["action"] !== 'undefined'){

        location.replace(document.referrer);

    }

});



