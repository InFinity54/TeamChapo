const progressBar = $("#gamesRefreshProgressBar");
const progressLog = $("#gamesRefreshProgressLog");

let userId = "";
let riotAccountId = "";
let riotId = "";
let riotPuuid = "";
let gamesToRetrieve = [];
let gamesToSkip = [];

function changeProgressValue(newValue) {
    progressBar.attr("aria-valuenow", newValue);
    progressBar.html(newValue + "%");
    progressBar.css("width", newValue + "%");
}

function appendToProgressLog(html) {
    progressLog.append(html);
    progressLog.animate({scrollTop: progressLog.prop("scrollHeight")}, 300);
}

function retrieveUserId() {
    userId = progressLog.data("user-id");
}

function retrieveRiotIds() {
    appendToProgressLog(`<p>Récupération des identifiants Riot Games...</p>`);
    retrieveUserId();

    try {
        $.ajax({
            url: Routing.generate('api_users_riotids', { id: userId }),
            type: "GET",
            dataType: "json",
            success: function (data) {
                riotAccountId = data.riotAccountId;
                riotId = data.riotId;
                riotPuuid = data.riotPuuid;

                appendToProgressLog(`<p class="text-success">Identifiants Riot Games récupérés.</p>`);
                changeProgressValue(33);

                retrieveGamesList(0, 100);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                appendToProgressLog(`<p class="text-danger">Erreur lors de la récupération des identifiants Riot Games.</p>`);
                progressBar.removeClass("progress-bar-striped");
                progressBar.removeClass("progress-bar-animated");
                changeProgressValue(100);
                console.error(errorThrown);
            }
        });
    } catch (error) {
        appendToProgressLog(`<p class="text-danger">Erreur lors de la récupération des identifiants Riot Games.</p>`);
        progressBar.removeClass("progress-bar-striped");
        progressBar.removeClass("progress-bar-animated");
        changeProgressValue(100);
        console.error(error);
    }
}

function retrieveGamesList(start = 0, recursive = false) {
    if (!recursive) {
        appendToProgressLog(`<p>Détection des parties disponibles sur les serveurs de Riot Games...</p>`);
    }

    try {
        $.ajax({
            url: Routing.generate('api_riot_games_get', { start: start, count: 100 }),
            type: "GET",
            data: {
                puuid: riotPuuid
            },
            dataType: "json",
            success: function (data) {
                if (data.hasGames === true) {
                    for (let i = 0; i < data.matches.length; i++) {
                        gamesToRetrieve.push(data.matches[i]);
                    }

                    retrieveGamesList(start + 100, 100, true);
                } else {
                    appendToProgressLog(`<p class="text-info">Un maximum de ` + gamesToRetrieve.length.toString() + ` parties peuvent être récupérées.</p>`);
                    retrieveGames();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                appendToProgressLog(`<p class="text-danger">Erreur lors du calcul du nombre de parties disponibles.</p>`);
                progressBar.removeClass("progress-bar-striped");
                progressBar.removeClass("progress-bar-animated");
                changeProgressValue(100);
                console.error(errorThrown);
            }
        });
    } catch (error) {
        appendToProgressLog(`<p class="text-danger">Erreur lors du calcul du nombre de parties disponibles.</p>`);
        progressBar.removeClass("progress-bar-striped");
        progressBar.removeClass("progress-bar-animated");
        changeProgressValue(100);
        console.error(error);
    }
}

function retrieveGames(i = 0) {
    try {
        if (i < gamesToRetrieve.length) {
            $.ajax({
                url: Routing.generate('api_games_isexist', { id: gamesToRetrieve[i] }),
                type: "GET",
                sync: true,
                dataType: "json",
                success: function (data) {
                    appendToProgressLog(`<p>Vérification de l'existence de la partie ` + gamesToRetrieve[i] + ` dans la base de données...</p>`);

                    if (data.isExist === false) {
                        appendToProgressLog(`<p>Partie ` + gamesToRetrieve[i] + ` introuvable dans la base de données.</p>`);
                        appendToProgressLog(`<p>Récupération de la partie ` + gamesToRetrieve[i] + ` depuis les serveurs de Riot Games...</p>`);

                        $.ajax({
                            url: Routing.generate('api_riot_game', { id: gamesToRetrieve[i] }),
                            type: "GET",
                            dataType: "json",
                            success: function (dataGame) {
                                appendToProgressLog(`<p>Vérification de la partie ` + gamesToRetrieve[i] + ` les serveurs de Riot Games...</p>`);

                                if (dataGame.isValid === true) {
                                    appendToProgressLog(`<p>Enregistrement de la partie ` + gamesToRetrieve[i] + ` dans la base de données...</p>`);

                                    $.ajax({
                                        url: Routing.generate('api_games_save', { id: gamesToRetrieve[i] }),
                                        type: "POST",
                                        data: {
                                            gameData: JSON.stringify(dataGame)
                                        },
                                        dataType: "json",
                                        success: function (dataSave) {
                                            if (dataSave.code === 200) {
                                                appendToProgressLog(`<p class="text-success">Partie ` + gamesToRetrieve[i] + ` enregistrée en base de données.</p>`);
                                                changeProgressValue(Math.round(33 + (i / gamesToRetrieve.length * 100 / 3)));
                                                addedGames++;
                                                retrieveGames(i + 1);
                                            } else {
                                                appendToProgressLog(`<p class="text-danger">Erreur pendant l'enregistrement de la partie ` + gamesToRetrieve[i] + ` en base de données.</p>`);
                                                console.error(dataSave.message);
                                            }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            if (errorThrown === "Rate Limit Exceeded") {
                                                setTimeout(() => {
                                                    retrieveGames(i);
                                                }, jqXHR.getResponseHeader('Retry-After'));
                                            } else if (errorThrown === "Bad Gateway") {
                                                setTimeout(() => {
                                                    retrieveGames(i);
                                                }, 60000);
                                            } else {
                                                appendToProgressLog(`<p class="text-danger">Erreur lors de la récupération de la partie ` + gamesToRetrieve[i] + `.</p>`);
                                                progressBar.removeClass("progress-bar-striped");
                                                progressBar.removeClass("progress-bar-animated");
                                                changeProgressValue(100);
                                                console.error(errorThrown);
                                            }
                                        }
                                    });
                                } else {
                                    appendToProgressLog(`<p class="text-warning">Partie ` + gamesToRetrieve[i] + ` passée : un ou plusieurs joueurs de l'équipe sont absents.</p>`);
                                    gamesToSkip.push(gamesToRetrieve[i]);
                                    changeProgressValue(Math.round(33 + (i / gamesToRetrieve.length * 100 / 3)));
                                    retrieveGames(i + 1);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                if (errorThrown === "Rate Limit Exceeded") {
                                    appendToProgressLog(`<p class="text-warning">La limite d'utilisation de l'API de Riot Games a été atteinte. Attente avant nouvel essai...</p>`);

                                    setTimeout(() => {
                                        retrieveGames(i);
                                    }, 60000);
                                } else if (errorThrown === "Bad Gateway") {
                                    appendToProgressLog(`<p class="text-warning">La limite d'utilisation de l'API de Riot Games a été atteinte. Attente avant nouvel essai...</p>`);

                                    setTimeout(() => {
                                        retrieveGames(i);
                                    }, 60000);
                                } else {
                                    appendToProgressLog(`<p class="text-danger">Erreur lors de la récupération de la partie ` + gamesToRetrieve[i] + `.</p>`);
                                    progressBar.removeClass("progress-bar-striped");
                                    progressBar.removeClass("progress-bar-animated");
                                    changeProgressValue(100);
                                    console.error(errorThrown);
                                }
                            }
                        });
                    } else {
                        appendToProgressLog(`<p class="text-warning">Partie ` + gamesToRetrieve[i] + ` passée : partie déjà sauvegardée dans la base de données.</p>`);
                        gamesToSkip.push(gamesToRetrieve[i]);
                        changeProgressValue(Math.round(33 + (i / gamesToRetrieve.length * 100 / 3)));
                        retrieveGames(i + 1);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    appendToProgressLog(`<p class="text-danger">Erreur lors de la récupération de la partie ` + gamesToRetrieve[i] + `.</p>`);
                    changeProgressValue(100);
                    console.error(errorThrown);
                }
            });
        } else {
            changeProgressValue(66);
            registerSkippedGames();
        }
    } catch (error) {
        appendToProgressLog(`<p class="text-danger">Erreur lors de la récupération de la partie ` + gamesToRetrieve[i] + `.</p>`);
        progressBar.removeClass("progress-bar-striped");
        progressBar.removeClass("progress-bar-animated");
        changeProgressValue(100);
        console.error(error);
    }
}

function registerSkippedGames(i = 0) {
    try {
        if (i < gamesToSkip.length) {
            appendToProgressLog(`<p>Enregistrement de la partie ` + gamesToSkip[i] + ` pour exclusion des prochaines mises à jour...</p>`);

            $.ajax({
                url: Routing.generate('api_games_saveexclude', { id: gamesToSkip[i] }),
                type: "GET",
                sync: true,
                dataType: "json",
                success: function (data) {
                    changeProgressValue(Math.round(66 + (i / gamesToSkip.length * 100 / 3)));
                    registerSkippedGames(i + 1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    appendToProgressLog(`<p class="text-danger">Erreur lors de l'enregistrement de la partie ` + gamesToSkip[i] + ` pour exclusion.</p>`);
                    changeProgressValue(100);
                    console.error(errorThrown);
                }
            });
        } else {
            appendToProgressLog(`<p class="text-success">Traitement des parties terminées.</p>`);
            appendToProgressLog(`<p class="text-success font-weight-bold">La mise à jour de l'historique de parties est terminée.</p>`);
            progressBar.removeClass("progress-bar-striped");
            progressBar.removeClass("progress-bar-animated");
            changeProgressValue(100);
        }
    } catch (error) {
        appendToProgressLog(`<p class="text-danger">Erreur lors de l'enregistrement de la partie ` + gamesToSkip[i] + ` pour exclusion.</p>`);
        progressBar.removeClass("progress-bar-striped");
        progressBar.removeClass("progress-bar-animated");
        changeProgressValue(100);
        console.error(error);
    }
}

$(document).ready(function() {
    progressLog.html(`<div class="alert alert-info">L'actualisation de l'historique de parties va démarrer dans 3 secondes...</div>`);

    setTimeout(() => {
        progressLog.html(`<div class="alert alert-info">L'actualisation de l'historique de parties va démarrer dans 2 secondes...</div>`);
    }, 1000);

    setTimeout(() => {
        progressLog.html(`<div class="alert alert-info">L'actualisation de l'historique de parties va démarrer dans 1 seconde...</div>`);
    }, 2000);

    setTimeout(() => {
        progressLog.html("");
        progressLog.removeClass("overflow-hidden");
        progressLog.removeClass("h-auto");
        retrieveRiotIds();
    }, 3000);
});