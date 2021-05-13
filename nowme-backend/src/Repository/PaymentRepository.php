<?php

namespace NowMe\Repository;

use NowMe\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function save(Payment $payment) : void
    {
        $this->getEntityManager()->persist($payment);
        $this->getEntityManager()->flush();
    }

    public function getByOrderId(string $orderId): Payment
    {
        $payment = $this->findOneBy(['orderId' => $orderId]);

        return $payment;
    }

    public function getByReservationId(int $reservationId): array
    {
        $payments = $this->findBy(['reservationId' => $reservationId]);

        return $payments;
    }

    public function getAllAdd(): array
    {
        $payments = $this->findBy(['status' => Payment::STATUS_ADD]);

        return $payments;
    }
}
