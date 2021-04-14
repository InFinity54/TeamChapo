<?php
namespace App\Services;

use Exception;

class RiotApiCaller
{
    private $regions = [
        "BR" => [ "code" => "BR", "subdomain" => "br1", "name" => "Brésil" ],
        "EUNE" => [ "code" => "EUNE", "subdomain" => "eun1", "name" => "Europe (Nord & Est)" ],
        "EUW" => [ "code" => "EUW", "subdomain" => "euw1", "name" => "Europe (Ouest)" ],
        "JP" => [ "code" => "JP", "subdomain" => "jp1", "name" => "Japon" ],
        "KR" => [ "code" => "KR", "subdomain" => "kr", "name" => "République de Corée" ],
        "LAN" => [ "code" => "LAN", "subdomain" => "la1", "name" => "Amérique Latine (Nord)" ],
        "LAS" => [ "code" => "LAS", "subdomain" => "la2", "name" => "Amérique Latine (Sud)" ],
        "NA" => [ "code" => "NA", "subdomain" => "na1", "name" => "Amérique du Nord" ],
        "OCE" => [ "code" => "OCE", "subdomain" => "oc1", "name" => "Océanie" ],
        "RU" => [ "code" => "RU", "subdomain" => "ru", "name" => "Russie" ],
        "TR" => [ "code" => "TR", "subdomain" => "tr1", "name" => "Turquie" ]
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
    private function getRegion(string $region = null): array
    {
        return ($region !== null) ? $this->regions[$region] : $this->regions;
    }

    /**
     * @param string $api
     * @param string $method
     * @param string|null $urlParam
     * @return string
     * @throws Exception
     */
    private function generateUrlToCall(string $api, string $method, string $urlParam = null): string
    {
        switch ($api)
        {
            case "summoner":
                switch ($method)
                {
                    case "name":
                        return "/lol/summoner/v4/summoners/by-name/" . $urlParam;
                    case "puuid":
                        return "/lol/summoner/v4/summoners/by-puuid/" . $urlParam;
                    case "accountId":
                        return "/lol/summoner/v4/summoners/by-account/" . $urlParam;
                    case "id":
                        return "/lol/summoner/v4/summoners/" . $urlParam;
                }
                break;
        }

        throw new Exception("Unable to generate Riot API Request URL for the API « " . $api . " » with method « " . $method . " » and parameter « " . $urlParam . " ».", 500);
    }

    /**
     * @param string $region
     * @param string $api
     * @param string $method
     * @param string|null $urlParam
     * @return array|bool|string|null
     * @throws Exception
     */
    private function executeRequest(string $region, string $api, string $method, string $urlParam = null): array
    {
        $curl = curl_init();
        $domain = "https://" . $this->getRegion($region)["subdomain"] . ".api.riotgames.com";
        $url = $this->generateUrlToCall($api, $method, $urlParam);
        $auth = "?api_key=" . $this->getRiotApiKey();

        curl_setopt($curl, CURLOPT_URL, $domain . $url . $auth);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $output;
    }

    public function getSummonerByName(string $summonerName, string $region): array
    {
        return $this->executeRequest($region, "summoner", "name", $summonerName);
    }
}