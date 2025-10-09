$(function(){
    $("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        transitionEffectSpeed: 300,
        labels: {
            next: "Continuer",
            previous: "Retour",
            finish: 'Valider'
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            // Afficher ou masquer le bouton "Back"


            // Mettre à jour les images d'étape
            if (newIndex >= 1) {
                $('.steps ul li:first-child a img').attr('src','/form/images/step-1.png');
            } else {
                $('.steps ul li:first-child a img').attr('src','/form/images/step-1-active.png');
            }

            if (newIndex === 1) {
                $('.steps ul li:nth-child(2) a img').attr('src','/form/images/step-2-active.png');
            } else {
                $('.steps ul li:nth-child(2) a img').attr('src','/form/images/step-2.png');
            }

            if (newIndex === 2) {
                $('.steps ul li:nth-child(3) a img').attr('src','/form/images/step-3-active.png');
            } else {
                $('.steps ul li:nth-child(3) a img').attr('src','/form/images/step-3.png');
            }

            if (newIndex === 3) {
                $('.steps ul li:nth-child(4) a img').attr('src','/form/images/step-4-active.png');
            } else {
                $('.steps ul li:nth-child(4) a img').attr('src','/form/images/step-4.png');
            }

            if (newIndex === 4) {
                $('.steps ul li:nth-child(5) a img').attr('src','/form/images/step-4-active.png');
                $('.actions ul').addClass('step-5');
            } else {
                $('.steps ul li:nth-child(5) a img').attr('src','/form/images/step-4.png');
                $('.actions ul').removeClass('step-5');
            }
            return true;
        }
    });

    // Custom Button Jquery Steps
    $('.forward').click(function(){
        $("#wizard").steps('next');
    })
    $('.backward').click(function(){
        $("#wizard").steps('previous');
    })

    // Create Steps Image and Text
    $('.steps ul li:first-child').append('<img src="/form/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="/form/images/step-1-active.png" alt="">').append('<span class="step-order">IDENTITE</span>');
    $('.steps ul li:nth-child(2)').append('<img src="/form/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="/form/images/step-2.png" alt="">').append('<span class="step-order">INFORMATIONS ACADEMIQUE</span>');
    $('.steps ul li:nth-child(3)').append('<img src="/form/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="/form/images/step-3.png" alt="">').append('<span class="step-order">DOCUMENT</span>');
    $('.steps ul li:nth-child(4)').append('<img src="/form/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="/form/images/step-4.png" alt="">').append('<span class="step-order">CHOIX DE FILIERE</span>');
    $('.steps ul li:nth-child(5)').append('<img src="/form/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="/form/images/step-4.png" alt="">').append('<span class="step-order">CONFIRMATION</span>');

    // Count input
    $(".quantity span").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();

        if ($button.hasClass('plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });
});
