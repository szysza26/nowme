<?php

namespace NowMe\Controller\Api;

use NowMe\Repository\PaymentRepository;
use NowMe\Service\PayU;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractApiController
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    #[Route('/payment', name: 'payment', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $payments = $this->paymentRepository->getAllAdd();

        $payU = new PayU();
        foreach ($payments as $payment) {
            $payU->notify($payment);
            $this->paymentRepository->save($payment);
        }
        return $this->json(['status' => 'OK']);
    }
}
