$("#pool-form").validate({
    rules: {
        "primaryPool[]": {
            required: true
        },
        "secondaryPool[]": {
            required: true
        },
        "excludedPool[]": {
            required: true
        },
    },
    errorClass: "is-invalid",
    validClass: "is-valid"
});

const $selects = $(".poolSelect");

function disableAlreadySelectedChamps() {
    const selectedValue = [];

    $selects.find(':selected').filter(function(idx, el) {
        return $(el).attr('value');
    }).each(function(idx, el) {
        selectedValue.push($(el).attr('value'));
    });

    $selects.find('option').each(function(idx, option) {
        if (selectedValue.indexOf($(option).attr('value')) > -1) {
            if ($(option).is(':checked')) {
                return;
            } else {
                $(this).attr('disabled', true);
            }
        } else {
            $(this).attr('disabled', false);
        }
    });

    $('.selectpicker').selectpicker('refresh');
}

$selects.on('change', function (evt) {
    disableAlreadySelectedChamps();
});

disableAlreadySelectedChamps();