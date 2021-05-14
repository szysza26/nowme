<?php

namespace NowMe\Controller\Api;

use NowMe\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileICalController extends AbstractController
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }
    #[Route('/file-ical/generate', name: 'fileical')]
    public function index(): Response
    {
        $iCal = "";
        $iCal .= "BEGIN:VCALENDAR\n";
        $iCal .= "PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n";
        $iCal .= "VERSION:2.0\n";
        $iCal .= "CALSCALE:GREGORIAN\n";
        $iCal .= "METHOD:PUBLISH\n";

        $reservations = $this->reservationRepository->findAll();
        foreach ($reservations as $reservation) {
            $iCal .= "BEGIN:VEVENT\n";
            $iCal .= "DTSTART:" . date('Ymd\THis', $reservation->getStartTime()->getTimestamp()) . "\n";
            $iCal .= "DTEND:" . date('Ymd\THis', $reservation->getEndTime()->getTimestamp()) . "\n";
            $iCal .= "SUMMARY:" . $reservation->getService()->getName() . "\n";
            $iCal .= "END:VEVENT\n";
        }
        $iCal .= "END:VCALENDAR\n";

        header("Content-Type: text/Calendar");
        header("Content-Disposition: inline; filename=filename.ics");
        echo $iCal;
        die();
    }
}
