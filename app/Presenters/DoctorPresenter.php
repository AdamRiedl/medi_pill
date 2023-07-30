<?php


namespace app\presenters;
use App\Presenters\BasePresenter;
use App\Repositories\DoctorRepositoryInt;


class DoctorPresenter extends BasePresenter
{

    /**
     * @inject
     * @var DoctorRepositoryInt
     */
    public DoctorRepositoryInt $doctorRepositoryInt;


    public function renderdecisionBoard(): void
    {
        $this->template->patiensWithoutDoc = $this->doctorRepositoryInt->getAllPatientsWithoutDoctor();
        $this->template->numberOfPatients =  $this->doctorRepositoryInt->getNumberOfPatients();
        $this->template->patientsWithCurrentDoc = $this->doctorRepositoryInt->getAllPatientsWithCurrentDoctor($this->getUser()->getId());
    }

    public function renderpatientsTableContent(): void
    {
        $this->template->patiensWithoutDoc = $this->doctorRepositoryInt->getAllPatientsWithoutDoctor();
    }




}