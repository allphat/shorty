<?php

namespace Alphat\Bundle\ShortyBundle\Manager;

use Alphat\Bundle\ShortyBundle\Entity\ShortyEntity;
use Alphat\Bundle\ShortyBundle\Repository\ShortyRepository;
use Alphat\Bundle\ShortyBundle\Repository\ShortyGeneratedRepository;
use Alphat\Bundle\ShortyBundle\Shortener\Shortener;

class ShortyManager
{
	private $repository;

	private $shortyGeneratedRepository;

	/**
	 * @param ShortyRepository $repository
	 */
	public function __construct(ShortyRepository $repository, ShortyGeneratedRepository $shortyGeneratedRepository)
	{
		$this->repository = $repository;
		$this->shortyGeneratedRepository = $shortyGeneratedRepository;
	}


	/**
	 * @param  string $code
	 * @return ShortyEntity
	 */
	public function findByCode($code)
	{
		return $this->repository->findByCode($code)[0];
	}

	/**
	 * @param  ShortyEntity  $short
	 */
	public function save(ShortyEntity $short)
	{
		$generated = $this->shortyGeneratedRepository->findUnusedOne();

		$short->setCode($generated->getCode());

		$generated->setIsUsed(true);

		$this->shortyGeneratedRepository->save($generated);

		$this->repository->save($short);
	}


	/**
	 * creates a 6 characters string
	 *
	 * @return string
	 */
	public function encode()
	{
		return Shortener::generateRandomUri();
	}

	/**
	 * @param  ShortyEntity $short
	 */
	public function updateCounter(ShortyEntity $short)
	{
		$short->setCounter(($short->getCounter()+1));
		$this->repository->save($short);
	}
}

