<?php

namespace NowMe\Controller\Api;

use NowMe\Repository\PaymentRepository;
use NowMe\Service\PayU;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractApiController
{
    private PaymentRepository $paymentRepository;
    private PayU $payU;

    public function __construct(PaymentRepository $paymentRepository, PayU $payU)
    {
        $this->paymentRepository = $paymentRepository;
        $this->payU = $payU;
    }

    #[Route('/payment', name: 'payment', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $payments = $this->paymentRepository->getAllAdd();

        foreach ($payments as $payment) {
            $this->payU->notify($payment);
            $this->paymentRepository->save($payment);
        }
        return $this->json(['status' => 'OK']);
    }
}
