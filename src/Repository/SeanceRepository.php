<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Seance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seance[]    findAll()
 * @method Seance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceRepository extends ServiceEntityRepository
{
	private PaginatorInterface $paginator;

	public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
	{
		parent::__construct($registry, Seance::class);
		$this->paginator = $paginator;
	}

	/**
	 * @param SearchData $search
	 * @return PaginationInterface
	 */
	public function findSearch(SearchData $search): PaginationInterface
	{
		$query = $this->getSearchQuery($search)->getQuery();
		return $this->paginator->paginate($query, $search->page, 5);
	}

	private function getSearchQuery(SearchData $search, $ignorePrice = false): QueryBuilder
	{
		$query = $this
			->createQueryBuilder('s')
			->select('s', 'f')
			->join('s.films', 'f');
		if (!empty($search->startShowingDate) && $ignorePrice === false) {
			$query = $query->andWhere('s.showingDate > :startDate')
				->setParameter('startDate', $search->startShowingDate->format('Y-m-d'));
		}

		if (!empty($search->endShowingDate) && $ignorePrice === false) {
			$query = $query->andWhere('s.showingDate < :date')
				->setParameter('date', $search->endShowingDate->format('Y-m-d'));
		}

		if (!empty($search->minPrice) && $ignorePrice === false) {
			$query = $query->andWhere('s.price >= :min')
				->setParameter('min', $search->minPrice);
		}

		if (!empty($search->maxPrice) && $ignorePrice === false) {
			$query = $query->andWhere('s.price <= :max')
				->setParameter('max', $search->maxPrice);
		}

		return $query
			->orderBy('s.showingDate', 'ASC');
	}

	/**
	 * @param SearchData $search
	 * @return int[]
	 */
	public function findMinMax(SearchData $search): array
	{
		$result = $this->getSearchQuery($search, true)
			->select('MIN(s.price) as min', 'MAX(s.price) as max')
			->getQuery()
			->getScalarResult();
		return [intval($result[0]['min']), intval($result[0]['max'])];
	}

	public function getQuerySeances(): Query
	{
		return $this
			->createQueryBuilder('s')
			->select('s')
			->getQuery();
	}
}
