<?php
namespace App\Services;

class RiotDataDragonQuery
{
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @param int $id
     * @return string|null
     */
    public function getChampionNormalizedName(int $id): ?string
    {
        $champions = json_decode(file_get_contents($this->projectDir . "/public/riot/lol/latest/data/fr_FR/champion.json"), true)["data"];

        foreach ($champions as $champion) {
            if ($champion["key"] === (string) $id) {
                return $champion["id"];
            }
        }

        return null;
    }
}