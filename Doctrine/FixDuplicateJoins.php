<?php

    private function fixDuplicateJoins(QueryBuilder $queryBuilder)
    {
        $joins = $this->getJoins($queryBuilder);
        $uniqueJoins = array_unique($joins);
        $this->setJoins($queryBuilder, $uniqueJoins);
    }

    private function getJoins(QueryBuilder $queryBuilder): array
    {
        $joinPartsInAliases = $queryBuilder->getDQLPart('join');
        if(!array_key_exists($this->getAlias(), $joinPartsInAliases)){
            return [];
        }

        $joins = [];
        $joinParts = $joinPartsInAliases[$this->getAlias()];
        foreach ($joinParts as $joinPart) {
            $joins[$joinPart->getAlias()] = $joinPart;
        }
        return $joins;
    }

    private function setJoins(QueryBuilder $queryBuilder, array $joins)
    {
        $queryBuilder->resetDQLPart('join');
        $joins = array_values($joins);
        foreach ($joins as $key => $join) {
            $queryBuilder->add('join', [$key => $join], true);
        }
    }

?>
