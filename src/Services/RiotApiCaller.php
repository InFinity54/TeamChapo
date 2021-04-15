<?php
namespace App\Services;

use Exception;

class RiotApiCaller
{
    /**
     * @var string[][]
     */
    private $regions = [
        "BR" => [ "code" => "BR", "subdomain" => "br1", "group" => "AMERICAS", "name" => "Brésil" ],
        "EUNE" => [ "code" => "EUNE", "subdomain" => "eun1", "group" => "EUROPE", "name" => "Europe (Nord & Est)" ],
        "EUW" => [ "code" => "EUW", "subdomain" => "euw1", "group" => "EUROPE", "name" => "Europe (Ouest)" ],
        "JP" => [ "code" => "JP", "subdomain" => "jp1", "group" => "ASIA", "name" => "Japon" ],
        "KR" => [ "code" => "KR", "subdomain" => "kr", "group" => "ASIA", "name" => "République de Corée" ],
        "LAN" => [ "code" => "LAN", "subdomain" => "la1", "group" => "AMERICAS", "name" => "Amérique Latine (Nord)" ],
        "LAS" => [ "code" => "LAS", "subdomain" => "la2", "group" => "AMERICAS", "name" => "Amérique Latine (Sud)" ],
        "NA" => [ "code" => "NA", "subdomain" => "na1", "group" => "AMERICAS", "name" => "Amérique du Nord" ],
        "OCE" => [ "code" => "OCE", "subdomain" => "oc1", "group" => "AMERICAS", "name" => "Océanie" ],
        "RU" => [ "code" => "RU", "subdomain" => "ru", "group" => "EUROPE", "name" => "Russie" ],
        "TR" => [ "code" => "TR", "subdomain" => "tr1", "group" => "EUROPE", "name" => "Turquie" ]
    ];

    /**
     * @var string[][]
     */
    private $queues = [
        0 => [ 'id' => 0, 'description' => 'Personnalisé', 'playersNumber' => null, 'pickMode' => null ],
        2 => [ 'id' => 2, 'description' => 'Normal', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        4 => [ 'id' => 4, 'description' => 'Classé - Solo', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        6 => [ 'id' => 6, 'description' => 'Classé - Groupe', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        7 => [ 'id' => 7, 'description' => 'Coop VS IA', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        8 => [ 'id' => 8, 'description' => 'Normal', 'playersNumber' => '3v3', 'pickMode' => 'Aveugle' ],
        9 => [ 'id' => 9, 'description' => 'Classé - Flexible', 'playersNumber' => '3v3', 'pickMode' => 'Aveugle' ],
        14 => [ 'id' => 14, 'description' => 'Normal', 'playersNumber' => '5v5', 'pickMode' => 'Draft' ],
        16 => [ 'id' => 16, 'description' => 'Dominion', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        17 => [ 'id' => 17, 'description' => 'Dominion', 'playersNumber' => '5v5', 'pickMode' => 'Draft' ],
        25 => [ 'id' => 25, 'description' => 'Dominion - Coop VS IA', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        31 => [ 'id' => 31, 'description' => 'Coop VS IA - Intro', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        32 => [ 'id' => 32, 'description' => 'Coop VS IA - Débutant', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        33 => [ 'id' => 33, 'description' => 'Coop VS IA - Intermédiaire', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        41 => [ 'id' => 41, 'description' => 'Classé - Team', 'playersNumber' => '3v3', 'pickMode' => 'Aveugle' ],
        42 => [ 'id' => 42, 'description' => 'Classé - Team', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        52 => [ 'id' => 52, 'description' => 'Coop VS IA', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        61 => [ 'id' => 61, 'description' => 'Constructeur d\'équipe', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        65 => [ 'id' => 65, 'description' => 'ARAM', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        67 => [ 'id' => 67, 'description' => 'ARAM - Coop vs IA', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        70 => [ 'id' => 70, 'description' => 'Un pour Tous', 'playersNumber' => '5v5', 'pickMode' => 'Vote' ],
        72 => [ 'id' => 72, 'description' => 'Snowdown Showdown', 'playersNumber' => '1v1', 'pickMode' => 'Aveugle' ],
        73 => [ 'id' => 73, 'description' => 'Snowdown Showdown', 'playersNumber' => '2v2', 'pickMode' => 'Aveugle' ],
        75 => [ 'id' => 75, 'description' => 'Sextuplé', 'playersNumber' => '6v6', 'pickMode' => 'Aveugle' ],
        76 => [ 'id' => 76, 'description' => 'URF', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        78 => [ 'id' => 78, 'description' => 'Un pour Tous : Mode Miroir', 'playersNumber' => '5v5', 'pickMode' => 'Vote' ],
        83 => [ 'id' => 83, 'description' => 'URF - Coop VS IA', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        91 => [ 'id' => 91, 'description' => 'Bots du Chaos - Niveau 1', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        92 => [ 'id' => 92, 'description' => 'Bots du Chaos - Niveau 2', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        93 => [ 'id' => 93, 'description' => 'Bots du Chaos - Niveau 5', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        96 => [ 'id' => 96, 'description' => 'Ascension', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        98 => [ 'id' => 98, 'description' => 'Sextuplé', 'playersNumber' => '6v6', 'pickMode' => 'Aveugle' ],
        100 => [ 'id' => 100, 'description' => 'ARAM', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        300 => [ 'id' => 300, 'description' => 'Légende du Roi Poro', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        310 => [ 'id' => 310, 'description' => 'Draft des Némésis', 'playersNumber' => '5v5', 'pickMode' => 'Draft inversée' ],
        313 => [ 'id' => 313, 'description' => 'Black Market Brawlers', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        315 => [ 'id' => 315, 'description' => 'Siège du Nexus', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        317 => [ 'id' => 317, 'description' => 'Definitely Not Dominion', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        318 => [ 'id' => 318, 'description' => 'ARURF', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        325 => [ 'id' => 325, 'description' => 'All Random', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        400 => [ 'id' => 400, 'description' => 'Normal', 'playersNumber' => '5v5', 'pickMode' => 'Draft' ],
        410 => [ 'id' => 410, 'description' => 'Classé - Dynamique', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        420 => [ 'id' => 420, 'description' => 'Classé - Solo', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        430 => [ 'id' => 430, 'description' => 'Normal', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        440 => [ 'id' => 440, 'description' => 'Classé - Flexible', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        450 => [ 'id' => 450, 'description' => 'ARAM', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        460 => [ 'id' => 460, 'description' => 'Normal', 'playersNumber' => '3v3', 'pickMode' => 'Aveugle' ],
        470 => [ 'id' => 470, 'description' => 'Classé - Flexible', 'playersNumber' => '3v3', 'pickMode' => 'Aveugle' ],
        600 => [ 'id' => 600, 'description' => 'Traque de la Lune de Sang', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        610 => [ 'id' => 610, 'description' => 'Singularité du Pulsar Sombre', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        700 => [ 'id' => 700, 'description' => 'Clash', 'playersNumber' => '5v5', 'pickMode' => 'Draft de Tournoi' ],
        800 => [ 'id' => 800, 'description' => 'Coop VS IA - Intermédiaire', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        810 => [ 'id' => 810, 'description' => 'Co-op VS IA - Intro', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        820 => [ 'id' => 820, 'description' => 'Co-op VS IA - Débutant', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        830 => [ 'id' => 830, 'description' => 'Co-op VS IA - Intro', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        840 => [ 'id' => 840, 'description' => 'Co-op VS IA - Débutant', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        850 => [ 'id' => 850, 'description' => 'Co-op VS IA - Intermédiaire', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        900 => [ 'id' => 900, 'description' => 'URF', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        910 => [ 'id' => 910, 'description' => 'Ascension', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        920 => [ 'id' => 920, 'description' => 'Légende du Roi Poro', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        940 => [ 'id' => 940, 'description' => 'Siège du Nexus', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        950 => [ 'id' => 950, 'description' => 'Doom Bots - Difficulté par vote', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        960 => [ 'id' => 960, 'description' => 'Doom Bots - Normal', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        980 => [ 'id' => 980, 'description' => 'Gardiens des Étoiles - Invasion : Normal', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        990 => [ 'id' => 990, 'description' => 'Gardiens des Étoiles - Invasion : Massacre', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1000 => [ 'id' => 1000, 'description' => 'PROJET : Surcharge', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1010 => [ 'id' => 1010, 'description' => 'Bataille de boule de neige ARURF', 'playersNumber' => '5v5', 'pickMode' => 'Aléatoire' ],
        1020 => [ 'id' => 1020, 'description' => 'Un pour Tous', 'playersNumber' => '5v5', 'pickMode' => 'Vote' ],
        1030 => [ 'id' => 1030, 'description' => 'Odyssée : Extraction - Intro', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1040 => [ 'id' => 1040, 'description' => 'Odyssée : Extraction - Aspirant', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1050 => [ 'id' => 1050, 'description' => 'Odyssée : Extraction - Membre d\'équipage', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1060 => [ 'id' => 1060, 'description' => 'Odyssée : Extraction - Capitaine', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1070 => [ 'id' => 1070, 'description' => 'Odyssée : Extraction - Massacre', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1090 => [ 'id' => 1090, 'description' => 'Teamfight Tactics - Normal', 'playersNumber' => '1v7', 'pickMode' => null ],
        1100 => [ 'id' => 1100, 'description' => 'Teamfight Tactics - Classé', 'playersNumber' => '1v7', 'pickMode' => null ],
        1110 => [ 'id' => 1110, 'description' => 'Teamfight Tactics - Tutoriel', 'playersNumber' => '1v7', 'pickMode' => null ],
        1200 => [ 'id' => 1200, 'description' => 'Raid du Nexus', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        1300 => [ 'id' => 1300, 'description' => 'Raid du Nexus', 'playersNumber' => '5v5', 'pickMode' => 'Aveugle' ],
        2000 => [ 'id' => 2000, 'description' => 'Tutoriel (partie 1)', 'playersNumber' => '5v5', 'pickMode' => 'Choix limité en jeu' ],
        2010 => [ 'id' => 2010, 'description' => 'Tutoriel (partie 2)', 'playersNumber' => '5v5', 'pickMode' => 'Choix limité en jeu' ],
        2020 => [ 'id' => 2020, 'description' => 'Tutoriel (partie 3)', 'playersNumber' => '5v5', 'pickMode' => 'Choix limité en jeu' ]
    ];

    /**
     * @return string
     */
    private function getRiotApiKey(): string
    {
        return $_ENV["RIOTGAMES_APIKEY"];
    }

    /**
     * @param string|null $region
     * @return string[]|string[][]
     */
    public function getRegion(string $region = null): array
    {
        return ($region !== null) ? $this->regions[$region] : $this->regions;
    }

    /**
     * @param string $queue
     * @return string[][]
     */
    public function getQueue(string $queue): array
    {
        return $this->queues[$queue];
    }

    public function getAutorizedQueuesIDs(): array
    {
        $queues = [];

        foreach ($this->queues as $queue) {
            if ($queue["playersNumber"] === "5v5" && in_array($queue["description"], ["Classé - Flexible", "Clash"])) {
                $queues[] = $queue["id"];
            }
        }

        return $queues;
    }

    /**
     * @param string $api
     * @param string $method
     * @param string|null $urlParam
     * @param array $urlParam2
     * @return string
     * @throws Exception
     */
    private function generateUrlToCall(string $api, string $method, string $urlParam = null, array $urlParam2 = []): string
    {
        switch ($api)
        {
            case "summoner":
                switch ($method)
                {
                    case "name":
                        return "/lol/summoner/v4/summoners/by-name/" . $urlParam . "?api_key=" . $this->getRiotApiKey();
                    case "puuid":
                        return "/lol/summoner/v4/summoners/by-puuid/" . $urlParam . "?api_key=" . $this->getRiotApiKey();
                    case "accountId":
                        return "/lol/summoner/v4/summoners/by-account/" . $urlParam . "?api_key=" . $this->getRiotApiKey();
                    case "id":
                        return "/lol/summoner/v4/summoners/" . $urlParam . "?api_key=" . $this->getRiotApiKey();
                }
                break;
            case "match":
                switch ($method)
                {
                    case "single":
                        return "/lol/match/v5/matches/" . $urlParam . "?api_key=" . $this->getRiotApiKey();
                    case "all":
                        return "/lol/match/v5/matches/by-puuid/" . $urlParam . "/ids?start=" . $urlParam2["start"] . "&count=" . $urlParam2["count"] . "&api_key=" . $this->getRiotApiKey();
                    case "timeline":
                        return "/lol/match/v5/matches/" . $urlParam . "/timeline?api_key=" . $this->getRiotApiKey();
                }
                break;
        }

        throw new Exception("Unable to generate Riot API Request URL for the API « " . $api . " » with method « " . $method . " » and parameter « " . $urlParam . " ».", 500);
    }

    /**
     * @param string $region
     * @param string $api
     * @param string $method
     * @param array $urlParam
     * @return array|bool|string|null
     * @throws Exception
     */
    private function executeRequest(string $region, bool $useRegionGroup, string $api, string $method, string $urlParam = null, array $urlParam2 = []): array
    {
        $curl = curl_init();
        if ($useRegionGroup) {
            $domain = "https://" . $this->getRegion($region)["group"] . ".api.riotgames.com";
        } else {
            $domain = "https://" . $this->getRegion($region)["subdomain"] . ".api.riotgames.com";
        }
        $url = $this->generateUrlToCall($api, $method, $urlParam, $urlParam2);

        curl_setopt($curl, CURLOPT_URL, $domain . $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (isset($result["status"])) {
            $errorCode = (isset($result["status"]["status_code"])) ? (int) $result["status"]["status_code"] : 500;
            $errorMessage = (isset($result["status"]["message"])) ? $result["status"]["message"] : "Unknown error";

            throw new Exception("Error during execution of Riot API Request : " . $errorMessage, $errorCode);
        }

        return $result;
    }

    /**
     * @param string $region
     * @param string $summonerName
     * @return array
     * @throws Exception
     */
    public function getSummonerByName(string $region, string $summonerName): array
    {
        return $this->executeRequest($region, false, "summoner", "name", urlencode($summonerName));
    }

    /**
     * @param string $region
     * @param string $summonerAccountId
     * @param string $start
     * @param string $count
     * @return array
     * @throws Exception
     */
    public function getMatchlistFromSummoner(string $region, string $summonerAccountId, string $start, string $count): array
    {
        return $this->executeRequest($region, true, "match", "all", $summonerAccountId, [
            "start" => $start,
            "count" => $count
        ]);
    }

    /**
     * @param string $region
     * @param string $summonerName
     * @return array
     * @throws Exception
     */
    public function getMatchById(string $region, string $matchId): array
    {
        return $this->executeRequest($region, true, "match", "single", $matchId);
    }
}