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