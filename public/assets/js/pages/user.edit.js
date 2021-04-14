$("#edituser-form").validate({
    rules: {
        nickname: {
            required: true
        },
        email: {
            required: true,
            email: true
        },
        puuid: {
            required: false
        },
        accountId: {
            required: false
        },
        picture: {
            required: false
        },
        lane: {
            required: true
        }
    },
    errorClass: "is-invalid",
    validClass: "is-valid"
});

$('#picture').dropify({
    messages: {
        'default': 'Glisse un fichier dans la zone ou clique pour sélectionner une image.',
        'replace': 'Glisse un fichier dans la zone ou clique pour sélectionner une nouvelle image.',
        'remove':  'Supprimer',
        'error':   'Une erreur est survenue.'
    },
    error: {
        'fileSize': 'Le fichier ne doit pas faire plus de {{ value }}.',
        'minWidth': 'L\'image doit faire au moins {{ value }}} pixels de large.',
        'maxWidth': 'L\'image doit faire maximum {{ value }}} pixels de large.',
        'minHeight': 'L\'image doit faire au moins {{ value }}} pixels de hauteur.',
        'maxHeight': 'L\'image doit faire maximum {{ value }}} pixels de hauteur.',
        'imageFormat': 'Seuls les formats de fichiers suivants sont acceptés : {{ value }}.'
    }
});