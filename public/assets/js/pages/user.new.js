$("#profile-form").validate({
    rules: {
        nickname: {
            required: true
        },
        email: {
            required: true,
            email: true
        },
        lane: {
            required: true
        }
    },
    errorClass: "is-invalid",
    validClass: "is-valid"
});