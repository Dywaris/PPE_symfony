<?php

namespace Epsi\FirstBundle\Repository;

/**
 * TestUtilisateurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TestUtilisateurRepository extends \Doctrine\ORM\EntityRepository
{
        public function deleteTestUtilisateur($id) {
        $r = $this->_em
                -> createQueryBuilder()
                ->delete($this->_entityName,'t')
                ->where('t.id=:TestUtilisateur_id')
                ->setParameter('TestUtilisateur_id',$id)
                ->getQuery();
        return 1 === $r->getScalarResult();
    }
    public function findAllModif(): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT test_utilisateur.date, test.Libelle, utilisateur.Nom, utilisateur.Prenom '
                . 'FROM test_utilisateur '
                . 'INNER JOIN test ON test_utilisateur.id = test.id '
                . 'INNER JOIN utilisateur on test_utilisateur.utilisateur_id = utilisateur.id';
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        
    }
}
