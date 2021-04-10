$("#password-form").validate({
    rules: {
        oldpassword: {
            required: true
        },
        newpassword: {
            required: true
        },
        confirmnewpassword: {
            required: true,
            equalTo: "#newpassword"
        }
    },
    errorClass: "is-invalid",
    validClass: "is-valid"
});