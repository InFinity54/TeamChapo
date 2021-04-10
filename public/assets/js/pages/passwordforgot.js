$("#passwordforgot-form").validate({
    rules: {
        nickname: {
            required: true
        }
    },
    errorClass: "is-invalid",
    validClass: "is-valid"
});