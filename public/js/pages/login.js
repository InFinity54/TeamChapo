$("#login-form").validate({
    rules: {
        nickname: {
            required: true
        },
        password: {
            required: true
        }
    },
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorClass: "is-invalid",
    validClass: "is-valid"
});