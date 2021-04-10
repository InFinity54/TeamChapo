$("#passwordreset-form").validate({
    rules: {
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